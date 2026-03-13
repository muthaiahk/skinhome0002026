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
                                <h3>Treatment Category Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Treatment Category Lists</li>
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
                                <div class="card-header text-end">
                                    <button class="btn btn-primary" id="add_treatment_cat">Add Treatment
                                        Category</button>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive product-table">
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
                                            <tbody id="tcTableBody">
                                                @foreach($categories as $cat)
                                                <tr id="row_{{ $cat->tcategory_id }}">
                                                    <td>{{ $cat->tcategory_id }}</td>
                                                    <td>{{ $cat->tc_name }}</td>
                                                    <td>{{ $cat->tc_description }}</td>
                                                    <td class="switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" class="status_toggle"
                                                                data-id="{{ $cat->tcategory_id }}"
                                                                {{ $cat->status == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="edit_tc"
                                                            data-id="{{ $cat->tcategory_id }}"><i
                                                                class="fa fa-edit text-primary"></i></a>
                                                        <a href="javascript:void(0)" class="delete_tc"
                                                            data-id="{{ $cat->tcategory_id }}"><i
                                                                class="fa fa-trash text-danger ms-2"></i></a>
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

    <div class="modal fade" id="tcModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="tcForm">
                    @csrf
                    <input type="hidden" id="tc_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tcModalTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Name</label>
                        <input type="text" class="form-control" id="tc_name" name="tc_name" required>
                        <label class="mt-2">Description</label>
                        <textarea class="form-control" id="tc_description" name="tc_description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="saveTcBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tcModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="tcForm">
                    @csrf
                    <input type="hidden" id="tc_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tcModalTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Name</label>
                        <input type="text" class="form-control" id="tc_name" name="tc_name">
                        <label class="mt-2">Description</label>
                        <textarea class="form-control" id="tc_description" name="tc_description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="saveTcBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tcategory_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Treatment Category?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="deleteTcConfirmBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    $(document).ready(function() {
        // DataTable
        var table = $('#tcTable').DataTable();

        // Toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Open Add Modal
        $('#add_treatment_cat').click(function() {
            $('#tcForm')[0].reset();
            $('#tc_id').val('');
            $('#tcModalTitle').text('Add Category');
            $('#tcModal').modal('show');
        });

        // Add/Edit Category
        $('#tcForm').submit(function(e) {
            e.preventDefault();
            let id = $('#tc_id').val();
            let url = id ? '/treatment-category/' + id : '/treatment-category';
            let method = 'POST';
            let data = $(this).serialize();
            if (id) data += '&_method=PUT';

            $('#saveTcBtn').prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(res) {
                    if (res.status == 200) {
                        $('#tcModal').modal('hide');
                        toastr.success(res.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        toastr.error(JSON.stringify(res.errors));
                    }
                },
                complete: function() {
                    $('#saveTcBtn').prop('disabled', false).text('Save');
                }
            });
        });

        // Edit TC
        $(document).on('click', '.edit_tc', function() {
            let id = $(this).data('id');
            $.get('/treatment-category/' + id + '/edit', function(data) {
                $('#tcModal').modal('show');
                $('#tcModalTitle').text('Edit Category');
                $('#tc_id').val(data.tcategory_id);
                $('#tc_name').val(data.tc_name);
                $('#tc_description').val(data.tc_description);
            });
        });

        // Delete TC
        let deleteTcId = null; // Store the ID of category to delete

        // Open modal when clicking delete icon
        $(document).on('click', '.delete_tc', function() {
            deleteTcId = $(this).data('id'); // Get tcategory ID
            $('#tcategory_delete').modal('show'); // Show modal
        });

        // Confirm Delete button
        $('#deleteTcConfirmBtn').click(function() {
            if (deleteTcId) {
                let $btn = $(this);
                $btn.prop('disabled', true).text('Deleting...');

                $.ajax({
                    url: '/treatment-category/' + deleteTcId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        toastr.success(res.message); // Toastr success
                        $('#row_' + deleteTcId).remove(); // Remove row dynamically
                        deleteTcId = null;
                        $('#tcategory_delete').modal('hide'); // Close modal
                    },
                    error: function(err) {
                        toastr.error('Error deleting category.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Yes, Delete');
                    }
                });
            }
        });

        // Status Toggle
        $(document).on('change', '.status_toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '/treatment-category/' + id + '/status',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(res) {
                    toastr.success(res.message);
                }
            });
        });
    });
    </script>

</body>

</html>