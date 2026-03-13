@include('common')

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
    <style id="tblcss01">
    #advance-1 {
        table-layout: fixed;
        width: 100%;
    }

    .fa-spin {
        margin-right: 6px;
    }

    #advance-1 th,
    #advance-1 td {
        text-align: center;
        vertical-align: middle;
        padding: 12px;
        word-wrap: break-word;
    }
    </style>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
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
                                <h3>Appointment</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Appointment</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="row card-header mt-4 mx-3">
                                    <div class="col-lg-3">
                                        <select class="form-select" id="branch_namess">
                                            <option value="0">All Branch</option>
                                            @foreach($Branchs as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="date" id="from_date"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="date" id="to_date"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-lg-1">
                                        <button class="btn btn-primary" id="data_filter">Go</button>
                                    </div>
                                    <div class="col-md-3">
                                        <div class=" text-end float-right">
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addAppointmentModal">
                                                Add Appointment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="table table-bordered" id="advance-1">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">Sl no</th>
                                                    <th style="width:20%">Name</th>
                                                    <th style="width:10%">Date</th>
                                                    <th style="width:10%">Time</th>
                                                    <th style="width:15%">Problem</th>
                                                    <th style="width:15%">Remarks</th>
                                                    <th style="width:15%">App.Status</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as $key => $app)
                                                <tr data-branch-id="{{ $app['branch_id'] }}">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        {{ $app['user_name'] }} <br>
                                                        <span
                                                            class="text-primary">({{ $app['user_status'] }})</span><br>
                                                        {{ $app['phone'] }}
                                                    </td>
                                                    <td>{{ $app['date'] }}</td>
                                                    <td>{{ $app['time'] }}</td>
                                                    <td>{{ $app['problem'] }}</td>
                                                    <td>{{ $app['remark'] }}</td>
                                                    <td>
                                                        @if($app['app_status']==0)
                                                        <span style="cursor:pointer;background:#f1ecec;"
                                                            class="text-primary shadow p-1 mb-1 rounded"
                                                            onclick="checkIn({{ $app['appointment_id'] }})">
                                                            <i class="fa fa-user-md"></i> Click Check In
                                                        </span>
                                                        @elseif($app['app_status']==1)
                                                        <span style="cursor:pointer;background:#f1ecec;"
                                                            class="text-danger shadow p-1 mb-1 rounded"
                                                            onclick="checkOut({{ $app['appointment_id'] }})">
                                                            <i class="fa fa-user-md"></i> Click Check Out
                                                        </span>
                                                        @elseif($app['app_status']==2)
                                                        <span class="badge bg-success">Completed</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)"
                                                            onclick="editAppointment({{ $app['appointment_id'] }})">
                                                            <i class="fa fa-edit text-primary"></i>
                                                        </a>
                                                        &nbsp;
                                                        <a href="javascript:void(0)"
                                                            onclick="viewAppointment({{ $app['appointment_id'] }})">
                                                            <i class="fa fa-eye text-success"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>
            </div>

            <div class="modal fade" id="addAppointmentModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form class="form wizard">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div id="status_success">

                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3 m-t-15 custom-radio-ml">
                                                        <div class="col-lg-3 form-check radio radio-primary">
                                                            <input class="form-check-input" id="lead_appointment_id"
                                                                type="radio" name="radio1" data-bs-original-title=""
                                                                title="" onclick="appoint_lead_status();">
                                                            <label class="form-check-label"
                                                                for="lead_appointment_id">Lead Appoinment</span></label>
                                                        </div>
                                                        <div class="col-lg-3 form-check radio radio-primary">
                                                            <input class="form-check-input" id="customer_appointment_id"
                                                                type="radio" name="radio1" data-bs-original-title=""
                                                                title="" checked onclick="appoint_lead_status();">
                                                            <label class="form-check-label"
                                                                for="customer_appointment_id">Customer
                                                                Appoinment</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-4 position-relative">
                                                            <label class="form-label">Branch</label>
                                                            <select class="form-select selectpicker" id="branch_name"
                                                                name="branch_name">
                                                                <option value="">Select Branch</option>
                                                                @foreach($Branchs as $branch)
                                                                <option value="{{ $branch->branch_id }}">
                                                                    {{ $branch->branch_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id="error_app_branch_name"></div>
                                                        </div>
                                                        <div class="col-lg-4 position-relative">
                                                            <label class="form-label">Name</label>
                                                            <select class="form-select selectpicker" id="app_user_name"
                                                                name="customer_id">
                                                                <option value="">Select Customer</option>
                                                                @foreach($Customers as $customer)
                                                                <option value="{{ $customer->customer_id }}"
                                                                    data-phone="{{ $customer->customer_phone }}">
                                                                    {{ $customer->customer_first_name }} -
                                                                    {{ $customer->customer_phone }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id="error_app_user_name"></div>

                                                        </div>

                                                        <div class="col-lg-4 position-relative">
                                                            <label class="form-label">Mobile Number</label>
                                                            <input class="form-control" type="text" id="mobile"
                                                                onkeypress="mobile_search(event)"
                                                                placeholder="Enter mobile number"
                                                                data-bs-original-title="" title="" value="">
                                                            <div class="text-danger" id="error_mobile"></div>

                                                        </div>

                                                        <div class="col-lg-4 position-relative mt-3">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label class="form-label">Choose Date</label>
                                                                    <input class="form-control digits" type="date"
                                                                        placeholder="Date" required=""
                                                                        value="<?php echo date('Y-m-d'); ?>"
                                                                        id="app_date"
                                                                        min="<?php echo date('Y-m-d'); ?>" />
                                                                    <div class="text-danger" id="error_app_date"></div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="control-label" for="timepicker">Select
                                                                        Time</label>

                                                                    <input type="time" class="form-control"
                                                                        id="timepicker" name="timepicker">

                                                                    <div class="text-danger" id="error_app_timepicker">
                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>

                                                        <div class="col-lg-4 position-relative mt-3"
                                                            id="lead_problem_box" style="display: none;">
                                                            <label class="form-label">Problem</label>
                                                            <textarea class="form-control" type="text"
                                                                data-bs-original-title="" placeholder="Problem" rows="1"
                                                                id="app_problem"></textarea>
                                                            <div class="text-danger" id="error_app_problem"></div>
                                                        </div>
                                                        <div class="col-lg-4 position-relative mt-3"
                                                            id="cus_treatment_box" style="display: block;">
                                                            <label class="form-label">Treament Name</label>
                                                            <select class="form-select" id="app_cus_treatment"
                                                                name="treatment_id">
                                                                <option value="">Select Treatment</option>
                                                                @foreach($Treatments as $treatment)
                                                                <option value="{{ $treatment->treatment_id }}">
                                                                    {{ $treatment->treatment_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id="error_app_cus_treatment"></div>
                                                        </div>

                                                        <div class="col-lg-4 position-relative mt-3">
                                                            <label class="form-label">Attended By</label>

                                                            <input class="form-control" type="text" readonly
                                                                id="app_staff_name" name="app_staff_name"
                                                                value="{{ auth()->user()->username }}">

                                                            <div class="text-danger" id="error_app_staff_name"></div>
                                                        </div>
                                                        <input type="hidden" name="user_id" id="user_id"
                                                            value="{{ auth()->id() }}">
                                                        <input type="hidden" name="company_name" id="company_name"
                                                            value="{{ $Company->company_name }}">
                                                        <input type="hidden" name="is_customer" id="is_customer">
                                                        <div class="col-lg-4 position-relative  mt-3">
                                                            <label class="form-label">Remarks</label>
                                                            <textarea class="form-control" placeholder="Remarks"
                                                                rows="1" id="app_remark"></textarea>
                                                            <div class="text-danger" id="error_app_remark"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="card-footer text-end">

                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal" title=""><a
                                                                    href='./appointment'>Cancel</a></button>
                                                            <p class="btn btn-primary" data-bs-original-title=""
                                                                title="" id="add_app" onclick="add_appointment()">Submit
                                                            </p>
                                                            <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="appointment_delete" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <br>
                            <h5 style="text-align: center;">Delete ?</h5><br>
                            <div class="mb-3">
                                <p class="col-form-label" style="text-align: center !important;">Are you sure you want
                                    to delete this Data.</p>
                            </div>
                        </div>
                        <div class="card-footer text-center mb-3">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes,
                                delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="appointment_payment" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3>Pay Here!...</h3>
                            <form>
                                <div class="form-group row">
                                    <label for="name" class="col-lg-5 col-form-label">Name</label>
                                    <div class="col-lg-7">

                                        <input type="text" readonly class="form-control-plaintext" id="app_user_name"
                                            value="">
                                        <input type="hidden" readonly class="form-control-plaintext" id="app_app_id"
                                            value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="datatime" class="col-lg-5 col-form-label">Date & Time</label>
                                    <div class="col-lg-7">

                                        <input type="text" class="form-control-plaintext" id="app_date_time"
                                            placeholder="" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="problem" class="col-lg-5 col-form-label">Problem</label>
                                    <div class="col-lg-7">

                                        <input type="text" class="form-control-plaintext" id="app_problem"
                                            placeholder="" value="">
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input p-2" type="checkbox" value="" id="paid_cash" checked>
                                    <label class="form-check-label mt-1 pl-2" for="paid_cash">
                                        Paid Cash
                                    </label>
                                </div>
                                <div class="form-group row mb-5" id="payment">
                                    <label for="problem" class="col-lg-5 col-form-label">Amount</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="app_amount" placeholder=""
                                            value="300">
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal"
                                        id="add_app_payment">Pay Now!</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="appointment_treament" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3>Treament Details Enter Here!...</h3>
                            <form>
                                <div class="form-group row">
                                    <label for="name" class="col-lg-12 col-form-label">Details</label>
                                    <div class="col-lg-12">

                                        <textarea type="text" class="form-control" row=3 id="app_treament"
                                            value=""></textarea>
                                        <input type="hidden" readonly class="form-control-plaintext" id="app_id"
                                            value="">
                                        <input type="hidden" readonly class="form-control-plaintext" id="cus_id"
                                            value="">
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal"
                                        id="add_cus_payment">Pay Now!</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- -------------------------- Remark Model ---------------------------------------------- -->
            <div class="modal fade" id="remarkModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Enter Remark</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" id="remark_app_id">

                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control" id="checkout_remark"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" onclick="saveRemark()">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- -------------------------- Edit Model ---------------------------------------------- -->
            <div class="modal fade" id="editAppointmentModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="edit_app_id">
                            <input type="hidden" name="Edit_is_customer" id="Edit_is_customer">
                            <input type="hidden" name="Edit_user_id" id="Edit_user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="Edit_is_customer" id="Edit_is_customer" value="1">
                            <input type="hidden" name="Edit_company_name" id="Edit_company_name"
                                value="{{ $Company->company_name }}">
                            <!-- Lead / Customer Toggle -->
                            <div class="row mb-3 custom-radio-ml">
                                <div class="col-lg-3 form-check radio radio-primary">
                                    <input class="form-check-input" id="edit_lead_appointment_id" type="radio"
                                        name="edit_radio" onclick="edit_appoint_lead_status();">
                                    <label class="form-check-label" for="edit_lead_appointment_id">Lead
                                        Appointment</label>
                                </div>
                                <div class="col-lg-3 form-check radio radio-primary">
                                    <input class="form-check-input" id="edit_customer_appointment_id" type="radio"
                                        name="edit_radio" onclick="edit_appoint_lead_status();">
                                    <label class="form-check-label" for="edit_customer_appointment_id">Customer
                                        Appointment</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <label>Branch</label>
                                    <select class="form-select" id="edit_branch">
                                        <option value="">Select Branch</option>
                                        @foreach($Branchs as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Customer / Lead</label>
                                    <select class="form-select" id="edit_customer">
                                        <option value="">Select Customer / Lead</option>
                                        @foreach($Customers as $customer)
                                        <option value="{{ $customer->customer_id }}"
                                            data-phone="{{ $customer->customer_phone }}">
                                            {{ $customer->customer_first_name }} - {{ $customer->customer_phone }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" id="edit_mobile">
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label>Date</label>
                                    <input type="date" class="form-control" id="edit_date">
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label>Time</label>
                                    <input type="time" class="form-control" id="edit_time">
                                </div>

                                <div class="col-lg-4 mt-3" id="edit_cus_treatment_box">
                                    <label>Treatment</label>
                                    <select class="form-select" id="edit_treatment">
                                        <option value="">Select Treatment</option>
                                        @foreach($Treatments as $treatment)
                                        <option value="{{ $treatment->treatment_id }}">{{ $treatment->treatment_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 mt-3" id="edit_lead_problem_box" style="display:none;">
                                    <label>Problem</label>
                                    <textarea class="form-control" id="edit_problem" rows="1"></textarea>
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label>Attended By</label>
                                    <input class="form-control" type="text" id="edit_staff">
                                </div>

                                <div class="col-lg-4 mt-3">
                                    <label>Remarks</label>
                                    <textarea class="form-control" id="edit_remark"></textarea>
                                </div>
                            </div>
                        </div>\
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" onclick="updateAppointment()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------- View Model ---------------------------------------------- -->
            <div class="modal fade" id="viewAppointmentModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Appointment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- General Info -->
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <p><b>Name:</b> <span id="view_name"></span></p>
                                </div>
                                <div class="col-lg-4">
                                    <p><b>Mobile:</b> <span id="view_mobile"></span></p>
                                </div>
                                <div class="col-lg-4">
                                    <p><b>Branch:</b> <span id="view_branch"></span></p>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <p><b>Date:</b> <span id="view_date"></span></p>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <p><b>Time:</b> <span id="view_time"></span></p>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <p><b>Attended By:</b> <span id="view_staff"></span></p>
                                </div>
                            </div>

                            <!-- Lead / Customer specific -->
                            <div class="row mb-3">
                                <div class="col-lg-6" id="view_cus_treatment_box">
                                    <p><b>Treatment:</b> <span id="view_treatment"></span></p>
                                </div>
                                <div class="col-lg-6" id="view_lead_problem_box">
                                    <p><b>Problem:</b> <span id="view_problem"></span></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <p><b>Remarks:</b> <span id="view_remark"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
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
        /* ==============================
            EDIT APPOINTMENT MOBILE AUTO
            ================================ */

        $('#edit_customer').on('change', function() {

            var phone = $(this).find(':selected').data('phone');

            if (phone) {
                $('#edit_mobile').val(phone);
            } else {
                $('#edit_mobile').val('');
            }

        });
        /* ==============================
           ADD APPOINTMENT MOBILE AUTO
        ================================ */

        $('#app_user_name').on('change', function() {

            var phone = $(this).find(':selected').data('phone');

            if (phone) {
                $('#mobile').val(phone);
            } else {
                $('#mobile').val('');
            }

        });
        /* =====================================
           DATATABLE SAFE INITIALIZATION
        =====================================*/

        var filterBranch = "0";
        var filterFromDate = "";
        var filterToDate = "";
        var table;

        if ($.fn.DataTable.isDataTable('#advance-1')) {
            table = $('#advance-1').DataTable();
        } else {
            table = $('#advance-1').DataTable({
                responsive: true,
                aaSorting: [],
                language: {
                    lengthMenu: "Show _MENU_"
                }
            });
        }


        /* =====================================
           BRANCH FILTER
        =====================================*/

        $('#branch_namess').on('change', function() {
            filterBranch = $(this).val();
            table.draw();
        });


        /* =====================================
           DATE FILTER
        =====================================*/

        $('#data_filter').on('click', function() {
            filterFromDate = $('#from_date').val();
            filterToDate = $('#to_date').val();
            table.draw();
        });


        /* =====================================
           DATATABLE CUSTOM FILTER
        =====================================*/

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            var rowNode = table.row(dataIndex).node();
            var rowBranch = $(rowNode).data('branch-id');
            var rowDate = data[2];

            if (filterBranch != "0" && parseInt(rowBranch) !== parseInt(filterBranch)) {
                return false;
            }

            if (filterFromDate && new Date(rowDate) < new Date(filterFromDate)) {
                return false;
            }

            if (filterToDate && new Date(rowDate) > new Date(filterToDate)) {
                return false;
            }

            return true;
        });

    });


    /* =====================================
       CHECK IN
    =====================================*/

    function checkIn(id) {

        let btn = $("span[onclick='checkIn(" + id + ")']");
        let cell = btn.closest("td");

        btn.html('<i class="fa fa-spinner fa-spin"></i> Checking...');

        $.ajax({
            url: '/appointment_status/' + id,
            type: 'GET',
            data: {
                status: 1
            },

            success: function(response) {

                toastr.success(response.message || "Checked In");

                cell.html(`
                <span style="cursor:pointer;background:#f1ecec;"
                class="text-danger shadow p-1 mb-1 rounded"
                onclick="checkOut(${id})">
                <i class="fa fa-user-md"></i> Click Check Out
                </span>
            `);
            },

            error: function() {

                toastr.error("Check In Failed");

                btn.html('<i class="fa fa-user-md"></i> Click Check In');
            }
        });
    }


    /* =====================================
       CHECK OUT
    =====================================*/

    function checkOut(id) {

        $('#remark_app_id').val(id);
        $('#checkout_remark').val('');

        $('#remarkModal').modal('show');
    }


    /* =====================================
       SAVE REMARK
    =====================================*/

    function saveRemark() {

        var id = $('#remark_app_id').val();
        var remark = $('#checkout_remark').val();

        if (remark == "") {
            toastr.error("Please enter remark");
            return;
        }

        $('#remarkModal .btn-primary').html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '/appointment_details/' + id,
            type: 'GET',
            data: {
                remark: remark
            },

            success: function() {

                updateStatus(id);
            },

            error: function() {

                toastr.error("Remark save failed");
            }
        });
    }


    /* =====================================
       UPDATE STATUS (COMPLETED)
    =====================================*/

    function updateStatus(id) {

        let cell = $("span[onclick='checkOut(" + id + ")']").closest("td");

        $.ajax({
            url: '/appointment_status/' + id,
            type: 'GET',
            data: {
                status: 2
            },

            success: function() {

                toastr.success("Check Out Completed");

                $('#remarkModal').modal('hide');

                cell.html('<span class="badge bg-success">Completed</span>');
            },

            error: function() {

                toastr.error("Checkout failed");
            }
        });
    }


    /* =====================================
       ADD APPOINTMENT
    =====================================*/

    function add_appointment() {

        $('#add_app').html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '/add_appointment',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                branch_id: $('#branch_name').val(),
                user_id: $('#app_user_name').val(),
                mobile: $('#mobile').val(),
                company_name: $('#company_name').val(),
                app_date: $('#app_date').val(),
                is_customer: $('#is_customer').val(),
                app_time: $('#timepicker').val(),
                app_treatment_id: $('#app_cus_treatment').val(),
                app_staff_name: $('#app_staff_name').val(),
                app_remark: $('#app_remark').val()
            },

            success: function(response) {

                toastr.success(response.message || "Appointment Added");

                $('#addAppointmentModal').modal('hide');

                location.reload();
            },

            error: function(xhr) {

                toastr.error(xhr.responseJSON?.message || "Something went wrong");

                $('#add_app').html('Submit');
            }
        });
    }


    /* =====================================
       LEAD / CUSTOMER TOGGLE
    =====================================*/

    var is_customer = 1;

    function appoint_lead_status() {

        if ($('#lead_appointment_id').is(':checked')) {

            $('#lead_problem_box').show();
            $('#cus_treatment_box').hide();
            is_customer = 1;

        } else {

            $('#cus_treatment_box').show();
            $('#lead_problem_box').hide();
            is_customer = 0;
        }

        $('#is_customer').val(is_customer);
    }
    </script>
</body>

</html>