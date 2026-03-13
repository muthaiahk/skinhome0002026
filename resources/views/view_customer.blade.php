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
                                <h3>View Customer</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="customer">Customer Lists</a></li>
                                    <li class="breadcrumb-item">View Customer</li>
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
                                <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Company Name</label>
                                            <input class="form-control"
                                                value="{{ $companydetails->company_name ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Branch Name</label>
                                            <input class="form-control"
                                                value="{{ $customer->branch->branch_name ?? '' }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Staff Name</label>
                                            <input class="form-control" value="{{ $customer->staff->name ?? '' }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>First Name</label>
                                            <input class="form-control" value="{{ $customer->customer_first_name }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Last Name</label>
                                            <input class="form-control" value="{{ $customer->customer_last_name }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date of Birth</label>
                                            <input class="form-control" type="date"
                                                value="{{ $customer->customer_dob }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Gender</label>
                                            <input class="form-control"
                                                value="{{ $customer->customer_gender == 1 ? 'Male' : 'Female' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Age</label>
                                            <input class="form-control" value="{{ $customer->customer_age }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Mobile</label>
                                            <input class="form-control" value="{{ $customer->customer_phone }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <input class="form-control" value="{{ $customer->customer_email }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="1"
                                                readonly>{{ $customer->customer_address }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label>State</label>
                                            <input class="form-control" value="{{ $customer->state->name ?? '' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div style="height: 3rem;"></div>
                                    <h5 class="mt-4">TREATMENT DETAILS</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="treatment_list">
                                            <thead>
                                                <tr>
                                                    <th>Sno</th>
                                                    <th>Treatment Categories</th>
                                                    <th>Treatment Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Status</th>
                                                    <th>Invoice</th>
                                                    <th>Amount</th>
                                                    <th>Discount</th>
                                                    <th>Paid Amount</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customerTreatments as $index => $t)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $t['tc_name'] }} <br />{{ $t['treatment_auto_id'] ?? '' }}
                                                    </td>
                                                    <td>{{ $t['treatment_name'] }}</td>
                                                    <td>{{ $t['customer_first_name'] }}</td>
                                                    <td>
                                                        @if($t['complete_status'] == 0)
                                                        <span class="text-primary">Progress</span>
                                                        @else
                                                        <span class="text-success">Completed</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $t['invoice_no'] }}</td>
                                                    <td>{{ $t['amount'] }}</td>
                                                    <td>{{ $t['discount'] }}</td>
                                                    <td>{{ $t['paid_amount'] }}</td>
                                                    <td>{{ $t['balance'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height: 3rem;"></div>
                                    {{-- Appointment Details --}}
                                    <h5 class="mt-4">APPOINTMENT DETAILS</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="appointment_list">
                                            <thead>
                                                <tr>
                                                    <th>Sno</th>
                                                    <th>Date</th>
                                                    <th>Treatment Name</th>
                                                    <th>Staff Name</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as $index => $app)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $app->date }}</td>
                                                    <td>{{ $app->treatment->treatment_name ?? '' }}</td>
                                                    <td>{{ $app->staff->name ?? '' }}</td>
                                                    <td>{{ $app->remark }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height: 3rem;"></div>
                                    {{-- Payment Details --}}
                                    <h5 class="mt-4">PAYMENT DETAILS</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="payment_list">
                                            <thead>
                                                <tr>
                                                    <th>Sno</th>
                                                    <th>Invoice</th>
                                                    <th>Receipt</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payments as $index => $pay)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $pay->invoice_no }}</td>
                                                    <td>{{ $pay->receipt_no }}</td>
                                                    <td>{{ $pay->payment_date }}</td>
                                                    <td>{{ $pay->amount }}</td>
                                                    <td>{{ $pay->balance }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="card-footer text-end">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"
                                                title=""><a href='./customer'>back</a></button>
                                            <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </div>
                <!-- footer start-->
                @include('footer')
                <!-- footer start-->
            </div>
        </div>
        @include('script')

        <script>
        $(document).ready(function() {
            $("#treatment_list").DataTable({
                // "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
            $("#appointment_list").DataTable({
                // "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
            $("#payment_list").DataTable({
                // "ordering": false,
                "responsive": true,
                "aaSorting": [],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
        });
        $("#customer_appointment_details_view").kendoTooltip({
            filter: "td",
            show: function(e) {
                if (this.content.text() != "") {
                    $('[role="tooltip"]').css("visibility", "visible");
                }
            },
            hide: function() {
                $('[role="tooltip"]').css("visibility", "hidden");
            },
            content: function(e) {
                var element = e.target[0];
                if (element.offsetWidth < element.scrollWidth) {
                    return e.target.text();
                } else {
                    return "";
                }
            }
        });

        $("#customer_treatment_details_view").kendoTooltip({
            filter: "td",
            show: function(e) {
                if (this.content.text() != "") {
                    $('[role="tooltip"]').css("visibility", "visible");
                }
            },
            hide: function() {
                $('[role="tooltip"]').css("visibility", "hidden");
            },
            content: function(e) {
                var element = e.target[0];
                if (element.offsetWidth < element.scrollWidth) {
                    return e.target.text();
                } else {
                    return "";
                }
            }
        });
        </script>
        <!-- login js-->
        <!-- Plugin used-->
        @include('session_timeout')

</body>

</html>