@extends(backpack_view('blank'))

@section('before_breadcrumbs_widgets')
    <!-- Modal -->
    <div class="modal fade" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRequestModalLabel">Add Request Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="serviceProvider" class="form-label">Service Provider</label>
                            <select class="form-control" id="serviceProvider" name="serviceProvider" required>
                                <option value="" selected disabled>-- Select Service Provider --</option>
                                <option value="PPU">PPU</option>
                                <option value="ICTC">ICTC</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="serviceName" name="serviceName" required>
                        </div>

                        <div class="mb-3">
                            <label for="serviceType" class="form-label">Service Type</label>
                            <select class="form-control" id="serviceType" name="serviceType" required>
                                <option value="" selected disabled>-- Select Service Type --</option>
                                @foreach ($serviceTypes as $serviceType)
                                    <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" name="details" required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rateServiceModal" tabindex="-1" aria-labelledby="rateServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rateServiceModalLabel">Rate Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('rate.service') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="service_id" id="service_id">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating:</label>
                            <input type="range" id="rating" name="rating" min="0" max="5" step="1"
                                class="form-range">
                            <div class="rating-stars text-center"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitRatingBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    {{-- <script src="{{ asset('assets/js/bladeScript.js') }}"></script> --}}
    <h1 class="text-capitalize ms-3" bp-section="page-heading">Request Services</h1>
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary ms-auto me-3 mb-2" data-bs-toggle="modal" data-bs-target="#addRequestModal">
            <i class="la la-plus"></i>&nbsp;Add Request
        </button>
    </div>
    @if (session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Service Name</th>
                                        <th scope="col">Service Provider</th>
                                        <th scope="col">Service Type</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($services as $request)
                                        <tr>
                                            <td>{{ $request->service_name }}</td>
                                            <td>{{ $request->service_provider }}</td>
                                            <td>{{ $request->serviceType->name }}</td>
                                            <td>{{ $request->details }}</td>
                                            <td>
                                                @if ($request->status === 'Approved')
                                                    <span class="badge bg-success">{{ $request->status }}</span>
                                                @elseif($request->status === 'Cancelled')
                                                    <span class="badge bg-warning">{{ $request->status }}</span>
                                                @elseif($request->status === 'Declined')
                                                    <span class="badge bg-danger">{{ $request->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $request->status }}</span>
                                                @endif
                                            </td>
                                            @if (!$request->service_rating)
                                                @if ($request->assigned)
                                                    <td>
                                                        <button class="btn btn-warning btn-sm rate-btn"
                                                            data-id="{{ $request->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#rateServiceModal">
                                                            <i class="la la-star"></i>&nbsp;Rate
                                                        </button>
                                                    </td>
                                                @endif
                                            @else
                                                <td>
                                                    @if ($request->service_rating >= 1)
                                                        <i class="las la-star text-warning"></i>
                                                    @else
                                                        <i class="las la-star text-secondary"></i>
                                                    @endif

                                                    @if ($request->service_rating >= 2)
                                                        <i class="las la-star text-warning"></i>
                                                    @else
                                                        <i class="las la-star text-secondary"></i>
                                                    @endif

                                                    @if ($request->service_rating >= 3)
                                                        <i class="las la-star text-warning"></i>
                                                    @else
                                                        <i class="las la-star text-secondary"></i>
                                                    @endif

                                                    @if ($request->service_rating >= 4)
                                                        <i class="las la-star text-warning"></i>
                                                    @else
                                                        <i class="las la-star text-secondary"></i>
                                                    @endif

                                                    @if ($request->service_rating >= 5)
                                                        <i class="las la-star text-warning"></i>
                                                    @else
                                                        <i class="las la-star text-secondary"></i>
                                                    @endif
                                                </td>
                                            @endif

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center alert alert-danger">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-4 mb-3">
                                {{ $services->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/request.js') }}"></script>
    <script>
        @if (session('success'))
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        @endif
    </script>
    <style>
        .rating-stars {
            font-size: 50px;
            color: gold;
        }
    </style>
@endsection
