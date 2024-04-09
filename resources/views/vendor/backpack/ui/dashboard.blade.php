@extends(backpack_view('blank'))

@section('content')
<div class="row d-flex justify-content-center">
    @foreach ($progressWidgets as $widget)
        <div class="col-md-3">
            <div class="{{ $widget['class'] }}">
                <div class="card-body">
                    @if(isset($widget['ribbon']) && isset($widget['ribbon']['position']) && isset($widget['ribbon']['icon']))
                        <div class="ribbon-wrapper ribbon-{{ $widget['ribbon']['position'] }}">
                            <div class="ribbon bg-primary text-lg">
                                <i class="{{ $widget['ribbon']['icon'] }}"></i>
                            </div>
                        </div>
                    @endif

                    <h5 class="card-title">{{ $widget['description'] }}</h5>
                    <p class="card-text">{{ $widget['value'] }}</p>
                    <p class="card-text">{{ $widget['hint'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if($user && strpos($user->roles, '') !== false) {
            $roles = explode(',', $user->roles);
        }
    @endphp
    @isset($roles) 
        @if(in_array('Admin', $roles) || in_array('Manager1', $roles))
            <div class="container-fluid">
                {{-- <form action="{{ route('accomplishedRequest.search') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for service..." autocomplete="off">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                @if($searchQuery)
                    <div id="searchAlert" class="alert alert-info alert-dismissible fade show" role="alert">
                        You searched for: <strong>{{ $searchQuery }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif --}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Accomplished Requests</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Service Name</th>
                                                <th scope="col">Service Provider</th>
                                                <th scope="col">Service Type</th>
                                                <th scope="col">Details</th>
                                                <th scope="col">Date Requested</th>
                                                <th scope="col">Assigned Personnel</th>
                                                <th scope="col">Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($accomplishedRequest as $request)
                                                <tr>
                                                    <td>{{ $request->service_name }}</td>
                                                    <td>{{ $request->service_provider }}</td>
                                                    <td>{{ $request->serviceType->name }}</td>
                                                    <td>{{ $request->details }}</td>
                                                    <td>{{ date('F j, Y g:i A', strtotime($request->created_at)) }}</td>
                                                    @if($request->assigned)
                                                    <td>
                                                        {{ $request->assignedPersonnel->first_name }}  {{ $request->assignedPersonnel->last_name }}
                                                    </td>
                                                    @else
                                                        <td>
                                                            None
                                                        </td>
                                                    @endif
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
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center alert alert-danger">No data found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="mt-4 mb-3">
                                        {{ $accomplishedRequest->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(in_array('Personnel', $roles))
        <div class="container-fluid">
            {{-- <form action="{{ route('accomplishedRequest.search') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for service..." autocomplete="off">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            @if($searchQuery)
                <div id="searchAlert" class="alert alert-info alert-dismissible fade show" role="alert">
                    You searched for: <strong>{{ $searchQuery }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Accomplished Requests</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Service Name</th>
                                            <th scope="col">Service Provider</th>
                                            <th scope="col">Service Type</th>
                                            <th scope="col">Details</th>
                                            <th scope="col">Date Requested</th>
                                            <th scope="col">Assigned Personnel</th>
                                            <th scope="col">Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($satisfiedRequests  as $request)
                                            <tr>
                                                <td>{{ $request->service_name }}</td>
                                                <td>{{ $request->service_provider }}</td>
                                                <td>{{ $request->serviceType->name }}</td>
                                                <td>{{ $request->details }}</td>
                                                <td>{{ date('F j, Y g:i A', strtotime($request->created_at)) }}</td>
                                                @if($request->assigned)
                                                <td>
                                                    {{ $request->assignedPersonnel->first_name }}  {{ $request->assignedPersonnel->last_name }}
                                                </td>
                                                @else
                                                    <td>
                                                        None
                                                    </td>
                                                @endif
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
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center alert alert-danger">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4 mb-3">
                                    {{ $satisfiedRequests->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(in_array('Manager2', $roles))
        <div class="container-fluid">
            {{-- <form action="{{ route('accomplishedRequest.search') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for service..." autocomplete="off">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            @if($searchQuery)
                <div id="searchAlert" class="alert alert-info alert-dismissible fade show" role="alert">
                    You searched for: <strong>{{ $searchQuery }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Need Personnel</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Service Name</th>
                                            <th scope="col">Service Provider</th>
                                            <th scope="col">Service Type</th>
                                            <th scope="col">Details</th>
                                            <th scope="col">Date Requested</th>
                                            <th scope="col">Assigned Personnel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($needPersonnelRequest  as $request)
                                            <tr>
                                                <td>{{ $request->service_name }}</td>
                                                <td>{{ $request->service_provider }}</td>
                                                <td>{{ $request->serviceType->name }}</td>
                                                <td>{{ $request->details }}</td>
                                                <td>{{ date('F j, Y g:i A', strtotime($request->created_at)) }}</td>
                                                @if($request->assigned)
                                                <td>
                                                    {{ $request->assignedPersonnel->first_name }}  {{ $request->assignedPersonnel->last_name }}
                                                </td>
                                                @else
                                                    <td>
                                                        None
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
                                    {{ $needPersonnelRequest->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
@endauth
{{-- <div class="container-fluid bg-dark text-white py-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="text-center">
                <h3 id="liveDateTime"></h3>
            </div>
        </div>
    </div>
</div> --}}

@endsection
