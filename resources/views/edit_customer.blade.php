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
                                <h3>Modify Customer</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="customer">Customer Lists</a></li>
                                    <li class="breadcrumb-item">Modify Customer</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form wizard" id="customerUpdateForm">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success"></div>
                                    <div class="card-body">

                                        <!-- Row 1: Company / Branch / Staff -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Company Name</label>
                                                <input class="form-control" type="text" placeholder="Company Name"
                                                    value="{{ $companydetails->company_name ?? '' }}" readonly
                                                    name="company_name">
                                                <div class="text-danger" id="error_company_name"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Branch Name</label>
                                                <select class="form-select" name="branch_id">
                                                    @foreach($Branchs as $branch)
                                                    <option value="{{ $branch->branch_id }}"
                                                        {{ $customer->branch_id == $branch->branch_id ? 'selected' : '' }}>
                                                        {{ $branch->branch_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="error_branch_id"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Staff Name</label>
                                                <select class="form-select" name="staff_id">
                                                    @foreach($Staffs as $staff)
                                                    <option value="{{ $staff->staff_id }}"
                                                        {{ $customer->staff_id == $staff->staff_id ? 'selected' : '' }}>
                                                        {{ $staff->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="error_staff_id"></div>
                                            </div>
                                        </div>

                                        <!-- Row 2: Name / DOB -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control" type="text" placeholder="First Name"
                                                    value="{{ $customer->customer_first_name }}"
                                                    name="customer_first_name">
                                                <div class="text-danger" id="error_customer_first_name"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Last Name</label>
                                                <input class="form-control" type="text" placeholder="Last Name"
                                                    value="{{ $customer->customer_last_name }}"
                                                    name="customer_last_name">
                                                <div class="text-danger" id="error_customer_last_name"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Date Of Birth</label>
                                                <input class="form-control digits" type="date"
                                                    value="{{ $customer->customer_dob }}" name="customer_dob">
                                                <div class="text-danger" id="error_customer_dob"></div>
                                            </div>
                                        </div>

                                        <!-- Row 3: Gender / Age / Mobile -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Gender</label>
                                                <select class="form-select" name="customer_gender">
                                                    <option value="1"
                                                        {{ $customer->customer_gender == '1' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="2"
                                                        {{ $customer->customer_gender == '2' ? 'selected' : '' }}>Female
                                                    </option>
                                                </select>
                                                <div class="text-danger" id="error_customer_gender"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Age</label>
                                                <input class="form-control" type="text" placeholder="Age"
                                                    value="{{ $customer->customer_age }}" name="customer_age">
                                                <div class="text-danger" id="error_customer_age"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Mobile</label>
                                                <input class="form-control" type="text" placeholder="Mobile"
                                                    value="{{ $customer->customer_phone }}" name="customer_phone">
                                                <div class="text-danger" id="error_customer_phone"></div>
                                            </div>
                                        </div>

                                        <!-- Row 4: Email / Address / State -->
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Email ID</label>
                                                <input class="form-control" type="email" placeholder="Email"
                                                    value="{{ $customer->customer_email }}" name="customer_email">
                                                <div class="text-danger" id="error_customer_email"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" placeholder="Address" rows="1"
                                                    name="customer_address">{{ $customer->customer_address }}</textarea>
                                                <div class="text-danger" id="error_customer_address"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">State Name</label>
                                                <select class="form-select" name="state_id">
                                                    @foreach(\App\Models\State::all() as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        {{ $customer->state_id == $state->state_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="error_state_id"></div>
                                            </div>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="row mb-3">
                                            <input class="form-control digits" type="hidden" placeholder="Enquiry Date"
                                                required="" value="{{ $customer->treatment_id }}" name="treatment_id"
                                                id="treatment_id">
                                            <input class="form-control digits" type="hidden" placeholder="Enquiry Date"
                                                required="" value="{{ $customer->lead_status_id }}"
                                                name="lead_status_id" id="lead_status_id">
                                            <input class="form-control digits" type="hidden" placeholder="Enquiry Date"
                                                required="" value="{{ $customer->lead_source_id }}"
                                                name="lead_source_id" id="lead_source_id">
                                            <input class="form-control digits" type="hidden" placeholder="Enquiry Date"
                                                required="" value="{{ $customer->customer_problem }}"
                                                name="customer_problem" id="customer_problem">
                                            <input class="form-control digits" type="hidden" placeholder="Enquiry Date"
                                                required="" value="{{ $customer->customer_remarks }}"
                                                name="customer_remarks" id="customer_remarks">
                                            <div class="card-footer text-end">
                                                <a href="{{ url('customer') }}" class="btn btn-secondary">Cancel</a>
                                                <button class="btn btn-primary" type="button"
                                                    id="upd_customer">Submit</button>
                                            </div>
                                        </div>

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
        $('#upd_customer').click(function() {
            let form = $('#customerUpdateForm');
            let button = $(this);

            button.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "{{ url('customer/update/'.$customer->customer_id) }}",
                type: "POST",
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    button.prop('disabled', false).text('Submit');

                    if (response.status === 200) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location
                                .reload(); // Or refresh the customer list dynamically
                        }, 1000);
                    } else {
                        toastr.error('Update failed');
                    }
                },
                error: function(xhr) {
                    button.prop('disabled', false).text('Submit');

                    if (xhr.status === 401) {
                        let errors = xhr.responseJSON.error_msg;
                        $.each(errors, function(key, value) {
                            $('#error_' + key).text(value[0]);
                        });
                        toastr.error('Please fix the errors!');
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    });
    </script>
</body>

</html>