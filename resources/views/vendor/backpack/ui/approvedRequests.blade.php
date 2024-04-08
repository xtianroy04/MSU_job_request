@extends(backpack_view('blank'))

@section('before_breadcrumbs_widgets')
{{-- Modal for Assign Personnel --}}
<div class="modal fade" id="assignPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="assignPersonnelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignPersonnelModalLabel">Assign Personnel</h5>
            </div>
            <div class="modal-body">
                <form id="assignPersonnelForm" method="post" action="{{ route('assign.personnel') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="requestId" name="requestId" value="">
                    <div class="form-group">
                        <label for="personnel">Select Personnel:</label>
                        <select class="form-control" id="personnel" name="personnel">
                               <option value="" selected disabled>-- Select a personel --</option>
                            @foreach($personnel as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button type="button" class="btn btn-success" onclick="assignPersonnel()">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <h1 class="text-capitalize ms-3" bp-section="page-heading">Approved Requests</h1>    
    @if (session('success'))
        <div id="successMessage" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('approvedRequests') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}" autocomplete="off">
                <button type="submit" class="btn btn-primary">Search</button>
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
                                        <th scope="col">Date Approved</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($approvedServices as $request)
                                        <tr>
                                            <td>{{ $request->service_name }}</td>
                                            <td>{{ $request->service_provider }}</td>
                                            <td>{{ $request->serviceType->name }}</td>
                                            <td>{{ $request->details }}</td>
                                            <td>{{ date('F j, Y', strtotime($request->date_approved)) }}</td>
                                            @if(!$request->assigned)
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="showAssignModal('{{ $request->id }}')">
                                                        <i class="la la-plus"></i>&nbsp;Assign Personnel
                                                    </button>
                                                </td>    
                                            @else
                                                <td><p class="badge bg-success"><i class="la la-check"></i>&nbsp;Assigned</p></td>
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
                                {{ $approvedServices->links() }}
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
        const servicesRoute = '{{ route("approvedRequests") }}';
    </script>
<script src="{{ asset('assets/js/approvedRequest.js')}}"></script>
@endsection
