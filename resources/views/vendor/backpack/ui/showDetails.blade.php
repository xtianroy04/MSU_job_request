@extends(backpack_view('blank'))

@section('before_breadcrumbs_widgets')
    <link rel="stylesheet" href="{{ asset('timeline/timeline-7.css') }}">
    <!-- Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackModalLabel"><i class="la la-tv"></i>&nbsp;Track service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bsb-timeline-7 bg-light py-3 py-md-5 py-xl-8 mt-0">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-10 col-md-12 col-xl-10 col-xxl-9">
                                    <ul class="timeline">

                                        @if ($service->service_rating)
    <li class="timeline-item">
        <div class="timeline-body">
            <div class="timeline-meta">
                <div class="d-inline-flex flex-column px-2 py-1 text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 text-md-end">
                    <span class="fw-bold">Rated On:</span>
                    <span>{{ date('F j, Y', strtotime($service->date_rated)) }}</span>
                </div>
            </div>
            <div class="timeline-content timeline-indicator">
                <div class="card border-0 shadow">
                    <div class="card-body p-xl-4">
                        <h2 class="card-title mb-2">
                            {{ $service->assignedPersonnel->first_name }}
                            {{ $service->assignedPersonnel->last_name }}
                        </h2>
                        <h6 class="card-subtitle text-secondary mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $service->service_rating)
                                    <i class="las la-star text-warning"></i>
                                @else
                                    <i class="las la-star text-secondary"></i>
                                @endif
                            @endfor
                            {{ $service->service_rating }}/5
                        </h6>
                        <p class="card-text m-0">Thank you for choosing our service. Your feedback helps us improve.</p>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif


                                        @if ($service->date_served)
                                            <li class="timeline-item">
                                                <div class="timeline-body">
                                                    <div class="timeline-meta">
                                                        <div
                                                            class="d-inline-flex flex-column px-2 py-1 @if ($service->service_rating) text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle @else  text-success-emphasis bg-success-subtle border border-success-subtle @endif rounded-2 text-md-end">
                                                            <span class="fw-bold">Date Served</span>
                                                            <span>{{ date('F j, Y', strtotime($service->date_served)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-content timeline-indicator">
                                                        <div class="card border-0 shadow">
                                                            <div class="card-body p-xl-4">
                                                                <h2 class="card-title mb-2">
                                                                    {{ $service->assignedPersonnel->first_name }}
                                                                    {{ $service->assignedPersonnel->last_name }}</h2>
                                                                <h6 class="card-subtitle text-secondary mb-3">Personnel
                                                                </h6>
                                                                <p class="card-text m-0">Your service has been completed.
                                                                    Please rate the service.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($service->assigned)
                                            <li class="timeline-item">
                                                <div class="timeline-body">
                                                    <div class="timeline-meta">
                                                        <div
                                                            class="d-inline-flex flex-column px-2 py-1 @if ($service->date_served) text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle @else  text-success-emphasis bg-success-subtle border border-success-subtle @endif rounded-2 text-md-end">
                                                            <span class="fw-bold">Date Assigned</span>
                                                            <span>{{ date('F j, Y', strtotime($service->date_assigned)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-content timeline-indicator">
                                                        <div class="card border-0 shadow">
                                                            <div class="card-body p-xl-4">
                                                                <h2 class="card-title mb-2">
                                                                    {{ $service->assignedPersonnel->first_name }}
                                                                    {{ $service->assignedPersonnel->last_name }}</h2>
                                                                <h6 class="card-subtitle text-secondary mb-3">Personnel
                                                                </h6>
                                                                <p class="card-text m-0">Your service has been assigned to a
                                                                    personnel.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($service->date_approved)
                                            <li class="timeline-item">
                                                <div class="timeline-body">
                                                    <div class="timeline-meta">
                                                        <div
                                                            class="d-inline-flex flex-column px-2 py-1 @if ($service->assigned) text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle @else  text-success-emphasis bg-success-subtle border border-success-subtle @endif rounded-2 text-md-end">
                                                            <span class="fw-bold">Date Approved</span>
                                                            <span>{{ date('F j, Y', strtotime($service->date_approved)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-content timeline-indicator">
                                                        <div class="card border-0 shadow">
                                                            <div class="card-body p-xl-4">
                                                                <h2 class="card-title mb-2">
                                                                    {{ $service->approver->first_name }}
                                                                    {{ $service->approver->last_name }}</h2>
                                                                <h6 class="card-subtitle text-secondary mb-3">Manager
                                                                </h6>
                                                                <p class="card-text m-0">Your service has been appproved.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif

                                        @if ($service->date_declined)
                                            <li class="timeline-item">
                                                <div class="timeline-body">
                                                    <div class="timeline-meta">
                                                        <div
                                                            class="d-inline-flex flex-column px-2 py-1 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2 text-md-end">
                                                            <span class="fw-bold">Date Declined</span>
                                                            <span>{{ date('F j, Y', strtotime($service->date_declined)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-content timeline-indicator">
                                                        <div class="card border-0 shadow">
                                                            <div class="card-body p-xl-4">
                                                                <h2 class="card-title mb-2">Declined</h2>
                                                                <h6 class="card-subtitle text-secondary mb-3">by Manager
                                                                </h6>
                                                                <p class="card-text m-0">Your service has been declined.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif

                                        <li class="timeline-item">
                                            <div class="timeline-body">
                                                <div class="timeline-meta">
                                                    <div
                                                        class="d-inline-flex flex-column px-2 py-1 @if ($service->date_approved || $service->status === 'Declined') text-secondary-emphasis bg-secondary-subtle border border-secondary-subtle @else  text-success-emphasis bg-success-subtle border border-success-subtle @endif rounded-2 text-md-end">
                                                        <span class="fw-bold">Date serviceed</span>
                                                        <span>{{ date('F j, Y', strtotime($service->created_at)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="timeline-content timeline-indicator">
                                                    <div class="card border-0 shadow">
                                                        <div class="card-body p-xl-4">
                                                            <h2 class="card-title mb-2">{{ $service->service_name }}</h2>
                                                            <h6 class="card-subtitle text-secondary mb-3">
                                                                {{ $service->serviceType->name }}
                                                            </h6>
                                                            <p class="card-text m-0">{{ $service->details }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <h1 class="text-capitalize" bp-section="page-heading">service Details</h1>
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary ms-auto mb-2" data-bs-toggle="modal" data-bs-target="#trackModal">
            <i class="la la-tv"></i>&nbsp;Track service
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">Service Name</th>
                    <td>{{ $service->service_name }}</td>
                </tr>
                <tr>
                    <th scope="row">Service Type</th>
                    <td>{{ $service->serviceType->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Details</th>
                    <td>{{ $service->details }}</td>
                </tr>
                <tr>
                    <th scope="row">Service Provider</th>
                    <td>{{ $service->service_provider }}</td>
                </tr>
                <tr>
                    <th scope="row">Status</th>
                    <td>
                        @if ($service->status === 'Approved')
                            <span class="badge bg-success">{{ $service->status }}</span>
                        @elseif($service->status === 'Cancelled')
                            <span class="badge bg-warning">{{ $service->status }}</span>
                        @elseif($service->status === 'Declined')
                            <span class="badge bg-danger">{{ $service->status }}</span>
                        @else
                            <span class="badge badge-secondary">{{ $service->status }}</span>
                        @endif
                    </td>
                </tr>
                @if ($service->approver)
                    <tr>
                        <th scope="row">Approved by</th>
                        <td>{{ $service->approver->first_name }} {{ $service->approver->last_name }}</td>
                    </tr>
                @endif
                @if ($service->assigned)
                    <tr>
                        <th class="scope">Assigned to</th>
                        <td>
                            {{ $service->assignedPersonnel->first_name }} {{ $service->assignedPersonnel->last_name }}
                        </td>
                    </tr>
                @endif
                @if ($service->service_rating)
                    <tr>
                        <th class="scoped">Service Rating</th>
                        <td>
                            @if ($service->service_rating >= 1)
                                <i class="las la-star text-warning"></i>
                            @else
                                <i class="las la-star text-secondary"></i>
                            @endif

                            @if ($service->service_rating >= 2)
                                <i class="las la-star text-warning"></i>
                            @else
                                <i class="las la-star text-secondary"></i>
                            @endif

                            @if ($service->service_rating >= 3)
                                <i class="las la-star text-warning"></i>
                            @else
                                <i class="las la-star text-secondary"></i>
                            @endif

                            @if ($service->service_rating >= 4)
                                <i class="las la-star text-warning"></i>
                            @else
                                <i class="las la-star text-secondary"></i>
                            @endif

                            @if ($service->service_rating >= 5)
                                <i class="las la-star text-warning"></i>
                            @else
                                <i class="las la-star text-secondary"></i>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th class="scoped">Date serviceed</th>
                    <td>{{ date('F j, Y', strtotime($service->created_at)) }}</td>
                </tr>
                @if ($service->date_approved)
                    <tr>
                        <th class="scoped">Date Approved</th>
                        <td>{{ date('F j, Y', strtotime($service->date_approved)) }}</td>
                    </tr>
                @endif
                @if ($service->date_served)
                    <tr>
                        <th class="scoped">Date Served</th>
                        <td>{{ date('F j, Y', strtotime($service->date_served)) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
