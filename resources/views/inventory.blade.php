@include('common')

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 19 -9" result="goo">
                </feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->

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
                                <h3>Inventory Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Inventory Lists</li>
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
                                    <!-- Filters -->
                                    <div class="row card-header">
                                        <div class="col-md-3 position-relative">
                                            <label class="form-label">Branch</label>
                                            <select class="form-select" id="branch_filter">
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->branch_name }}">
                                                        {{ $branch->branch_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 position-relative">
                                            <label class="form-label">Brand</label>
                                            <select class="form-select" id="brand_filter">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 position-relative">
                                            <label class="form-label">Product Categories</label>
                                            <select class="form-select" id="category_filter">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->prod_cat_name }}">{{ $cat->prod_cat_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 position-relative">
                                            <label class="form-label">Product</label>
                                            <select class="form-select" id="product_filter">
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->product_name }}">
                                                        {{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-end">
                                                <button class="btn btn-primary"
                                                    data-company="{{ $Company->company_name }}"
                                                    onclick="openAddModal(this)">
                                                    Add Inventory
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Inventory Table -->
                                    <div class="table-responsive product-table mt-3">
                                        <table class="table table-striped table-bordered" id="inventory_table">
                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Date</th>
                                                    <th>Company Name</th>
                                                    <th>Branch</th>
                                                    <th>Brand</th>
                                                    <th>Product Categories</th>
                                                    <th>Product Name</th>
                                                    <th>Stock in Hand</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($inventory as $key => $row)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $row->inventory_date }}</td>
                                                        <td>{{ $row->company_name }}</td>
                                                        <td>{{ $row->branch_name }}</td>
                                                        <td>{{ $row->brand_name }}</td>
                                                        <td>{{ $row->prod_cat_name }}</td>
                                                        <td>{{ $row->product_name }}</td>
                                                        <td>{{ $row->stock_in_hand }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                onclick="editInventory({{ $row->inventory_id }})">
                                                                <i class="fa fa-edit text-primary"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                onclick="viewInventory({{ $row->inventory_id }})">
                                                                <i class="fa fa-eye text-info"></i>
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
            @include('footer')
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="inventory_delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Data.</p>
                </div>
                <div class="card-footer mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary" id="delete" data-bs-dismiss="modal">Yes, delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Modal -->
    <div class="modal fade" id="inventoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inventoryForm">
                        <input type="hidden" id="inventory_id">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Date</label>
                                <input class="form-control" type="date" id="inventory_date">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Company Name</label>
                                <input class="form-control" type="text" id="company_name" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Branch</label>
                                <select class="form-select" id="branch_id_modal">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Brand</label>
                                <select class="form-select" id="brand_id_modal">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="prod_cat_id_modal">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->prod_cat_id }}">{{ $cat->prod_cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Product</label>
                                <select class="form-select" id="product_id_modal">
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Stock</label>
                                <input class="form-control" type="text" id="stock" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Add Stock</label>
                                <input class="form-control" type="text" id="stock_in_hand">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Stock Alert</label>
                                <input class="form-control" type="text" id="stock_alert_count">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="saveInventoryBtn" onclick="saveInventory()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Inventory Modal -->
    <div class="modal fade" id="inventoryViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inventory Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="inventoryViewForm">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Date</label>
                                <input class="form-control" type="date" id="view_inventory_date" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Company Name</label>
                                <input class="form-control" type="text" id="view_company_name" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Branch</label>
                                <input class="form-control" type="text" id="view_branch_name" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Brand</label>
                                <input class="form-control" type="text" id="view_brand_name" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Category</label>
                                <input class="form-control" type="text" id="view_prod_cat_name" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Product</label>
                                <input class="form-control" type="text" id="view_product_name" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Stock</label>
                                <input class="form-control" type="text" id="view_stock" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Stock Alert</label>
                                <input class="form-control" type="text" id="view_stock_alert_count" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Add Stock</label>
                                <input class="form-control" type="text" id="view_stock_in_hand" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="view_description" readonly></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
        let stockInput;

        document.addEventListener('DOMContentLoaded', function() {

            const categorySelect = document.getElementById('prod_cat_id_modal');
            const productSelect = document.getElementById('product_id_modal');
            stockInput = document.getElementById('stock');

            function checkStockAlert() {
                const stock = parseInt(stockInput.value || 0);
                const alertCount = parseInt(document.getElementById('stock_alert_count').value || 0);

                if (stock <= alertCount) {
                    stockInput.style.border = '2px solid red';
                } else {
                    stockInput.style.border = '';
                }
            }

            categorySelect.addEventListener('change', function() {

                const categoryId = this.value;
                productSelect.innerHTML = '<option value="">Select Product</option>';
                stockInput.value = '';

                if (!categoryId) return;

                fetch(`/inventory_product/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {

                        if (data.status === 200) {

                            let options = '<option value="">Select Product</option>';

                            data.data.forEach(product => {
                                options +=
                                    `<option value="${product.product_id}">${product.product_name}</option>`;
                            });

                            productSelect.innerHTML = options;
                        }

                    })
                    .catch(err => console.error(err));
            });

            productSelect.addEventListener('change', function() {

                const productId = this.value;
                const branchId = document.getElementById('branch_id_modal').value;
                const brandId = document.getElementById('brand_id_modal').value;
                const categoryId = categorySelect.value;

                updateStock(branchId, brandId, categoryId, productId);
            });

        });


        function updateStock(branchId, brandId, categoryId, productId) {

            if (!branchId || !brandId || !categoryId || !productId) {
                stockInput.value = '';
                return;
            }

            fetch('/inventory_product_count', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        branch_id: branchId,
                        brand_id: brandId,
                        cat_id: categoryId,
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 200) {
                        stockInput.value = data.count;
                    } else {
                        stockInput.value = 0;
                    }

                })
                .catch(err => console.error(err));
        }

        function openAddModal(button) {

            // reset form first
            $('#inventoryForm')[0].reset();

            // clear inventory id
            $('#inventory_id').val('');

            // set company name after reset
            document.getElementById('company_name').value =
                button.getAttribute('data-company');

            // open modal
            new bootstrap.Modal(document.getElementById('inventoryModal')).show();
        }


        function editInventory(id) {

            $.get(`/edit_inventory/${id}`, function(res) {

                const data = res.data[0];

                $("#inventory_id").val(data.inventory_id);
                $("#inventory_date").val(data.inventory_date);
                $("#company_name").val(data.company_name);
                $("#branch_id_modal").val(data.branch_id);
                $("#brand_id_modal").val(data.brand_id);

                $("#prod_cat_id_modal").val(data.prod_cat_id).trigger('change');

                if (data.prod_cat_id) {

                    fetch(`/inventory_product/${data.prod_cat_id}`)
                        .then(res => res.json())
                        .then(prodData => {

                            if (prodData.status === 200) {

                                let options = '<option value="">Select Product</option>';

                                prodData.data.forEach(product => {
                                    options +=
                                        `<option value="${product.product_id}">${product.product_name}</option>`;
                                });

                                $("#product_id_modal").html(options);
                                $("#product_id_modal").val(data.product_id);

                                updateStock(
                                    $("#branch_id_modal").val(),
                                    $("#brand_id_modal").val(),
                                    data.prod_cat_id,
                                    data.product_id
                                );

                                $("#stock_in_hand").val(data.stock_in_hand);
                                $("#stock_alert_count").val(data.stock_alert_count);
                                $("#description").val(data.description);
                            }

                        })
                        .catch(err => console.error(err));
                }

                $("#inventoryModal").modal('show');

            });
        }


        function viewInventory(id) {

            $.get(`/edit_inventory/${id}`, function(res) {

                const data = res.data[0];

                $("#view_inventory_date").val(data.inventory_date);
                $("#view_company_name").val(data.company_name);
                $("#view_branch_name").val(data.branch_name);
                $("#view_brand_name").val(data.brand_name);
                $("#view_prod_cat_name").val(data.prod_cat_name);
                $("#view_product_name").val(data.product_name);
                $("#view_stock").val(data.stock_in_hand);
                $("#view_stock_in_hand").val(data.stock_in_hand);
                $("#view_stock_alert_count").val(data.stock_alert_count);
                $("#view_description").val(data.description);

                $("#inventoryViewModal").modal('show');
            });
        }


        function saveInventory() {

            const btn = $("#saveInventoryBtn");

            btn.prop('disabled', true).html('Saving...');

            const id = $("#inventory_id").val();
            const url = id ? `/update_inventory/${id}` : '/add_inventory';

            $.ajax({

                url: url,
                type: "POST",

                data: {
                    inventory_date: $("#inventory_date").val(),
                    company_name: $("#company_name").val(),
                    branch_id: $("#branch_id_modal").val(),
                    prod_cat_id: $("#prod_cat_id_modal").val(),
                    product_id: $("#product_id_modal").val(),
                    brand_id: $("#brand_id_modal").val(),
                    stock_in_hand: $("#stock_in_hand").val(),
                    stock_alert_count: $("#stock_alert_count").val(),
                    description: $("#description").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {

                    toastr.success(response.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                },

                error: function() {

                    btn.prop('disabled', false).html('Save');
                    toastr.error('Something went wrong');

                }

            });

        }


        $(document).ready(function() {

            var table = $('#inventory_table').DataTable();

            $('#branch_filter').on('change', function() {
                table.column(3).search(this.value).draw();
            });

            $('#brand_filter').on('change', function() {
                table.column(4).search(this.value).draw();
            });

            $('#category_filter').on('change', function() {
                table.column(5).search(this.value).draw();
            });

            $('#product_filter').on('change', function() {
                table.column(6).search(this.value).draw();
            });

        });
    </script>
</body>

</html>
