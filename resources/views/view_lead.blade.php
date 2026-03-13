@include('common')

<body>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        @include('header')

        <div class="page-body-wrapper">

            @include('sidebar')

            <div class="page-body">

                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>View Lead</h3>
                            </div>

                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('dashboard') }}"><i data-feather="home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('lead') }}">Lead Lists</a></li>
                                    <li class="breadcrumb-item">View Lead</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">

                                <div class="card-body">

                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <label class="form-label">Company Name</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->company_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Branch Name</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->BranchNames }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Staff Name</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->staff_name }}">
                                        </div>

                                    </div>


                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <label class="form-label">First Name</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_first_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Last Name</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_last_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Date Of Birth</label>
                                            <input class="form-control digits" type="date" readonly
                                                value="{{ $lead->lead_dob }}">
                                        </div>

                                    </div>


                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <label class="form-label">Gender</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_gender == 1 ? 'Male' : ($lead->lead_gender == 2 ? 'Female' : 'Other') }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Age</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_age }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Mobile</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_phone }}">
                                        </div>

                                    </div>


                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <label class="form-label">Email ID</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_email }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Lead Source</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_source_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Enquiry Date</label>
                                            <input class="form-control digits" type="date" readonly
                                                value="{{ $lead->enquiry_date }}">
                                        </div>

                                    </div>


                                    <div class="row mb-3">

                                        <div class="col-lg-4">
                                            <label class="form-label">Lead Status</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->lead_status_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">State</label>
                                            <input class="form-control" type="text" readonly
                                                value="{{ $lead->state_name }}">
                                        </div>

                                        <div class="col-lg-4">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" rows="1"
                                                readonly>{{ $lead->lead_address }}</textarea>
                                        </div>

                                    </div>


                                    <input type="hidden" value="{{ $lead->lead_treatment_name }}">


                                    <div class="row mb-3">

                                        <div class="col-lg-4 mt-2">
                                            <label class="form-label">Problem</label>
                                            <textarea class="form-control" rows="1"
                                                readonly>{{ $lead->lead_problem }}</textarea>
                                        </div>

                                        <div class="col-lg-4 mt-2">
                                            <label class="form-label">Remarks</label>
                                            <textarea class="form-control" rows="2"
                                                readonly>{{ $lead->lead_remark }}</textarea>
                                        </div>

                                    </div>


                                    <div class="row mb-3">
                                        <div class="card-footer text-end">

                                            <a href="{{ url('lead') }}" class="btn btn-secondary">Cancel</a>

                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @include('footer')

        </div>
    </div>

    @include('script')
    @include('session_timeout')

</body>

</html>