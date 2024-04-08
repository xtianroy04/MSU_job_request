@extends(backpack_view('blank'))

@section('before_breadcrumbs_widgets')
{{-- Modal for Approve --}}
<div class="modal fade" id="confirmationApproveModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalApproveLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalApproveLabel">Confirmation</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to approve this request?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeApproveModal()">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitApproveForm()">Confirm</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal for declining --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to decline this request?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDeclineForm()">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- <script src="{{ asset('assets/js/bladeScript.js') }}"></script> --}}
<h1 class="text-capitalize ms-3" bp-section="page-heading">Services</h1>
@if(session('success'))
    <div id="successMessage" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
{{-- Table checkin record --}}
<div class="container-fluid">
    <form action="{{ route('services.search') }}" method="GET" class="mb-3">
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
                                    <th scope="col">Date Requested</th>
                                    <th scope="col">Actions</th>
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
                                            @if($request->status === 'Approved')
                                                <span class="badge bg-success">{{ $request->status }}</span>
                                            @elseif($request->status === 'Cancelled')
                                                <span class="badge bg-warning">{{ $request->status }}</span>
                                            @elseif($request->status === 'Declined')
                                                <span class="badge bg-danger">{{ $request->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $request->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ date('F j, Y g:i A', strtotime($request->created_at)) }}</td>
                                        @if($request->status === "Pending")
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" onclick="showApproveConfirmationModal()">
                                                    <i class="la la-thumbs-up"></i>&nbsp;Approve
                                                </button>
                                                <form id="approveForm" action="{{ route('services.approve', ['id' => $request->id]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </td>                                        
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="showConfirmationModal()">
                                                    <i class="la la-thumbs-down"></i>&nbsp;Decline
                                                </button>
                                                <form id="declineForm" action="{{ route('services.decline', ['id' => $request->id]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </td>
                                        @else
                                        <td>
                                            <a href="{{ route('services.show', ['id' => $request->id]) }}" class="btn btn-success btn-sm">
                                                <i class="la la-eye"></i>&nbsp;View
                                            </a>
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
</script>
<script>
    @if(session('success'))
        setTimeout(function () {
            document.getElementById('successMessage').style.display = 'none';
        }, 5000);
    @endif
</script>
<script>
    const servicesRoute = '{{ route("services") }}';
</script>
<script src="{{ asset('assets/js/services.js')}}"></script>
@endsection