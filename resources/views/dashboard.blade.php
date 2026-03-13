@include('common')

<body>

    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
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
                                <h3>Dashboard</h3>
                            </div>

                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard"><i data-feather="home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>


                    <div class="container-fluid">
                        <div class="row">

                            <!-- Branch Filter -->
                            <div class="col-xl-4 mb-3">
                                <label>Branch</label>
                                <select class="form-select" id="branch_id" onchange="selectbranch()">
                                    <option value="">All Branch</option>

                                    @foreach ($Branches as $branch)
                                        <option value="{{ $branch->branch_id }}">
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="row mb-4" id="branchPaymentCards">
                                <!-- Cards will be rendered here via JS -->
                            </div>

                            <div class="col-xl-8 mb-3">
                            </div>


                            <!-- Lead Count -->
                            <div class="row">

                                <!-- Leads -->
                                <div class="col-xl-4 col-md-6 mb-3">
                                    <div class="card dashboard-card">
                                        <div class="card-body d-flex align-items-center">

                                            <div class="icon-box bg-green">
                                                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3
0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                                </svg>
                                            </div>

                                            <div class="ms-3">
                                                <h6 class="card-title">Leads</h6>
                                                <h3 id="d_lead">{{ $leadCount }}</h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Appointments -->
                                <div class="col-xl-4 col-md-6 mb-3">
                                    <div class="card dashboard-card">
                                        <div class="card-body d-flex align-items-center">

                                            <div class="icon-box bg-blue">
                                                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2
.9-2 2v16c0 1.1.9 2 2 2h14c1.1
0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0
18H5V10h14v11zm0-13H5V5h14v3z" />
                                                </svg>
                                            </div>

                                            <div class="ms-3">
                                                <h6 class="card-title">Appointments</h6>
                                                <h3 id="d_app">{{ $appointmentCount }}</h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Payments -->
                                <div class="col-xl-4 col-md-6 mb-3">
                                    <div class="card dashboard-card">
                                        <div class="card-body d-flex align-items-center">

                                            <div class="icon-box bg-green">
                                                <svg width="28" height="28" fill="white" viewBox="0 0 24 24">
                                                    <path d="M12 1L3 5v6c0 5.5 3.8 10.7
