@include('common')

<body onload="startTime()">
    <!-- Loader starts -->
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
    <!-- Loader ends -->

    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')

        <div class="page-body-wrapper">
            @include('sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Product Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Product Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div id="status_success"></div>
                                <div class="card-header text-end">
                                    <a href="javascript:void(0)" id="createProductBtn" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#productModal">Add Product</a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>GST</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                            <tr id="row_{{ $product->product_id }}">
                                                <td>{{ $product->product_id }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->brand->brand_name ?? '' }}</td>
                                                <td>{{ $product->category->prod_cat_name ?? '' }}</td>
                                                <td>{{ $product->amount }}</td>
                                                <td>{{ $product->gst }}%</td>
                                                <td class="switch-sm">
                                                    <label class="switch">
                                                        <input type="checkbox" class="status_toggle"
                                                            data-id="{{ $product->product_id }}"
                                                            {{ $product->status == 1 ? 'checked' : '' }}>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="edit_product"
                                                        data-id="{{ $product->product_id }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="javascript:void(0)" class="delete_product"
                                                        data-id="{{ $product->product_id }}" data-bs-toggle="modal"
                                                        data-bs-target="#product_delete">
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
                    </div>
                </div>

                @include('footer')
            </div>
        </div>
    </div>

    <!-- PRODUCT MODAL -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="product_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalTitle">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Brand</label>
                                <select class="form-select" id="brand_id" name="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Category</label>
                                <select class="form-select" id="prod_cat_id" name="prod_cat_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->prod_cat_id }}">{{ $cat->prod_cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>

                            <div class="col-md-3">
                                <label>Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount">
                            </div>

                            <div class="col-md-3">
                                <label>GST %</label>
                                <select class="form-select" id="gst" name="gst">
                                    <option value="">Select GST</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Product Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image"
                                    onchange="previewImage(event)">
                                <img id="imagePreview" src="{{ asset('assets/images/avtar/3.jpg') }}" class="mt-2"
                                    width="120" height="120" style="object-fit:cover;border:1px solid #6c757d;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveProductBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal fade" id="product_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Product?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="deleteConfirmBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
    let deleteId = null;

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('imagePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    $(document).ready(function() {

        // Reset modal on open
        $('#createProductBtn').click(function() {
            $('#productForm')[0].reset();
            $('#product_id').val('');
            $('#productModalTitle').text('Add Product');
            $('#imagePreview').attr('src', "{{ asset('assets/images/avtar/3.jpg') }}");
        });

        // Reset modal on close
        $('#productModal').on('hidden.bs.modal', function() {
            $('#productForm')[0].reset();
            $('#product_id').val('');
            $('#productModalTitle').text('Add Product');
            $('#imagePreview').attr('src', "{{ asset('assets/images/avtar/3.jpg') }}");
        });

        $('#productForm').submit(function(e) {
            e.preventDefault();
            let id = $('#product_id').val();
            let url = id ? '/product/' + id : '/product';
            let method = id ? 'POST' : 'POST'; // always POST, use _method for PUT
            let formData = new FormData(this);

            if (id) {
                formData.append('_method', 'PUT'); // Laravel recognizes as PUT
            }
            formData.append('_token', '{{ csrf_token() }}'); // ensure CSRF

            let $btn = $('#saveProductBtn');
            $btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                type: 'POST', // always POST, _method = PUT if editing
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    toastr.success(res.message);
                    location.reload();
                },
                error: function(err) {
                    if (err.status === 419) {
                        toastr.error('Session expired. Please login again.');
                        window.location.href = '/login';
                    } else {
                        toastr.error('Error! Please check fields.');
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Save');
                }
            });
        });

        // EDIT PRODUCT
        $(document).on('click', '.edit_product', function() {
            let id = $(this).data('id');
            $.get('/product/' + id + '/edit', function(data) {
                $('#productModal').modal('show');
                $('#productModalTitle').text('Edit Product');

                $('#product_id').val(data.product_id);
                $('#product_name').val(data.product_name);
                $('#amount').val(data.amount);
                $('#gst').val(data.gst);
                $('#brand_id').val(data.brand_id).trigger('change'); // set brand
                $('#prod_cat_id').val(data.prod_cat_id).trigger('change'); // set category

                let imgSrc = data.product_image ? '/product_image/' + data.product_image :
                    "{{ asset('assets/images/avtar/3.jpg') }}";
                $('#imagePreview').attr('src', imgSrc);
            }).fail(function() {
                toastr.error('Failed to fetch product details.');
            });
        });

        // DELETE PRODUCT: store id on click
        $(document).on('click', '.delete_product', function() {
            deleteId = $(this).data('id');
        });

        // DELETE CONFIRM
        $('#deleteConfirmBtn').click(function() {
            if (deleteId) {
                let $btn = $(this);
                $btn.prop('disabled', true).text('Deleting...');

                $.ajax({
                    url: '/product/' + deleteId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        toastr.success(res.message);
                        $('#row_' + deleteId).remove();
                        deleteId = null;

                        // Close the modal
                        $('#product_delete').modal('hide');
                    },
                    error: function(err) {
                        toastr.error('Error deleting product.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Yes, Delete');
                    }
                });
            }
        });

        // STATUS TOGGLE
        $(document).on('change', '.status_toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '/product/' + id + '/status',
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