@include('common')

<body onload="startTime()">
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
                                <h3>Role Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Role Lists</li>
                                    <!-- <li class="breadcrumb-item active">Default</li> -->
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
                                <div id="status_success">

                                </div>
                                <div class="card-header text-end py-4">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#roleAddModal">Add Role</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="display dataTable no-footer" id="advance-1">
                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Role name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($roles as $index => $role)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $role->role_name }}</td>
                                                    <td class="media-body switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox"
                                                                onchange="role_status(this, {{ $role->role_id }})"
                                                                {{ $role->status == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <!-- <a href="{{ url('view_role?r_id=' . $role->id) }}"><i
                                                                class="fa fa-eye eyc"></i></a> -->
                                                        <a href="javascript:void(0)"
                                                            onclick="editRole({{ $role->role_id }})"><i
                                                                class="fa fa-edit eyc"></i></a>
                                                        <a href="javascript:void(0);"
                                                            onclick="openDeleteModal({{ $role->role_id }})">
                                                            <i class="fa fa-trash eyc"></i>
                                                        </a>
                                                        <a href="{{ url('add_permission?r_id=' . $role->role_id) }}">
                                                            <i class="fa fa-sliders"></i>
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

            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>

    <!-- Add Role Modal -->
    <div class="modal fade" id="roleAddModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoleForm">
                        @csrf
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="role_name" name="role_name" required>
                            <div class="invalid-feedback" id="role_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="role_description" class="form-label">Description</label>
                            <textarea class="form-control" id="role_description" name="role_description"></textarea>
                            <div class="invalid-feedback" id="role_description_error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="roleEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm">
                        @csrf
                        <input type="hidden" id="edit_role_id">
                        <div class="mb-3">
                            <label for="edit_role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="edit_role_name" name="role_name" required>
                            <div class="invalid-feedback" id="edit_role_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_role_description"
                                name="role_description"></textarea>
                            <div class="invalid-feedback" id="edit_role_description_error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="role_delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this role?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary" type="button" id="confirmDelete">Yes, delete</button>
                    <input type="hidden" id="delete_role_id">
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    function openDeleteModal(id) {
        $('#delete_role_id').val(id);
        $('#role_delete').modal('show');
    }
    $('#confirmDelete').click(function() {
        let roleId = $('#delete_role_id').val();

        $.ajax({
            url: '/delete_role/' + roleId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success(response.message);
                    $('#role_delete').modal('hide');
                    location.reload(); // refresh table
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Something went wrong');
            }
        });
    });
    // Add Role
    $('#addRoleForm').submit(function(e) {
        e.preventDefault();

        let formData = {
            role_name: $('#role_name').val(),
            role_description: $('#role_description').val(),
            _token: '{{ csrf_token() }}' // <-- add CSRF token here
        };

        $.ajax({
            url: '/add_role',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success(response.message);
                    $('#roleAddModal').modal('hide');
                    location.reload();
                } else {
                    if (response.error_msg.role_name) {
                        $('#role_name_error').text(response.error_msg.role_name[0]).show();
                        $('#role_name').addClass('is-invalid');
                    }
                }
            },
            error: function() {
                toastr.error('Something went wrong');
            }
        });
    });
    // Open Edit Modal and fill data
    function editRole(id) {
        $.ajax({
            url: '/edit_role/' + id,
            type: 'GET',
            success: function(response) {
                if (response.status == 200 && response.data) {
                    let role = response.data;
                    $('#edit_role_id').val(role.role_id);
                    $('#edit_role_name').val(role.role_name);
                    $('#edit_role_description').val(role.role_description);
                    $('#roleEditModal').modal('show');
                }
            }
        });
    }

    $('#editRoleForm').submit(function(e) {
        e.preventDefault();

        let roleId = $('#edit_role_id').val();

        let formData = {
            role_name: $('#edit_role_name').val(),
            role_description: $('#edit_role_description').val(),
            _token: '{{ csrf_token() }}' // <-- add CSRF token here
        };

        $.ajax({
            url: '/update_role/' + roleId,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success('Role updated successfully');
                    $('#roleEditModal').modal('hide');
                    location.reload(); // refresh table
                } else {
                    toastr.error(response.message);
                    // show validation errors
                    if (response.error_msg && response.error_msg.role_name) {
                        $('#edit_role_name_error').text(response.error_msg.role_name[0]).show();
                        $('#edit_role_name').addClass('is-invalid');
                    }
                }
            },
            error: function() {
                toastr.error('Something went wrong');
            }
        });
    });

    function role_status(el, id) {
        let status = el.checked ? 1 : 0; // dynamically get status

        $.ajax({
            url: '/role/status/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                    el.checked = !el.checked; // revert toggle if error
                }
            },
            error: function() {
                toastr.error('Failed to update status');
                el.checked = !el.checked; // revert toggle if AJAX fails
            }
        });
    }
    </script>
    <!-- login js-->
    <!-- Plugin used-->

</body>

</html>