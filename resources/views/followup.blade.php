@include('common')

<body>
    <style>
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .status-upcoming {
        background-color: #dc3545;
        color: #fff;
    }

    .status-missed {
        background-color: #ffc107;
        color: #212529;
    }

    .status-completed {
        background-color: #28a745;
        color: #fff;
    }

    .status-click-complete {
        background-color: #1b5105;
        color: #fff;
        cursor: pointer;
    }

    .status-click-complete:hover {
        background-color: #2f7a0a;
    }
    </style>

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
                                <h3>FollowUp History Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">FollowUp History Lists</li>
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
                                <div id="status_success"></div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div id="dashboard_branch_list">
                                                <select class="form-select" id="branch_name">
                                                    <option value="">Select Branch</option>
                                                    @foreach($Branchs as $branch)
                                                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" type="date" id="from_date" value="">
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" type="date" id="to_date" value="">
                                        </div>
                                        <div class="col-lg-1">
                                            <p class="btn btn-primary" id="data_filter">Go</p>
                                        </div>
                                    </div>

                                    <div class="card-body table-responsive" id='followup_list'>
                                        <table class="table table-bordered" id="followup_history_table"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>FlwUp Date</th>
                                                    <th>Next FlwUp Date</th>
                                                    <th>Problem</th>
                                                    <th>Remarks</th>
                                                    <th style="display:none;">Branch ID</th> <!-- Hidden -->
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($followups as $index => $followup)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $followup->lead_first_name }}
                                                        {{ $followup->lead_last_name }}<bR>
                                                        <span
                                                            class="badge badge-info">{{ $followup->branch_name }}</span>
                                                    </td>
                                                    <td>{{ $followup->lead_phone }}<br>{{ $followup->lead_email }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($followup->followup_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($followup->next_followup_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $followup->lead_problem ?? 'N/A' }}</td>
                                                    <td>{{ $followup->lead_remark ?? '-' }}</td>
                                                    <td style="display:none;">{{ $followup->branch_id }}</td>
                                                    <!-- Hidden branch_id -->
                                                    <td>
                                                        @if($followup->app_status == 0)
                                                        <span class="status-badge status-upcoming">
                                                            <i class="fa fa-user-md"></i> Upcoming
                                                        </span>
                                                        @elseif($followup->app_status == 1)
                                                        <span class="status-badge status-missed">
                                                            <i class="fa fa-warning"></i> Missed
                                                        </span>
                                                        @elseif($followup->app_status == 2)
                                                        <span class="status-badge status-completed">
                                                            <i class="fa fa-check"></i> Completed
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ url('view_lead/'.$followup->lead_id) }}"><i
                                                                class="fa fa-eye eyc"></i>
                                                            View</a>
                                                        @if($followup->app_status == 0 || $followup->app_status == 1)
                                                        <span class="status-badge status-click-complete"
                                                            onclick="followup_status({{ $followup->lead_id}},{{ $followup->follow_id}})"
                                                            title="Click to Complete">
                                                            <i class="text-white">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="18"
                                                                    width="14" viewBox="0 0 384 512" fill="#fff">
                                                                    <path
                                                                        d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z">
                                                                    </path>
                                                                </svg>
                                                            </i> Complete
                                                        </span>
                                                        @endif
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
                <!-- Container-fluid Ends-->
            </div>

            <!-- footer start-->
            @include('footer')
            <!-- footer end-->
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="lead_followup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Follow Up Completion</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form wizard">
                    <div class="modal-content">
                        <div class="modal-body">
                            <br>
                            <h5 style="text-align: center;">Are you sure you want to Completed this Followup.</h5><br>
                        </div>
                        <div class="card-footer text-center mb-3">
                            <input type='hidden' value="" id="follow_up_id" />
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                            <button class="btn btn-primary completed-btn" type="button" data-bs-dismiss="modal">Yes,
                                Completed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="followup_completed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <h5 style="text-align: center;"> Followup Completed</h5><br>
                    <div class="mb-3">
                        <p class="col-form-label" style="text-align: center !important;">Are you sure you want to
                            Completed this Followup.</p>
                    </div>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="completed">Yes,
                        delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="followup_history_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <h5 style="text-align: center;">Delete ?</h5><br>
                    <div class="mb-3">
                        <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete
                            this FollowUp.</p>
                    </div>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Yes, delete</button>
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')
    <script>
    $(document).ready(function() {
        $(document).on('click', '.completed-btn', function() {
            var followUpId = $('#follow_up_id').val();
            if (!followUpId) {
                toastr.error('Followup ID not found!');
                return;
            }
            $.ajax({
                url: '/followup_completed/' + followUpId,
                type: 'GET',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success('Status updated successfully');
                        // reload table to reflect status
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Something went wrong!');
                    }
                },
                error: function() {
                    toastr.error('Server error!');
                }
            });
        });
    });

    function followup_status(lead_id, flw_id) {

        $('#lead_followup').modal('show');
        $('#follow_up_id').val(lead_id);

    }
    </script>
    <script>
    $(document).ready(function() {
        // Initialize DataTable only once
        var table = $('#followup_history_table').DataTable({
            order: [],
            lengthMenu: [5, 10, 25, 50],
            language: {
                searchPlaceholder: "Search records"
            },
            columnDefs: [{
                    targets: 7,
                    visible: false
                } // Hide the Branch ID column (index 7)
            ]
        });

        // Custom filtering function for branch and date range
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedBranch = $('#branch_name').val();
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                var branchId = data[7]; // hidden branch id column index
                var followupDateStr = data[3]; // FlwUp Date column (format: d-m-Y)

                // Parse date string "dd-mm-yyyy" to yyyy-mm-dd for comparison
                function formatDate(dmy) {
                    var parts = dmy.split('-');
                    if (parts.length === 3) {
                        return parts[2] + '-' + parts[1] + '-' + parts[0];
                    }
                    return '';
                }
                var followupDate = formatDate(followupDateStr);

                if (selectedBranch && selectedBranch !== branchId) {
                    return false;
                }
                if (fromDate && followupDate < fromDate) {
                    return false;
                }
                if (toDate && followupDate > toDate) {
                    return false;
                }
                return true;
            }
        );

        // Filter button click triggers table redraw with filters applied
        $('#data_filter').on('click', function() {
            table.draw();
        });
    });
    </script>
</body>

</html>