@include('common')

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

<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on top ends-->

<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    @include('header')

    <div class="page-body-wrapper">
        @include('sidebar')

        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>Staff Daily Attendance</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('dashboard') }}"><i data-feather="home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ url('attendance') }}">Attendance</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container-fluid starts-->
            <form class="form wizard">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div id="status_success"></div>

                                <div class="card-header">
                                    <div class="row mt-2">
                                        <div class="col-lg-1 mt-2">
                                            <label class="form-label" for="current_date">Date :</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <input class="form-control" type="date" id="current_date"
                                                value="{{ date('Y-m-d') }}" />
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4 text-end">
                                            <button class="btn btn-primary" id="attendanceBtn" type="button"
                                                onclick="add_attendance();">
                                                Mark Attendance
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table display" id="attendance_table">
                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Staff Name</th>
                                                    <th>Attendance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attendanceData as $index => $staff)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div>{{ $staff['name'] }}</div>
                                                            <div>{{ $staff['designation'] }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="row mb-3 custom-radio-ml">
                                                                @foreach (['present', 'permission', 'leave', 'weekoff'] as $status)
                                                                    <div
                                                                        class="col-lg-3 form-check radio radio-primary">
                                                                        <input class="form-check-input att_radio"
                                                                            type="radio"
                                                                            name="radio{{ $staff['staff_id'] }}"
                                                                            id="{{ $status }}_{{ $staff['staff_id'] }}"
                                                                            value="{{ $status }}"
                                                                            data-staff="{{ $staff['staff_id'] }}"
                                                                            onclick="att_status({{ $staff['staff_id'] }});"
                                                                            {{ $status == 'present' ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="{{ $status }}_{{ $staff['staff_id'] }}">
                                                                            {{ ucfirst($status) }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="row mb-3 custom-radio-ml"
                                                                id="att_remarks_{{ $staff['staff_id'] }}"
                                                                style="display:none;">
                                                                <div class="col-lg-6 position-relative">
                                                                    <label class="form-label">Remarks</label>
                                                                    <textarea class="form-control" placeholder="Remarks" id="leave_remarks_{{ $staff['staff_id'] }}" rows="2"></textarea>
                                                                </div>
                                                            </div>
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
            <!-- Container-fluid Ends-->
        </div>

        @include('footer')
    </div>
</div>

<!-- CSRF Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@include('script')
@include('session_timeout')

<script>
    // Toggle remarks for leave
    function att_status(staff_id) {
        var leaveRadio = document.getElementById('leave_' + staff_id);
        var remarksDiv = document.getElementById('att_remarks_' + staff_id);
        remarksDiv.style.display = leaveRadio.checked ? 'block' : 'none';
    }

    // Initialize DataTable
    $(document).ready(function() {
        $('#attendance_table').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "columnDefs": [{
                "orderable": false,
                "targets": 2
            }]
        });
    });

    // AJAX to submit attendance
    function add_attendance() {

        var btn = $("#attendanceBtn");

        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        var current_date = $("#current_date").val();

        var staffAttendanceData = [];

        // Loop through all staff rows (not only visible page)
        $("#attendance_table tbody tr").each(function() {

            var radio = $(this).find("input[type=radio]:checked");

            if (radio.length) {

                var staffId = radio.attr("name").replace("radio", "");
                var status = radio.val();

                var remarks = $("#leave_remarks_" + staffId).val() || "";

                staffAttendanceData.push({

                    staff_id: staffId,
                    present: status === 'present' ? 1 : 0,
                    permission: status === 'permission' ? 1 : 0,
                    leave: status === 'leave' ? 1 : 0,
                    weekoff: status === 'weekoff' ? 1 : 0,
                    remarks: remarks,
                    current_date: current_date

                });

            }

        });

        $.ajax({

            url: "{{ url('/add_attendance') }}",
            type: "POST",

            data: {
                att_list: staffAttendanceData,
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            dataType: "json",

            success: function(res) {

                btn.prop("disabled", false);
                btn.html("Mark Attendance");

                if (res.status == 200) {

                    toastr.success(res.message);

                    setTimeout(function() {

                        window.location.href = "{{ url('/attendance') }}";

                    }, 1500);

                } else {

                    toastr.error(res.message || "Something went wrong");

                }

            },

            error: function() {

                btn.prop("disabled", false);
                btn.html("Mark Attendance");

                toastr.error("Status update failed");

            }

        });

    }
</script>
