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
                                <h3>Lead Lists</h3>
                            </div>

                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Lead Lists</li>
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

                                <div id="status_success">

                                </div>
                                <div class="card-body">
                                    <div class="row card-header ">
                                        <div class="col-md-3">
                                            <div id="dashboard_branch_list">
                                                <!-- <label class="form-label">Branch</label> -->
                                                <select class="form-select" id="branchFilter">
                                                    <option value="">All Branch</option>

                                                    @foreach($branches as $branch)
                                                    <option value="{{ $branch->branch_name }}">
                                                        {{ $branch->branch_name }}
                                                    </option>
                                                    @endforeach

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class=" text-end">
                                                <a href="/add_lead" type="button" class="btn btn-primary" type="submit"
                                                    data-bs-original-title="" id="add_lead">Add Lead</a>
                                            </div>
                                        </div>


                                        <!-- <div class="col-md-4 position-relative">
                            <label class="form-label" for="validationTooltip01">First name</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="" data-bs-original-title="" title="">
                          <div class="valid-tooltip">Looks good!</div>
                        </div> -->
                                    </div>

                                    <!-- <div class="d-flex justify-content-end mt-2 mb-2">
                                        <div class="col-3">
                                            <input class="form-control" type="text" placeholder="Search"
                                                id='search_input'>
                                        </div>
                                    </div> -->

                                    <div id="loadingIndicator" class="text-center d-none" style="display: none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p>Loading data, please wait...</p>
                                    </div>

                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="leadTable">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Name</th>
                                                    <th>Contact Details</th>
                                                    <th>Lead Source</th>
                                                    <th>Problem</th>
                                                    <th>Lead Status</th>
                                                    <th>Flw Up Count</th>
                                                    <th>Followup / Convert</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->lead_id }}</td>
                                                    <td>
                                                        {{ $lead->lead_first_name }} {{ $lead->lead_last_name }}
                                                        <br>
                                                        <span class="badge badge-info">{{ $lead->branch_name }}</span>
                                                    </td>
                                                    <td>
                                                        {{ $lead->lead_phone }}
                                                        <br>
                                                        {{ $lead->lead_email }}
                                                    </td>
                                                    <td>{{ $lead->lead_source_name }}</td>
                                                    <td>{{ $lead->lead_problem }}</td>
                                                    <td>{{ $lead->lead_status_name }}</td>
                                                    <td>{{ $lead->followup_count ?? 0 }}</td>
                                                    <td>
                                                        <a href="#" class="badge badge-primary followup-btn"
                                                            data-id="{{ $lead->lead_id }}">Followup</a>
                                                        <br><br>
                                                        <a href="#" style="color: #000000;"
                                                            class="badge badge-secondary convert-btn"
                                                            data-id="{{ $lead->lead_id }}">Convert</a>

                                                    </td>
                                                    <td class="switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" class="status_toggle"
                                                                data-id="{{ $lead->lead_id }}"
                                                                {{ $lead->status == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('edit_lead/'.$lead->lead_id) }}">
                                                            <i class="fa fa-edit eyc"></i>
                                                        </a>
                                                        <a href="{{ url('view_lead/'.$lead->lead_id) }}">
                                                            <i class="fa fa-eye eyc"></i>
                                                        </a>
                                                        <a href="#" class="text-secondary me-2"
                                                            onclick="openFollowupHistory({{ $lead->lead_id }})">
                                                            <i class="fa fa-history"></i>
                                                        </a>
                                                        <a href="#" class="text-danger"
                                                            onclick="confirmDelete({{ $lead->lead_id }})">
                                                            <i class="fa fa-trash"></i>
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
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="lead_delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <br>
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Lead?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No, Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm_delete_btn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Follow-up Modal -->
    <div class="modal fade" id="lead_followup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Follow Up</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form wizard">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-lg-6 position-relative">
                                <label class="form-label">FollowUp Date</label>
                                <input class="form-control digits" type="date" placeholder="FollowUp Date" value=""
                                    id="followup_date">
                                <div class="text-danger" id="error_followup_date"></div>
                            </div>
                            <div class="col-lg-6 position-relative">
                                <label class="form-label">Next FollowUp Date</label>
                                <input class="form-control digits" type="date" placeholder="Next FollowUp Date" value=""
                                    id="next_followup_date">
                                <div class="text-danger" id="error_next_followup_date"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 position-relative">
                                <label class="form-label">FollowUp Count</label>
                                <input class="form-control" type="text" data-bs-original-title=""
                                    placeholder="FollowUp Count" value="1" readonly id="followup_count">
                            </div>
                            <div class="col-lg-6 position-relative">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="pn_status">
                                    <option value="0">Select Status</option>
                                    <option value="1">Positive</option>
                                    <option value="2">Negative</option>
                                </select>
                                <div class="text-danger" id="error_pn_status"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 position-relative">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-control" placeholder="Remarks" value="" id="followup_remark"
                                    rows="1"></textarea>
                                <div class="text-danger" id="error_followup_remark"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="card-footer text-end">

                                <p class="btn btn-secondary" data-bs-dismiss="modal" type="reset"
                                    data-bs-original-title="" title="">Cancel</p>
                                <p class="btn btn-primary" data-bs-original-title="" title="" onclick="add_followup();">
                                    Submit</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Follow-up History Modal -->
    <div class="modal fade" id="lead_followup_history" tabindex="-1" aria-labelledby="historyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Follow-up History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="followup_history_list">
                        <div class="text-center">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Convert Lead Modal -->
    <div class="modal fade" id="lead_to_customer" tabindex="-1" role="dialog" aria-labelledby="leadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Lead to Customer</h5>
                    <p>Are you sure you want to convert this lead to a customer?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="convert">Yes</button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
    let convert_id = null;

    // Open modal
    $(document).on('click', '.convert-btn', function(e) {
        e.preventDefault();
        convert_id = $(this).data('id');
        $('#lead_to_customer').modal('show');
    });

    // Convert lead to customer
    $('#convert').click(function() {
        if (!convert_id) {
            toastr.error("No lead selected to convert!");
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true); // disable button while processing

        $.ajax({
            url: `/convert/${convert_id}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                $('#lead_to_customer').modal('hide');
                $btn.prop('disabled', false);

                if (data.status === 200) {
                    toastr.success(data.message || "Lead converted successfully!");
                    // Remove the converted lead row
                    $(`.convert-btn[data-id="${convert_id}"]`).closest('tr').remove();
                } else if (data.status === 404) {
                    toastr.error(data.message || "Lead not found!");
                } else {
                    toastr.error(data.message || "Conversion failed!");
                }
            },
            error: function(xhr, status, error) {
                $btn.prop('disabled', false);

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    // Laravel validation errors
                    let messages = Object.values(xhr.responseJSON.errors).flat().join("<br>");
                    toastr.error(messages);
                } else if (xhr.responseJSON?.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Something went wrong!");
                }

                console.error("AJAX error:", xhr.responseText || error);
            }
        });
    });

    $('.followup-btn').click(function(e) {
        e.preventDefault(); // prevent the # link from jumping
        var leadId = $(this).data('id');
        window.lead_id = leadId; // store globally so add_followup() can access it
        $('#lead_followup').modal('show');
    });


    function add_followup() {
        var lead_id = window.lead_id; // Make sure you set lead_id globally when opening modal
        var followup_date = $("#followup_date").val();
        var next_followup_date = $("#next_followup_date").val();
        var pn_status = $("#pn_status").val();
        var followup_count = $("#followup_count").val();
        var remark = $("#followup_remark").val();

        let hasError = false;

        if (!followup_date) {
            $("#error_followup_date").html("Please fill the input fields");
            hasError = true;
        } else $("#error_followup_date").html("");

        if (!next_followup_date) {
            $("#error_next_followup_date").html("Please fill the input fields");
            hasError = true;
        } else $("#error_next_followup_date").html("");

        if (!pn_status || pn_status == 0) {
            $("#error_pn_status").html("Please select status");
            hasError = true;
        } else $("#error_pn_status").html("");

        if (hasError) return;

        $.ajax({
            url: "{{ url('/add_followup') }}",
            type: "POST",
            data: {
                lead_id: lead_id,
                followup_date: followup_date,
                next_followup_date: next_followup_date,
                app_status: pn_status,
                followup_count: followup_count,
                remark: remark,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 200) {
                    $("#lead_followup").modal('hide');
                    toastr.success("Successfully Added Followup!");
                } else {
                    toastr.error(response.message || "Something went wrong!");
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || "Error adding followup");
            }
        });
    }
    let leadToDelete = null;

    // ================= DELETE LEAD =================
    function confirmDelete(leadId) {
        leadToDelete = leadId;
        $('#lead_delete').modal('show');
    }

    $('#confirm_delete_btn').click(function() {

        if (!leadToDelete) return;

        $.ajax({
            url: '/leads/' + leadToDelete,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {

                if (res.status == 200) {

                    $('#lead-row-' + leadToDelete).remove();

                    toastr.success(res.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1500);

                } else {
                    toastr.error(res.message || 'Failed to delete lead');
                }

                $('#lead_delete').modal('hide');
                leadToDelete = null;
            },
            error: function() {
                toastr.error('Failed to delete lead');
                $('#lead_delete').modal('hide');
                leadToDelete = null;
            }
        });

    });
    </script>


    <script>
    // ================= FOLLOWUP HISTORY =================
    function openFollowupHistory(leadId) {

        $('#lead_followup_history').modal('show');
        $('#followup_history_list').html('<div class="text-center">Loading...</div>');

        $.ajax({
            url: '/followups/' + leadId + '/history',
            type: 'GET',
            dataType: 'json',

            success: function(data) {

                if (data.status == 200 && data.data.length > 0) {

                    let html = `
                <table class="table table-bordered" id="followup_history_lists">
                <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Follow-up Date</th>
                    <th>Next Follow-up</th>
                    <th>Count</th>
                    <th>Remark</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>`;

                    data.data.forEach((flw, i) => {

                        let status = flw.app_status == 1 ?
                            "<span class='text-success'>Completed</span>" :
                            "<span class='text-danger'>Pending</span>";

                        html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${flw.followup_date}</td>
                        <td>${flw.next_followup_date}</td>
                        <td>${flw.followup_count}</td>
                        <td>${flw.remark || ''}</td>
                        <td>${status}</td>
                    </tr>`;
                    });

                    html += "</tbody></table>";

                    $('#followup_history_list').html(html);

                    $('#followup_history_lists').DataTable({
                        destroy: true,
                        paging: true,
                        searching: true,
                        ordering: true
                    });

                } else {
                    $('#followup_history_list').html('<div class="text-center">No history found</div>');
                }

            },

            error: function() {
                $('#followup_history_list').html(
                    '<div class="text-danger text-center">Failed to load history</div>');
            }
        });

    }
    </script>


    <script>
    // ================= OPEN FOLLOWUP MODAL =================
    function openFollowupModal(leadId, count) {

        $('#followup_lead_id').val(leadId);
        $('#followup_count').val(count);
        $('#followup_date').val('');
        $('#next_followup_date').val('');
        $('#app_status').val(0);
        $('#remark').val('');

    }
    </script>


    <script>
    // ================= DATE VALIDATION =================
    $(document).ready(function() {

        $('#followup_date').on('change', function() {
            updateNextFollowUpDateMin();
            validateFollowUpDates();
        });

        $('#next_followup_date').on('change', function() {
            validateFollowUpDates();
        });

        function updateNextFollowUpDateMin() {

            var followUpDate = $('#followup_date').val();

            $('#next_followup_date').attr('min', followUpDate);

            $('#error_next_followup_date').text('');
            $('#next_followup_date').prop('disabled', false);
        }

        function validateFollowUpDates() {

            var followUpDate = $('#followup_date').val();
            var nextFollowUpDate = $('#next_followup_date').val();

            if (followUpDate && nextFollowUpDate) {

                if (followUpDate >= nextFollowUpDate) {

                    $('#error_next_followup_date')
                        .text('Next FollowUp Date must be after FollowUp Date.');

                    $('#next_followup_date').prop('disabled', true);

                }
            }
        }

    });
    </script>


    <script>
    // ================= DATATABLE FILTER =================
    $(document).ready(function() {

        var table = $('#leadTable').DataTable({
            pageLength: 10
        });

        $('#branchFilter').on('change', function() {

            var branch = $(this).val();

            table.column(1).search(branch).draw();

        });

    });
    </script>


    <script>
    // ================= STATUS TOGGLE =================
    $(document).ready(function() {

        $('.status_toggle').change(function() {

            var leadId = $(this).data('id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({

                url: "/lead/status/" + leadId,
                type: "POST",

                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },

                success: function(res) {

                    if (res.status == 200) {
                        toastr.success(res.message);
                    } else {
                        toastr.error('Something went wrong!');
                    }

                },

                error: function(xhr) {

                    toastr.error(xhr.responseJSON?.message || 'Error updating status');

                }

            });

        });

    });
    </script>
</body>

</html>