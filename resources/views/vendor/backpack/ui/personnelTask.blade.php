@extends(backpack_view('blank'))

@section('content')
    <h1 class="text-capitalize ms-3" bp-section="page-heading">My Tasks</h1>
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
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Service Name</th>
                                        <th scope="col">Service Provider</th>
                                        <th scope="col">Service Type</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Requested By</th>                          
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
                                                @if ($request->service_rating)
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

                                            {{-- <td>{{ date('F j, Y g:i A', strtotime($i->checkin_time)) }}</td> --}}
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
        const servicesRoute = '{{ route("personnelTask") }}';
    </script>
<script src="{{ asset('assets/js/task.js')}}"></script>
@endsection
