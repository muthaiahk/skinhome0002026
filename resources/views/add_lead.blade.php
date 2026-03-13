@include('common')
<!-- <body onload="startTime()"> -->

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <!-- <div class="tap-top"><i data-feather="chevrons-up"></i></div> -->
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('header')
        <!-- Page Header Ends-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('sidebar')
            <!-- Page Sidebar Ends-->

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Add Lead</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="lead">Lead Lists</a></li>
                                    <li class="breadcrumb-item">Add Lead</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="addLeadForm">

                    @csrf

                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-sm-12">

                                <div class="card">

                                    <div class="card-body">

                                        <div class="row mb-3">

                                            <div class="col-lg-4">

                                                <label class="form-label">Company</label>

                                                <input type="text" class="form-control" name="company_name"
                                                    id="company_name" value="{{ $Companys->company_name }}" readonly>

                                                <div class="text-danger" id="error_company_name"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Branch</label>

                                                <select class="form-select" name="branch_id" id="branch_id">

                                                    <option value="">Select Branch</option>

                                                    @foreach($branches as $branch)

                                                    <option value="{{ $branch->branch_id }}">
                                                        {{ $branch->branch_name }}
                                                    </option>

                                                    @endforeach

                                                </select>

                                                <div class="text-danger" id="error_branch_id"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Staff</label>

                                                <select class="form-select" name="staff_id" id="staff_id">

                                                    <option value="">Select Staff</option>

                                                    @foreach($staffs as $staff)

                                                    <option value="{{ $staff->staff_id }}">
                                                        {{ $staff->name }}
                                                    </option>

                                                    @endforeach

                                                </select>

                                                <div class="text-danger" id="error_staff_id"></div>

                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <div class="col-lg-4">

                                                <label class="form-label">First Name</label>

                                                <input type="text" class="form-control" name="lead_first_name"
                                                    id="lead_first_name">

                                                <div class="text-danger" id="error_lead_first_name"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Last Name</label>

                                                <input type="text" class="form-control" name="lead_last_name"
                                                    id="lead_last_name">

                                                <div class="text-danger" id="error_lead_last_name"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">DOB</label>

                                                <input type="date" class="form-control" name="lead_dob" id="lead_dob">

                                                <div class="text-danger" id="error_lead_dob"></div>

                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <div class="col-lg-4">

                                                <label class="form-label">Gender</label>

                                                <select class="form-select" name="lead_gender" id="lead_gender">

                                                    <option value="">Select</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>

                                                </select>

                                                <div class="text-danger" id="error_lead_gender"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Age</label>

                                                <input type="text" class="form-control" name="lead_age" id="lead_age">

                                                <div class="text-danger" id="error_lead_age"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Mobile</label>

                                                <input type="text" class="form-control" name="lead_phone"
                                                    id="lead_phone">

                                                <div class="text-danger" id="error_lead_phone"></div>

                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <div class="col-lg-4">

                                                <label class="form-label">Email</label>

                                                <input type="email" class="form-control" name="lead_email"
                                                    id="lead_email">

                                                <div class="text-danger" id="error_lead_email"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Lead Source</label>

                                                <select class="form-select" name="lead_source_id" id="lead_source_id">

                                                    <option value="">Select</option>

                                                    @foreach($leadSources as $source)

                                                    <option value="{{ $source->lead_source_id }}">
                                                        {{ $source->lead_source_name }}
                                                    </option>

                                                    @endforeach

                                                </select>

                                                <div class="text-danger" id="error_lead_source_id"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Enquiry Date</label>

                                                <input type="date" class="form-control" name="enquiry_date"
                                                    id="enquiry_date">

                                                <div class="text-danger" id="error_enquiry_date"></div>

                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <div class="col-lg-4">

                                                <label class="form-label">Lead Status</label>

                                                <select class="form-select" name="lead_status_id" id="lead_status_id">

                                                    <option value="">Select</option>

                                                    @foreach($leadStatuses as $status)

                                                    <option value="{{ $status->lead_status_id }}">
                                                        {{ $status->lead_status_name }}
                                                    </option>

                                                    @endforeach

                                                </select>

                                                <div class="text-danger" id="error_lead_status_id"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">State</label>

                                                <select class="form-select" name="state_id" id="state_id">

                                                    <option value="">Select</option>

                                                    @foreach($states as $state)

                                                    <option value="{{ $state->state_id }}">
                                                        {{ $state->name }}
                                                    </option>

                                                    @endforeach

                                                </select>

                                                <div class="text-danger" id="error_state_id"></div>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">Address</label>

                                                <textarea class="form-control" name="lead_address"
                                                    id="lead_address"></textarea>

                                                <div class="text-danger" id="error_lead_address"></div>

                                            </div>

                                        </div>


                                        <div class="row mb-3">

                                            <div class="col-lg-6">

                                                <label class="form-label">Problem</label>

                                                <textarea class="form-control" name="lead_problem"
                                                    id="lead_problem"></textarea>

                                                <div class="text-danger" id="error_lead_problem"></div>

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">Remark</label>

                                                <textarea class="form-control" name="lead_remark"
                                                    id="lead_remark"></textarea>

                                                <div class="text-danger" id="error_lead_remark"></div>

                                            </div>

                                        </div>


                                        <div class="text-end">

                                            <button class="btn btn-secondary">
                                                <a href="{{ route('lead') }}" class="text-white text-decoration-none">
                                                    Cancel
                                                </a>
                                            </button>

                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                </form>

            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    $(document).ready(function() {

        $('#addLeadForm').submit(function(e) {

            e.preventDefault();

            $('.text-danger').html('');

            // Get the submit button
            var $btn = $(this).find('button[type="submit"]');

            // Store original button text
            var originalText = $btn.html();

            // Disable button and show loader
            $btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );

            $.ajax({

                url: "{{ route('lead.store') }}",
                type: "POST",
                data: $(this).serialize(),

                success: function(response) {
                    if (response.status == 200) {
                        toastr.success(response.message);

                        setTimeout(function() {
                            window.location.href = "{{ route('lead') }}";
                        }, 1000);
                    }
                },

                error: function(xhr) {
                    var errors = xhr.responseJSON.error_msg;
                    $.each(errors, function(key, value) {
                        $("#error_" + key).html(value[0]);
                    });
                    toastr.error(xhr.responseJSON.message);
                },

                complete: function() {
                    // Re-enable button and restore text
                    $btn.prop('disabled', false).html(originalText);
                }

            });

        });

    });
    </script>
    <script>
    $('#lead_dob').change(function(event) {
        var dobInput = $(this);
        var dob = new Date(dobInput.val());
        var currentDate = new Date();
        var eighteenYearsAgo = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate
            .getDate());

        if (dob > eighteenYearsAgo) {
            $("#error_lead_dob").html("You must be at least 18 years old.");
            dobInput.val(""); // Clear the input value
            $("#lead_age").val(""); // Clear age field
        } else {
            $("#error_lead_dob").html("");

            // Calculate age
            var age = currentDate.getFullYear() - dob.getFullYear();
            var monthDiff = currentDate.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dob.getDate())) {
                age--; // Adjust if birthday hasn't occurred yet this year
            }

            $("#lead_age").val(age); // Set age field
        }
    });
    </script>


    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>