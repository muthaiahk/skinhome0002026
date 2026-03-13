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
                                <h3>Attendance Report </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Attendance Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form wizard">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row mt-3 mx-2">
                                            <div class="col-lg-3">
                                                <label class="form-label">Branch</label>
                                                <select class="form-select" id="branch_name">
                                                    <option value="0">Select Branch</option>

                                                    @foreach ($Branches as $branch)
                                                        <option value="{{ $branch->branch_id }}">
                                                            {{ $branch->branch_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <div class="text-danger" id="error_branch_id"></div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="form-label">Month</label>
                                                <input class="form-control digits" type="month" placeholder="Date"
                                                    id="attendance" required="" value="{{ date('Y-m') }}">
                                            </div>
                                            <div class="col-lg-1">
                                                <button class="btn btn-primary report_mt-4" type="button"
                                                    data-bs-original-title="" title=""
                                                    id="attendance_filter">Go</button>
                                            </div>
                                            <div class="col-lg-2">

                                            </div>
                                            <div class="col-lg-3 report_mt-4">
                                                <div class="col-lg-3 report_mt-4">
                                                    <a href="#" class="btn btn-success" id="exportBtn">Export</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive product-table" id="attendance_list">
                                            <table class="table table-bordered" id="attendance_table">

                                                <thead>

                                                    <tr>
                                                        <th>Sl No</th>
                                                        <th>Staff Name</th>

                                                        @foreach ($dates as $date)
                                                            <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                                                        @endforeach

                                                    </tr>

                                                </thead>

                                                <tbody id="attendance_body">

                                                    @foreach ($values as $index => $staff)
                                                        <tr>

                                                            <td>{{ $index + 1 }}</td>

                                                            <td>
                                                                {{ $staff['staff_name'] }} <br>
                                                                {{ $staff['designation'] }}
                                                            </td>

                                                            @foreach ($staff['dates'] as $d)
                                                                <td>

                                                                    @if ($d['status'] == 'P')
                                                                        <span class="badge bg-success">P</span>
                                                                    @elseif($d['status'] == 'PR')
                                                                        <span class="badge bg-info">PR</span>
                                                                    @elseif($d['status'] == 'L')
                                                                        <span class="badge bg-danger">L</span>
                                                                    @elseif($d['status'] == 'W')
                                                                        <span class="badge bg-primary">W</span>
                                                                    @else
                                                                        -
                                                                    @endif

                                                                </td>
                                                            @endforeach

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
                </form>
            </div>


            {{-- ----------------------------------------------------------- Modify Attendance --------------------------------------------- --}}

            <div class="modal fade" id="modifyAttendanceModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Modify Attendance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row mb-3">

                                <div class="col-lg-3">
                                    <label class="form-label">Branch Name</label>
                                    <select class="form-select" id="modal_branch_name">
                                        <option value="">Select Branch</option>

                                        @foreach ($Branches as $branch)
                                            <option value="{{ $branch->branch_id }}">
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">Staff Name</label>

                                    <div class="position-relative">

                                        <select class="form-select" id="modal_staff_name">
                                            <option value="">Select Staff</option>
                                        </select>

                                        <!-- loading spinner -->
                                        <div id="staff_loading"
                                            style="display:none; position:absolute; right:10px; top:38px;">
                                            <span class="spinner-border spinner-border-sm text-primary"></span>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">From Date</label>
                                    <input class="form-control" type="date" id="modal_from_date">
                                </div>

                                <div class="col-lg-3">
                                    <label class="form-label">To Date</label>
                                    <input class="form-control" type="date" id="modal_to_date">
                                </div>

                                <div class="col-lg-3 mt-2">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="modal_attendance_status">
                                        <option value="">Mark Attendance</option>
                                        <option value="present">Present</option>
                                        <option value="permission">Permission</option>
                                        <option value="leave">Leave</option>
                                        <option value="weekoff">Weekoff</option>
                                    </select>
                                </div>

                            </div>

                            <div class="text-end">

                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn btn-primary" onclick="update_attendance()">
                                    Submit
                                </button>

                            </div>

                            <div class="table-responsive mt-3" id="modify_attendance_list"></div>

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

    <!-- login js-->
    <!-- Plugin used-->


</body>

</html>

<script>
    function update_attendance() {

        let btn = $(".btn-primary:contains('Submit')");
        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Processing');

        $.ajax({

            url: "{{ route('update_attendance') }}",
            type: "POST",

            data: {
                staff_id: $("#modal_staff_name").val(),
                from_date: $("#modal_from_date").val(),
                to_date: $("#modal_to_date").val(),
                status: $("#modal_attendance_status").val(),
                _token: "{{ csrf_token() }}"
            },

            success: function(res) {

                btn.prop("disabled", false);
                btn.html("Submit");

                if (res.status == 200) {
                    toastr.success(res.message);
                    $("#modifyAttendanceModal").modal("hide");
                }

            },

            error: function() {

                btn.prop("disabled", false);
                btn.html("Submit");

                toastr.error("Something went wrong");

            }

        });

    }
    $(document).ready(function() {

        $("#modal_branch_name").change(function() {

            let branch_id = $(this).val();

            if (branch_id == "") {
                $("#modal_staff_name").html('<option value="">Select Staff</option>');
                return;
            }

            $("#staff_loading").show();

            $.ajax({

                url: "{{ url('/get_branch_staff') }}",
                type: "POST",

                data: {
                    branch_id: branch_id,
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {

                    let options = '<option value="">Select Staff</option>';

                    res.staff.forEach(function(staff) {

                        options += '<option value="' + staff.staff_id + '">' + staff
                            .name + '</option>';

                    });

                    $("#modal_staff_name").html(options);

                    $("#staff_loading").hide();

                },

                error: function() {

                    $("#staff_loading").hide();

                    alert("Failed to load staff");

                }

            });

        });

    });
    $(document).ready(function() {

        let table = $('#attendance_table').DataTable();

        $("#attendance_filter").click(function() {

            let branch_id = $("#branch_name").val();
            let month = $("#attendance").val();

            $.ajax({

                url: "{{ route('attendance.filter') }}",
                type: "POST",

                data: {
                    branch_id: branch_id,
                    month: month,
                    _token: "{{ csrf_token() }}"
                },

                success: function(res) {

                    table.destroy();

                    let header = "<tr><th>Sl No</th><th>Staff Name</th>";

                    res.dates.forEach(function(date) {

                        let d = new Date(date);
                        header += "<th>" + d.getDate() + "</th>";

                    });

                    header += "</tr>";

                    $("#attendance_table thead").html(header);

                    let body = "";

                    res.values.forEach(function(staff, index) {

                        body += "<tr>";

                        body += "<td>" + (index + 1) + "</td>";

                        body += "<td>" + staff.staff_name + "<br>" + staff
                            .designation + "</td>";

                        staff.dates.forEach(function(d) {

                            let badge = "-";

                            if (d.status == "P")
                                badge =
                                '<span class="badge bg-success">P</span>';

                            if (d.status == "PR")
                                badge =
                                '<span class="badge bg-info">PR</span>';

                            if (d.status == "L")
                                badge =
                                '<span class="badge bg-danger">L</span>';

                            if (d.status == "W")
                                badge =
                                '<span class="badge bg-primary">W</span>';

                            body += "<td>" + badge + "</td>";

                        });

                        body += "</tr>";

                    });

                    $("#attendance_body").html(body);

                    table = $('#attendance_table').DataTable();

                }

            });

        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#exportBtn').click(function(e) {
            e.preventDefault();

            let branch_id = $('#branch_name').val();
            let month = $('#attendance').val();

            let url = "{{ route('attendance.export') }}" +
                "?branch_id=" + branch_id +
                "&month=" + month;

            window.location.href = url;
        });
    });
</script>
