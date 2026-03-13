@include('common')

<body onload="startTime()">
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  
                            0 1 0 0 0  
                            0 0 1 0 0  
                            0 0 0 19 -9" result="goo">
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
                                <h3>Product Category Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard">
                                            <i data-feather="home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Product Category Lists
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-end">
                            <button class="btn btn-primary" id="add_new_category">
                                Add Product Category
                            </button>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_categories as $cat)
                                    <tr id="row_{{ $cat->prod_cat_id }}">
                                        <td>{{ $cat->prod_cat_id }}</td>
                                        <td>{{ $cat->prod_cat_name }}</td>
                                        <td>{{ $cat->brand->brand_name ?? 'N/A' }}</td>
                                        <td class="switch-sm">
                                            <label class="switch">
                                                <input type="checkbox" class="status_toggle"
                                                    data-id="{{ $cat->prod_cat_id }}"
                                                    {{ $cat->status == 1 ? 'checked' : '' }}>
                                                <span class="switch-state"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="edit_category"
                                                data-id="{{ $cat->prod_cat_id }}">
                                                <i class="fa fa-edit text-primary"></i>
                                            </a>
                                            &nbsp;
                                            <a href="javascript:void(0)" class="delete_category"
                                                data-id="{{ $cat->prod_cat_id }}">
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

    <!-- ================= Add/Edit Modal ================= -->

    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="prod_cat_id">

                    <div class="modal-header">
                        <h5 id="modalTitle">Add Product Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="prod_cat_name" required>
                            <span class="text-danger" id="error_name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select class="form-control" id="brand_id">
                                <option value="">-- Select Brand --</option>
                                @foreach($ProductBrands as $brand)
                                <option value="{{ $brand->brand_id }}">
                                    {{ $brand->brand_name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="error_brand"></span>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="save_category">
                            <span class="spinner-border spinner-border-sm d-none" id="loading"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= Delete Modal ================= -->

    <div class="modal fade" id="category_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Product Category?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-danger" id="delete_btn">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
    $(document).ready(function() {

        let delete_id = null;

        $('#add_new_category').click(function() {
            $('#modalTitle').text('Add Product Category');
            $('#prod_cat_id').val('');
            $('#prod_cat_name').val('');
            $('#brand_id').val('');
            $('#error_name, #error_brand').text('');
            $('#categoryModal').modal('show');
        });

        $('#categoryForm').submit(function(e) {
            e.preventDefault();

            $('#loading').removeClass('d-none');

            let id = $('#prod_cat_id').val();
            let url = id ? '/product_category/' + id : '/product_category';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    prod_cat_name: $('#prod_cat_name').val(),
                    brand_id: $('#brand_id').val()
                },
                success: function(res) {
                    toastr.success(res.message);
                    location.reload();
                },
                error: function(xhr) {
                    $('#error_name').text(xhr.responseJSON?.errors?.prod_cat_name || '');
                    $('#error_brand').text(xhr.responseJSON?.errors?.brand_id || '');
                },
                complete: function() {
                    $('#loading').addClass('d-none');
                }
            });
        });

        $('.edit_category').click(function() {
            let id = $(this).data('id');

            $.get('/product_category/' + id + '/edit', function(data) {
                $('#modalTitle').text('Edit Product Category');
                $('#prod_cat_id').val(data.prod_cat_id);
                $('#prod_cat_name').val(data.prod_cat_name);
                $('#brand_id').val(data.brand_id);
                $('#error_name, #error_brand').text('');
                $('#categoryModal').modal('show');
            });
        });

        $('.delete_category').click(function() {
            delete_id = $(this).data('id');
            $('#category_delete').modal('show');
        });

        $('#delete_btn').click(function() {
            if (!delete_id) return;

            $.post('/product_category/' + delete_id + '/delete', {
                _token: '{{ csrf_token() }}'
            }, function(res) {
                toastr.success(res.message);
                $('#row_' + delete_id).remove();
                $('#category_delete').modal('hide');
                delete_id = null;
            });
        });

        $(document).on('change', '.status_toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.post('/product_category/' + id + '/toggle-status', {
                _token: '{{ csrf_token() }}',
                status: status
            }, function(res) {
                toastr.success(res.message);
            });
        });

    });
    </script>