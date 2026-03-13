@include('common')

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')
        <div class="page-body-wrapper">
            @include('sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Edit Lead</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="lead">Lead Lists</a></li>
                                    <li class="breadcrumb-item">Edit Lead</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="updateLeadForm">
                    @csrf
                    <input type="hidden" id="lead_id" value="{{ $lead->lead_id ?? 0 }}">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Row 1: Company, Branch, Staff -->
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
                                                    @isset($branches)
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}"
                                                                {{ isset($lead->branch_id) && $lead->branch_id == $branch->branch_id ? 'selected' : '' }}>
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="text-danger" id="error_branch_id"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Staff</label>
                                                <select class="form-select" name="staff_id" id="staff_id">
                                                    <option value="">Select Staff</option>
                                                    @isset($staffs)
                                                        @foreach ($staffs as $staff)
                                                            <option value="{{ $staff->staff_id }}"
                                                                {{ isset($lead->staff_id) && $lead->staff_id == $staff->staff_id ? 'selected' : '' }}>
                                                                {{ $staff->name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="text-danger" id="error_staff_id"></div>
                                            </div>
                                        </div>

                                        <!-- Row 2: First Name, Last Name, DOB -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="lead_first_name"
                                                    id="lead_first_name" value="{{ $lead->lead_first_name ?? '' }}">
                                                <div class="text-danger" id="error_lead_first_name"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="lead_last_name"
                                                    id="lead_last_name" value="{{ $lead->lead_last_name ?? '' }}">
                                                <div class="text-danger" id="error_lead_last_name"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">DOB</label>
                                                <input type="date" class="form-control" name="lead_dob"
                                                    id="lead_dob" value="{{ $lead->lead_dob ?? '' }}">
                                                <div class="text-danger" id="error_lead_dob"></div>
                                            </div>
                                        </div>

                                        <!-- Row 3: Gender, Age, Mobile -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Gender</label>
                                                <select class="form-select" name="lead_gender" id="lead_gender">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ isset($lead->lead_gender) && $lead->lead_gender == 1 ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="2"
                                                        {{ isset($lead->lead_gender) && $lead->lead_gender == 2 ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                                <div class="text-danger" id="error_lead_gender"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Age</label>
                                                <input type="text" class="form-control" name="lead_age"
                                                    id="lead_age" value="{{ $lead->lead_age ?? '' }}">
                                                <div class="text-danger" id="error_lead_age"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Mobile</label>
                                                <input type="text" class="form-control" name="lead_phone"
                                                    id="lead_phone" value="{{ $lead->lead_phone ?? '' }}">
                                                <div class="text-danger" id="error_lead_phone"></div>
                                            </div>
                                        </div>

                                        <!-- Row 4: Email, Lead Source, Enquiry Date -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="lead_email"
                                                    id="lead_email" value="{{ $lead->lead_email ?? '' }}">
                                                <div class="text-danger" id="error_lead_email"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Lead Source</label>
                                                <select class="form-select" name="lead_source_id"
                                                    id="lead_source_id">
                                                    <option value="">Select</option>
                                                    @isset($leadSources)
                                                        @foreach ($leadSources as $source)
                                                            <option value="{{ $source->lead_source_id }}"
                                                                {{ isset($lead->lead_source_id) && $lead->lead_source_id == $source->lead_source_id ? 'selected' : '' }}>
                                                                {{ $source->lead_source_name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="text-danger" id="error_lead_source_id"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Enquiry Date</label>
                                                <input type="date" class="form-control" name="enquiry_date"
                                                    id="enquiry_date" value="{{ $lead->enquiry_date ?? '' }}">
                                                <div class="text-danger" id="error_enquiry_date"></div>
                                            </div>
                                        </div>

                                        <!-- Row 5: Lead Status, State, Address -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Lead Status</label>
                                                <select class="form-select" name="lead_status_id"
                                                    id="lead_status_id">
                                                    <option value="">Select</option>
                                                    @isset($leadStatuses)
                                                        @foreach ($leadStatuses as $status)
                                                            <option value="{{ $status->lead_status_id }}"
                                                                {{ isset($lead->lead_status_id) && $lead->lead_status_id == $status->lead_status_id ? 'selected' : '' }}>
                                                                {{ $status->lead_status_name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="text-danger" id="error_lead_status_id"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">State</label>
                                                <select class="form-select" name="state_id" id="state_id">
                                                    <option value="">Select</option>
                                                    @isset($states)
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->state_id }}"
                                                                {{ isset($lead->state_id) && $lead->state_id == $state->state_id ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                <div class="text-danger" id="error_state_id"></div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="lead_address" id="lead_address">{{ $lead->lead_address ?? '' }}</textarea>
                                                <div class="text-danger" id="error_lead_address"></div>
                                            </div>
                                        </div>

                                        <!-- Row 6: Problem, Remark -->
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                                <label class="form-label">Problem</label>
                                                <textarea class="form-control" name="lead_problem" id="lead_problem">{{ $lead->lead_problem ?? '' }}</textarea>
                                                <div class="text-danger" id="error_lead_problem"></div>
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label">Remark</label>
                                                <textarea class="form-control" name="lead_remark" id="lead_remark">{{ $lead->lead_remark ?? '' }}</textarea>
                                                <div class="text-danger" id="error_lead_remark"></div>
                                            </div>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="text-end">
                                            <button class="btn btn-secondary">
                                                <a href="{{ route('lead') }}"
                                                    class="text-white text-decoration-none">Cancel</a>
                                            </button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            @include('footer')
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
        $(document).ready(function() {

            $('#updateLeadForm').submit(function(e) {

                e.preventDefault();
                let id = $('#lead_id').val();

                $.ajax({
                    url: "/update_lead/" + id,
                    type: "POST",
                    data: $(this).serialize(),

                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href = "/lead";
                            }, 1000);
                        }
                    },

                    error: function(xhr) {
                        var errors = xhr.responseJSON.error_msg;
                        $.each(errors, function(key, value) {
                            $("#error_" + key).html(value[0]);
                        });
                    }
                });
            });

            $('#lead_dob').change(function(event) {
                var dobInput = $(this);
                var dob = new Date(dobInput.val());
                var currentDate = new Date();
                var eighteenYearsAgo = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(),
                    currentDate.getDate());

                if (dob > eighteenYearsAgo) {
                    $("#error_lead_dob").html("You must be at least 18 years old.");
                    dobInput.val("");
                    $("#lead_age").val("");
                } else {
                    $("#error_lead_dob").html("");
                    var age = currentDate.getFullYear() - dob.getFullYear();
                    var monthDiff = currentDate.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dob.getDate())) {
                        age--;
                    }
                    $("#lead_age").val(age);
                }
            });
        });
    </script>
</body>

</html>
