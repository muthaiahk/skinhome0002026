@include('common')

<body onload="startTime()">
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
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')
        <div class="page-body-wrapper">
            @include('sidebar')
            <div class="page-body">
                <div class="container-fluid">

                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Lead Status Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Lead Status Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-end">
                            <button class="btn btn-primary" id="add_new_status">Add Lead Status</button>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lead_statuses as $status)
                                    <tr id="row_{{ $status->lead_status_id }}">
                                        <td>{{ $status->lead_status_id }}</td>
                                        <td>{{ $status->lead_status_name }}</td>
                                        <td>{{ $status->lead_status_description }}</td>
                                        <td class="switch-sm">
                                            <label class="switch">
                                                <input type="checkbox" class="status_toggle"
                                                    data-id="{{ $status->lead_status_id }}"
                                                    {{ $status->status == 1 ? 'checked' : '' }}>
                                                <span class="switch-state"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="edit_status"
                                                data-id="{{ $status->lead_status_id }}">
                                                <i class="fa fa-edit text-primary"></i>
                                            </a>
                                            &nbsp;
                                            <a href="javascript:void(0)" class="delete_status"
                                                data-id="{{ $status->lead_status_id }}">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                @include('footer')
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="leadStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="leadStatusForm">
                    @csrf
                    <input type="hidden" id="lead_status_id">
                    <div class="modal-header">
                        <h5 id="modalTitle">Add Lead Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Lead Status Name</label>
                            <input type="text" class="form-control" id="lead_status_name" required>
                            <span class="text-danger" id="error_name"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="lead_status_description"></textarea>
                            <span class="text-danger" id="error_description"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="save_status">
                            <span class="spinner-border spinner-border-sm d-none" role="status" id="loading"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lead_status_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Lead Status?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="delete_btn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')

    <script>
    $(document).ready(function() {

        // Open Add Modal
        $('#add_new_status').click(function() {
            $('#modalTitle').text('Add Lead Status');
            $('#lead_status_id').val('');
            $('#lead_status_name').val('');
            $('#lead_status_description').val('');
            $('#error_name, #error_description').text('');
            $('#leadStatusModal').modal('show');
        });

        // Save/Add or Edit
        $('#leadStatusForm').submit(function(e) {
            e.preventDefault();
            $('#loading').removeClass('d-none'); // show spinner
            let id = $('#lead_status_id').val();
            let url = id ? '/lead_status/' + id : '/lead_status';
            let method = id ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                type: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    lead_status_name: $('#lead_status_name').val(),
                    lead_status_description: $('#lead_status_description').val()
                },
                success: function(res) {
                    toastr.success(res.success);
                    location.reload();
                },
                error: function(xhr) {
                    $('#error_name').text(xhr.responseJSON.errors.lead_status_name || '');
                    $('#error_description').text(xhr.responseJSON.errors
                        .lead_status_description || '');
                },
                complete: function() {
                    $('#loading').addClass('d-none'); // hide spinner
                }
            });
        });

        // Edit
        $('.edit_status').click(function() {
            let id = $(this).data('id');
            $.get('/lead_status/' + id + '/edit', function(data) {
                $('#modalTitle').text('Edit Lead Status');
                $('#lead_status_id').val(data.lead_status_id);
                $('#lead_status_name').val(data.lead_status_name);
                $('#lead_status_description').val(data.lead_status_description);
                $('#error_name, #error_description').text('');
                $('#leadStatusModal').modal('show');
            });
        });

        // Delete
        let delete_id = null;

        // Open Delete Modal
        $('.delete_status').click(function() {
            delete_id = $(this).data('id');
            $('#lead_status_delete').modal('show');
        });

        // Confirm Delete
        $('#delete_btn').click(function() {
            if (!delete_id) return;

            $.ajax({
                url: '/lead_status/' + delete_id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#delete_btn').prop('disabled', true).text('Deleting...');
                },
                success: function(res) {
                    toastr.success(res.success);
                    $('#row_' + delete_id).remove();
                    $('#lead_status_delete').modal('hide');
                },
                error: function() {
                    toastr.error('Failed to delete status');
                },
                complete: function() {
                    $('#delete_btn').prop('disabled', false).text('Yes, Delete');
                    delete_id = null;
                }
            });
        });

        // Toggle Status
        $(document).on('change', '.status_toggle', function() {
            let id = $(this).data('id');
            $.get('/lead_status/toggle/' + id, function(res) {
                toastr.success(res.success);
            });
        });

    });
    </script>