9 12 5.2-1.3 9-6.5 9-12V5l-9-4zm1
17.9V20h-2v-1.1c-1.7-.3-3-1.7-3-3.4h2c0
.8.7 1.5 1.5 1.5h1c.8 0 1.5-.7
1.5-1.5S13.8 14 13 14h-2c-1.7
0-3-1.3-3-3s1.3-2.7 3-3V7h2v1c1.7.3
3 1.7 3 3.4h-2c0-.8-.7-1.5-1.5-1.5h-1c-.8
0-1.5.7-1.5 1.5S10.2 12 11 12h2c1.7
0 3 1.3 3 3s-1.3 2.7-3 3z" />
                                                </svg>
                                            </div>

                                            <div class="ms-3">
                                                <h6 class="card-title">Payments</h6>
                                                <h3 id="d_payment">{{ $paymentTotal }}</h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>


                            <!-- Old vs New Customers -->
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <h5>Old vs New Customer Treatments</h5>

                                        <div class="row mb-3">

                                            <div class="col-3">
                                                <select id="date_select" class="form-control">
                                                    <option value="1">Yearly</option>
                                                    <option value="2" selected>Monthly</option>
                                                    <option value="3">Custom Range</option>
                                                </select>
                                            </div>

                                            <div class="col-3" id="year_filter">
                                                <select id="treatment_year" class="form-control">

                                                    @php
                                                        $currentYear = date('Y');
                                                    @endphp

                                                    @for ($y = $currentYear; $y >= $currentYear - 10; $y--)
                                                        <option value="{{ $y }}">{{ $y }}</option>
                                                    @endfor

                                                </select>
                                            </div>

                                            <div class="col-3 d-none" id="month_filter">
                                                <input type="month" id="treatment_month" class="form-control"
                                                    value="{{ date('Y-m') }}">
                                            </div>

                                            <div class="col-4 d-none" id="range_filter">

                                                <div class="input-group">
                                                    <input type="date" id="from_date" class="form-control">
                                                    <input type="date" id="to_date" class="form-control">
                                                </div>

                                            </div>

                                            <div class="col-2">
                                                <button id="goButton" class="btn btn-primary">Go</button>
                                            </div>

                                        </div>

                                        <div id="customerChart"></div>

                                    </div>
                                </div>

                            </div>



                            <!-- Female vs Male -->
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <h5>Male vs Female Customer Treatments</h5>

                                        <div class="row mb-3">

                                            <div class="col-3">
                                                <select id="date_select_fm" class="form-control">
                                                    <option value="1">Yearly</option>
                                                    <option value="2" selected>Monthly</option>
                                                    <option value="3">Custom Range</option>
                                                </select>
                                            </div>

                                            <div class="col-3" id="year_filter_fm">

                                                <select id="treatment_year_fm" class="form-control">

                                                    @php
                                                        $currentYear = date('Y');
                                                    @endphp

                                                    @for ($y = $currentYear; $y >= $currentYear - 10; $y--)
                                                        <option value="{{ $y }}">{{ $y }}
                                                        </option>
                                                    @endfor

                                                </select>

                                            </div>

                                            <div class="col-3 d-none" id="month_filter_fm">
                                                <input type="month" id="treatment_month_fm" class="form-control"
                                                    value="{{ date('Y-m') }}">
                                            </div>

                                            <div class="col-4 d-none" id="range_filter_fm">

                                                <div class="input-group">
                                                    <input type="date" id="from_date_fm" class="form-control">
                                                    <input type="date" id="to_date_fm" class="form-control">
                                                </div>

                                            </div>

                                            <div class="col-2">
                                                <button id="goButtonFM" class="btn btn-primary">Go</button>
                                            </div>

                                        </div>

                                        <div id="genderChart"></div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                                        <!-- Title -->
                                        <h5 class="mb-0">Schedule / Appointments</h5>

                                        <!-- Year filter + Go button -->
                                        <div class="d-flex align-items-center mt-2 mt-sm-0">
                                            <select id="appointment_year" class="form-control me-2">
                                                @php $currentYear = date('Y'); @endphp
                                                @for ($y = $currentYear; $y >= $currentYear - 10; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>
                                            <button id="goAppointment" class="btn btn-primary">Go</button>
                                        </div>
                                    </div>

                                    <!-- Chart -->
                                    <div id="appointmentChart" class="mt-3"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Treatments (This Year)</h5>
                                        <div class="row mb-3">
                                            <div class="col-2">
                                                <button id="goTreatment" class="btn btn-primary">Refresh</button>
                                            </div>
                                        </div>
                                        <div id="treatmentChart"></div>
                                        <div id="treatmentPagination"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Sales / Receipt Report</h4>

                                        <div class="row mb-3">

                                            <div class="col-md-3">
                                                <input type="date" id="receipt_from_date" class="form-control"
                                                    value="{{ date('Y-m-01') }}">
                                            </div>

                                            <div class="col-md-3">
                                                <input type="date" id="receipt_to_date" class="form-control"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>

                                            <div class="col-md-2">
                                                <button class="btn btn-primary" id="filterBtn">Go</button>
                                            </div>

                                        </div>

                                        <table class="table table-bordered" id="salesTable">

                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Date</th>
                                                    <th>Branch</th>
                                                    <th>Customer Name</th>
                                                    <th>Receipt No</th>
                                                    <th>Amount</th>
                                                    <th>Receipt</th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>





                        </div>
                    </div>


                    @include('footer')

                </div>
            </div>

            @include('script')

            <script>
                let customerChart, genderChart, appointmentChart, treatmentChart;

                $(document).ready(function() {

                    loadDashboard();

                    $('#salesTable').DataTable({
                        processing: true,
                        serverSide: false, // assuming the API just returns a JSON array based on the DashboardController
                        ajax: {
                            url: '/paymentsales-report',
                            type: 'GET',
                            data: function(d) {
                                d.branch_id = $('#branch_id').val();
                                d.from_date = $('#receipt_from_date').val();
                                d.to_date = $('#receipt_to_date').val();
                            },
                            dataSrc: ""
                        },
                        columns: [
                            { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
                            { data: 'payment_date' },
                            { data: 'branch_name' },
                            { data: 'customer_first_name' },
                            { data: 'receipt_no' },
                            { data: 'amount' },
                            { data: 'payment_id', render: function(data) {
                                return `<a href="/print_payment/${data}" target="_blank" class="btn btn-sm btn-info">Print</a>`;
                            }}
                        ]
                    });

                    $('#filterBtn').click(function() {
                        $('#salesTable').DataTable().ajax.reload();
                    });

                    $('#goButton').click(function() {
                        loadCustomerChart();
                    });

                    $('#goButtonFM').click(function() {
                        loadGenderChart();
                    });

                    $('#goAppointment').click(function() {
                        loadAppointmentChart();
                    });

                    $('#goTreatment').click(function() {
                        loadTreatmentChart();
                    });

                });


                function loadDashboard() {

                    loadCounts();

                    loadCustomerChart();

                    loadGenderChart();

                    loadAppointmentChart($("#branch_id").val(), $("#appointment_year").val());

                    loadTreatmentChart();

                }


                function selectbranch() {

                    loadDashboard();

                    $('#salesTable').DataTable().ajax.reload();

                }



                /* COUNTS */

                function loadCounts() {

                    $.get("/dashboard-count", {
                        branch_id: $("#branch_id").val()
                    }, function(res) {

                        $("#d_lead").text(res.leadCount);
                        $("#d_app").text(res.appointmentCount);
                        $("#d_payment").text(res.paymentTotal);

                        // Render branch payment cards
                        let cardsHtml = '';
                        res.branchPayments.forEach(bp => {
                            cardsHtml += `
                            <div class="col-md-4 mb-3">
                                <div class="card bg-primary text-white dashboard-card">
                                    <div class="card-body">
                                        <h6 class="card-title text-white">${bp.branch_name}</h6>
                                        <div class="d-flex justify-content-between mt-2">
                                            <span>Total: ${bp.total}</span>
                                            <span>Paid: ${bp.paid}</span>
                                            <span>Pending: ${bp.pending}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });
                        $("#branchPaymentCards").html(cardsHtml);

                    });

                }


                /* CUSTOMER CHART */

                function loadCustomerChart() {

                    let year = $('#treatment_year').val();
                    let dateFilterType = $('#date_select').val();

                    $.get("/customer-chart", {
                        branch_id: $("#branch_id").val(),
                        year: dateFilterType == '1' ? year : null
                    }, function(res) {

                        if (customerChart) customerChart.destroy();

                        customerChart = new ApexCharts(document.querySelector("#customerChart"), {
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            series: [{
                                    name: "Old Customer",
                                    data: res.old
                                },
                                {
                                    name: "New Customer",
                                    data: res.new
                                }
                            ],
                            colors: ["#0272bd", "#6acca2"],
                            xaxis: {
                                categories: res.categories
                            }
                        });

                        customerChart.render();

                    });

                }



                /* GENDER */

                function loadGenderChart() {
                    let year = $('#treatment_year_fm').val();
                    let dateFilterType = $('#date_select_fm').val();

                    $.get("/customer-chart-fm", {
                        branch_id: $("#branch_id").val(),
                        year: dateFilterType == '1' ? year : null
                    }, function(res) {

                        if (genderChart) genderChart.destroy();

                        genderChart = new ApexCharts(document.querySelector("#genderChart"), {
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            series: [{
                                    name: "Female",
                                    data: res.female
                                },
                                {
                                    name: "Male",
                                    data: res.male
                                }
                            ],
                            colors: ["#6acca2", "#0272bd"],
                            xaxis: {
                                categories: res.categories
                            }
                        });

                        genderChart.render();

                    });

                }



                /* APPOINTMENT */

                function loadAppointmentChart(branch_id = '', year = '') {

                    if(branch_id == '') branch_id = $("#branch_id").val();
                    if(year == '') year = $("#appointment_year").val();

                    $.get("/appointment-chart-simple", {
                        branch_id: branch_id,
                        year: year
                    }, function(res) {

                        let categories = res.data.map(x => x.month);
                        let counts = res.data.map(x => x.count);

                        if (appointmentChart) appointmentChart.destroy();

                        appointmentChart = new ApexCharts(document.querySelector("#appointmentChart"), {
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            series: [{
                                name: "Appointments",
                                data: counts
                            }],
                            colors: ["#0272bd"],
                            xaxis: {
                                categories: categories
                            }
                        });

                        appointmentChart.render();

                    });

                }



                /* TREATMENT */

                function loadTreatmentChart() {

                    $.get("/treatment-chart-year", {
                        branch_id: $("#branch_id").val()
                    }, function(res) {

                        let categories = res.data.map(x => x.treatment_name);
                        let counts = res.data.map(x => x.total_count);

                        if (treatmentChart) treatmentChart.destroy();

                        treatmentChart = new ApexCharts(document.querySelector("#treatmentChart"), {
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            series: [{
                                name: "Treatments",
                                data: counts
                            }],
                            colors: ["#6acca2"],
                            xaxis: {
                                categories: categories
                            }
                        });

                        treatmentChart.render();

                    });

                }
            </script>


            <style>
                .dashboard-card {
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
                    transition: 0.3s;
                }

                .dashboard-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                }

                .icon-box {
                    width: 55px;
                    height: 55px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .bg-green {
                    background: #6acca2;
                }

                .bg-blue {
                    background: #0272bd;
                }

                .card-title {
                    font-weight: 600;
                    color: #555;
                }

                .card h3 {
                    font-weight: 700;
                    margin: 0;
                }
            </style>
</body>

</html>
