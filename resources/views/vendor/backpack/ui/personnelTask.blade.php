@extends(backpack_view('blank'))

@section('before_breadcrumbs_widgets')
<div class="modal fade" id="doneServiceModal" tabindex="-1" role="dialog" aria-labelledby="doneServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doneServiceModalLabel">Confirmation</h5>
            </div>
            <div class="modal-body">
                Are you sure this request is complete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-success" onclick="done()">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
    <h1 class="text-capitalize ms-3" bp-section="page-heading">My Tasks</h1>
    @if(session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('personnelTask') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search"
                    value="{{ $searchQuery ?? '' }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        @if($searchQuery)
        <div id="searchAlert" class="alert alert-info alert-dismissible fade show" role="alert">
                You searched for: <strong>{{ $searchQuery }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                                        <th scope="col">Requested By</th>      
                                        <th scope="col">Action</th>                     
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
                                                @if ($request->date_served)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge badge-secondary">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($request->service_rating)
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
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $request->user->first_name }} {{ $request->user->last_name }}</td>
                                            @if( !$request->date_served )
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" onclick="showConfirmationModal()">
                                                    <i class="la la-check"></i>&nbsp;Done
                                                </button>
                                                <form id="Form" action="{{ route('service.done', ['id' => $request->id]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
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
    <script>
        @if(session('success'))
            setTimeout(function () {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        @endif
    </script>
    <script>
        const servicesRoute = '{{ route("personnelTask") }}';
    </script>
<script src="{{ asset('assets/js/task.js')}}"></script>
@endsection
