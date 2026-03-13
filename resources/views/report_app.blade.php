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
                                <h3>Appointment Report</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Appointment Report</li>
                                    <!--    <li class="breadcrumb-item"><a href="/add_product">Add New</a></li> -->
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <form method="GET" action="{{ route('report.appointment') }}" class="row g-3 mb-3">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3 me-1">

                                            <div class="col-md-3">
                                                <label>Branch</label>
                                                <select name="branch_id" class="form-select">
                                                    <option value="">All Branch</option>
                                                    @foreach ($Branches as $branch)
                                                        <option value="{{ $branch->branch_id }}"
                                                            {{ request('branch_id') == $branch->branch_id ? 'selected' : '' }}>
                                                            {{ $branch->branch_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Treatment</label>
                                                <select name="treatment_id" class="form-select">
                                                    <option value="">All Treatment</option>
                                                    @foreach ($Treatments as $treatment)
                                                        <option value="{{ $treatment->treatment_id }}"
                                                            {{ request('treatment_id') == $treatment->treatment_id ? 'selected' : '' }}>
                                                            {{ $treatment->treatment_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Date Range</label>
                                                <div class="input-group">
                                                    <input type="date" name="from_date" class="form-control"
                                                        value="{{ request('from_date', date('Y-m-d')) }}">
                                                    <span class="input-group-text">To</span>
                                                    <input type="date" name="to_date" class="form-control"
                                                        value="{{ request('to_date', date('Y-m-d')) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">Go</button>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end">
                                                <a href="{{ route('report.appointment.export', request()->all()) }}"
                                                    class="btn btn-success">Export</a>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="appointmentTable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Company</th>
                                                        <th>Attended By</th>
                                                        <th>Treatment</th>
                                                        {{-- <th>Status</th> --}}
                                                        <th>Problem</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $row)
                                                        <tr>
                                                            <td>{{ $row->appointment_id }}</td>
                                                            <td>{{ $row->user_name }}</td>
                                                            <td>{{ $row->user_status }}</td>
                                                            <td>{{ $row->company_name }}</td>
                                                            <td>{{ $row->staff_name }}</td>
                                                            <td>{{ $row->treatment_name }}</td>
                                                            {{-- <td>{{ $row->lead_status_name }}</td> --}}
                                                            <td>{{ $row->problem }}</td>
                                                            <td>{{ $row->remark }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>


                <!-- Container-fluid Ends-->
            </div>
        </div>
        <!-- footer start-->
        @include('footer')
        <!-- footer start-->
    </div>
    </div>
    <div class="modal fade" id="lead_loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document" style="text-align:center;position:relative;top:35%;">
            <!-- <div class="modal-content"> -->
            <img src="{{ asset('assets/images/loader/loader-renew.gif') }}" style="width:50%;" />
            <!-- </div> -->
        </div>
    </div>
    @include('script')
    @include('session_timeout')

</body>

</html>
<script>
    $(document).ready(function() {

        $('#appointmentTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'csv', 'print']
        });

    });
</script>
