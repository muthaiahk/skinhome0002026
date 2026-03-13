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
                                <h3>Lead Report</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Lead Report</li>
                                    <!--    <li class="breadcrumb-item"><a href="/add_product">Add New</a></li> -->
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <form method="GET" action="{{ route('report.lead') }}">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class="col-lg-3">

                                                <label class="form-label">Branch</label>

                                                <select name="branch_id" class="form-select">

                                                    <option value="">All Branch</option>

                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->branch_id }}"
                                                            {{ request('branch_id') == $branch->branch_id ? 'selected' : '' }}>

                                                            {{ $branch->branch_name }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>


                                            <div class="col-lg-3">

                                                <label class="form-label">Lead Source</label>

                                                <select name="lead_source_id" class="form-select">

                                                    <option value="">All Source</option>

                                                    @foreach ($lead_sources as $source)
                                                        <option value="{{ $source->lead_source_id }}"
                                                            {{ request('lead_source_id') == $source->lead_source_id ? 'selected' : '' }}>

                                                            {{ $source->lead_source_name }}

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>


                                            <div class="col-lg-3">

                                                <label class="form-label">From Date</label>

                                                <input type="date" name="from_date"
                                                    value="{{ request('from_date') }}" class="form-control">

                                            </div>


                                            <div class="col-lg-3">

                                                <label class="form-label">To Date</label>

                                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                                    class="form-control">

                                            </div>


                                            <div class="col-lg-12 mt-3">

                                                <button class="btn btn-primary">Filter</button>

                                                <a href="{{ route('report.lead') }}" class="btn btn-secondary">
                                                    Reset
                                                </a>

                                                <a href="{{ route('lead.report.export') }}" class="btn btn-success">
                                                    Export Excel
                                                </a>
                                            </div>

                                        </div>
                                        <div class="table-responsive product-table" id="lead_report">
                                            <div class="table-responsive">

                                                <table class="table table-bordered display" id="leadTable">

                                                    <thead>

                                                        <tr>
                                                            <th>Sl No</th>
                                                            <th>Name</th>
                                                            <th>Contact</th>
                                                            <th>Lead Source</th>
                                                            <th>Problem</th>
                                                            <th>Status</th>
                                                            <th>Next Followup</th>
                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        @foreach ($lead_report as $index => $lead)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>

                                                                <td>
                                                                    {{ $lead->lead_first_name }}
                                                                    {{ $lead->lead_last_name }}
                                                                </td>

                                                                <td>
                                                                    {{ $lead->lead_phone }} <br>
                                                                    {{ $lead->lead_email }}
                                                                </td>

                                                                <td>{{ $lead->lead_source_name }}</td>

                                                                <td>{{ $lead->lead_problem }}</td>

                                                                <td>{{ $lead->lead_status_name }}</td>

                                                                <td>
                                                                    {{ $lead->next_followup_date ? \Carbon\Carbon::parse($lead->next_followup_date)->format('d-m-Y') : '-' }}
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
                        </div>
                </form>
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


    <!-- login js-->
    <!-- Plugin used-->


    <script>
        $(document).ready(function() {

            $('#leadTable').DataTable();

        });
    </script>
</body>

</html>
