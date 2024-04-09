@extends(backpack_view('blank'))

@section('content')
<div id="printable-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body m-2">
                        <div class="text-center">
                            <h2 class="mb-1">Republic of the Philippines</h1>
                            <h3 class="mb-1">MINDANAO STATE UNIVERSITY AT NAAWAN</h2>
                            <h4>9023 Naawan, Misamis Oriental</h3>
                        </div>

                        <hr>
                        <h1 class="text-center" style="text-decoration: underline">Service Request Form</h1>
                        <div class="form-group row">
                            <label for="serviceProvider" class="col-md-4 col-form-label text-md-right">Service Provider:</label>
                            <div class="col-md-6 mt-2">
                                <strong>{{ $service->service_provider }}</strong>
                            </div>
                            <label for="serviceProvider" class="col-md-4 col-form-label text-md-right">S.R. No:</label>
                            <div class="col-md-6 mt-2">
                                <strong>{{ $service->user->costCenter->code }}</strong>
                            </div>
                        </div>

                        
                       
                        <div class="form-group row">
                            <label for="serviceRequester" class="col-md-4 col-form-label text-md-right">Service Requester:</label>
                            <div class="col-md-6 mt-2">
                                <strong>{{ $service->user->costCenter->name }}</strong>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="serviceRequester" class="col-md-4 col-form-label text-md-right">Name of Service:</label>
                            <div class="col-md-6 mt-2">
                                <strong>{{ $service->service_name }}</strong>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">Details:</label>
                            <div class="col-md-6 mt-2">
                                {{ $service->details }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="serviceRequester" class="col-md-4 col-form-label text-md-right">Requested By:</label>
                            <div class="col-md-6 mt-2">
                                {{ $service->user->first_name }} {{ $service->user->last_name }}
                            </div>
                        </div>

                        <p class="mt-4"><b>I hereby acknowledge that the service requested is vital to the function and operation of this office.</b></p>
                        
                        @if($service->approver)
                        <div class="form-group row">
                            <label for="approvedBy" class="col-md-4 col-form-label text-md-right">Approved by:</label>
                            <div class="col-md-6 mt-2">
                                {{ $service->approver->first_name }} {{ $service->approver->last_name }}
                            </div>
                        </div>
                        @endif
                        @if($service->status === "Declined")
                            <div class="form-group text-center">
                                <div class="col-md-12">
                                    <img src="{{ asset('images/declined.png') }}" alt="declined" width="250px">
                                </div>
                            </div>
                        @endif
                        @if($service->e_signature)
                            <div class="form-group row">
                                <label for="eSignature" class="col-md-4 col-form-label text-md-right">E-Signature:</label>
                                <div class="col-md-6 mt-2">
                                    <img src="{{ asset($service->e_signature) }}" alt="E-Signature" width="150px">
                                </div>
                            </div>
                        @endif
                        @if($service->date_approved)
                        <div class="form-group row">
                            <label for="approvedBy" class="col-md-4 col-form-label text-md-right">Date Approved:</label>
                            <div class="col-md-6 mt-2">
                                {{ date('F j, Y', strtotime($service->date_approved)) }}
                            </div>
                        </div>
                        @endif

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-4">
    <button class="btn btn-primary" onclick="printForm()">Print Form</button>
</div>
</div>
<script src="{{ asset('assets/js/serviceShow.js') }}"></script>
@endsection
