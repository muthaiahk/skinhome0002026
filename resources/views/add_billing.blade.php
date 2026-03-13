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
    <style>
    .select2-results__option {
        background-color: #f7f7f7 !important;
        /* light gray background */
        color: #0071bc !important;
        /* blue text */
    }

    .section-loader {
        position: absolute;
        /* covers the parent container */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.6);
        /* semi-transparent */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 4px;
        /* optional, matches select corners */
    }

    .loader-index span {
        width: 30px;
        height: 30px;
        border: 4px solid #3db082;
        border-top: 4px solid transparent;
        border-radius: 50%;
        display: inline-block;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
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
                                <h3>Add Billing</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="payment">Billing Lists</a></li>
                                    <li class="breadcrumb-item">Add Billing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form wizard">
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success">

                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-6 position-relative">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-4">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" class="form-control" id="payment_date"
                                                            value="{{ date('Y-m-d') }}">
                                                        <div class="text-danger" id="error_payment_date"></div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label class="form-label">Customer</label>
                                                        <select class="form-select select2" id="select_customer">
                                                            <option value="">Select Customer</option>
                                                            @foreach($customers as $customer)
                                                            <option value="{{ $customer->customer_id }}">
                                                                {{ $customer->customer_first_name }}
                                                                {{ $customer->customer_last_name }} -
                                                                {{ $customer->customer_phone }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label class="form-label">Treatment</label>
                                                        <select class="form-select select2"
                                                            id="customer_treatment_details" multiple>
                                                            <option value="">Select Treatment</option>
                                                        </select>
                                                        <div id="treatment_loader" class="section-loader"
                                                            style="display:none;">
                                                            <div class="loader-index"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-2">
                                                    <div class="col-lg-6 position-relative" id="billing_lead_list"
                                                        style="display: none;">
                                                    </div>
                                                    <div class="col-lg-6 position-relative" id="payment_customer_list">
                                                    </div>
                                                    <div class="col-lg-6 position-relative mt-1">
                                                        <select id="customer_treatment_details" class="form-control"
                                                            multiple="multiple"></select>
                                                    </div>

                                                    <div id="selected_treatment_display" class="col-lg-6 mt-3">
                                                    </div>
                                                </div> -->
                                                <div class="row mb-3">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive"
                                                            style='max-height: 150px; overflow-y: auto;'>
                                                            <table class="table" id="billing-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sno</th>
                                                                        <th>Product/Treatment</th>
                                                                        <th>Qty</th>
                                                                        <th>Per Price</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="product-list">
                                                                    <!-- Product Rows Will Be Added Here Dynamically -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Header -->
                                                    <div class="col-lg-6">
                                                        <label class="form-label"><b>Billing Segment</b></label>
                                                    </div>

                                                    <!-- Total Amount Section -->
                                                    <div
                                                        class="col-lg-6 d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                                        <span class="text-dark font-weight-bold">Total Amount:</span>
                                                        <span id="total_amount_without"
                                                            class="badge badge-primary px-3 py-2 font-weight-bold"
                                                            style="font-size: 1.2rem;">
                                                            0.00
                                                        </span>
                                                    </div>

                                                    <!-- Discount Type Section -->
                                                    <div class="row">
                                                        <!-- Discount Type Section -->
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <span>Discount Type</span>
                                                                <div class="d-flex align-items-center mt-2">
                                                                    <label class="me-3">
                                                                        <input type="radio" name="discount_type"
                                                                            id="rupees" checked value="1"
                                                                            onclick="calculateTotal()"> Rs.
                                                                    </label>
                                                                    <label class="me-3">
                                                                        <input type="radio" name="discount_type"
                                                                            id="percentage" value="2"
                                                                            onclick="calculateTotal()"> %
                                                                    </label>
                                                                    <input type="text" class="form-control ms-2"
                                                                        id="discount" value="0"
                                                                        placeholder="Enter value">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 text-end">
                                                            <div class="d-flex flex-column align-items-end">
                                                                <div class="cgst_container">
                                                                    <label class="form-control-label">CGST:</label>
                                                                    <span class="fw-bold cgst_text_value">0.00</span>
                                                                </div>
                                                                <div class="sgst_container">
                                                                    <label class="form-control-label">SGST:</label>
                                                                    <span class="fw-bold sgst_text_value">0.00</span>
                                                                </div>
                                                                <div class="igst_container" style="display: none;">
                                                                    <!-- Hide by default -->
                                                                    <label class="form-control-label">IGST:</label>
                                                                    <span class="fw-bold igst_text_value">0.00</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6 mb-0">
                                                    </div>
                                                    <!-- Payable Amount Section -->
                                                    <div
                                                        class="col-lg-6 d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                                        <span class="text-dark font-weight-bold">Payable Amount:</span>
                                                        <span id="total_amount"
                                                            class="badge badge-success px-3 py-2 font-weight-bold"
                                                            style="font-size: 1.2rem;">
                                                            0.00
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label"><b>Payment Details Entry!</b></label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="cash">Cash</label>
                                                            <input type="text" class="form-control" name="cash"
                                                                id="cash" value="0" oninput="multi_payment(event)">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="card">Card</label>
                                                            <input type="text" class="form-control" id="card"
                                                                name="card" value="0" oninput="multi_payment(event)">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="upi">UPI</label>
                                                            <input type="text" class="form-control" id="upi" name="upi"
                                                                value="0" oninput="multi_payment(event)">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="loan">Loan</label>
                                                            <input type="text" class="form-control" id="loan"
                                                                name="loan" value="0" oninput="multi_payment(event)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label class="form-label text-danger"
                                                        id="balance_amount_enter"><b></b></label>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="card-footer text-end">
                                                        <input type="hidden" id="cus_treat_id" value=''>
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal" title=""><a
                                                                href='./billing'>Cancel</a></button>
                                                        <button type="button" id="add_pay" class="btn btn-primary"
                                                            onclick="add_payment()">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Vertical Line to Separate Divs -->
                                            <div class="col-lg-6 position-relative"
                                                style="border-left: 1px solid #ccc; padding-left: 20px;">
                                                <!-- Product List Dropdown -->
                                                <div class="row">
                                                    <div class="col-lg-5 position-relative">
                                                        <label class="form-label" for="product">Product Category</label>
                                                    </div>
                                                    <div class="col-lg-7 position-relative" id="product_category_list">
                                                        <select name="product_category" id="product_category"
                                                            class="form-select">
                                                            <option value="">-- Select Category --</option>
                                                            @foreach($productcategorys as $category)
                                                            <option value="{{ $category->prod_cat_id }}">
                                                                {{ $category->prod_cat_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="text-danger" id="error_product"></div>
                                                <div id="product_list" class="position-relative"></div>
                                                <div id="product_loader" class="section-loader" style="display:none;">
                                                    <div class="loader-index"><span></span></div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-lg-5 position-relative">
                                                        <label class="form-label" for="product">Treatment
                                                            Category</label>
                                                    </div>
                                                    <div class="col-lg-7 position-relative"
                                                        id="treatment_category_list_all">
                                                        <select name="treatment_category" id="treatment_category_all"
                                                            class="form-select">
                                                            <option value="">-- Select Category --</option>
                                                            @foreach($treatmentCategories as $category)
                                                            <option value="{{ $category->tcategory_id }}">
                                                                {{ $category->tc_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-2 position-relative">
                                                    <div id="treatment_details_all"></div>
                                                    <div id="treatment_category_loader" class="section-loader"
                                                        style="display:none;">
                                                        <div class="loader-index"><span></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid Ends-->
                </form>
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SELECT2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    let selectedProducts = [];
    let selectedTreatments = [];
    let selectedTreatmentsAll = [];
    let selectedStateId = 23; // your default state id

    $(document).ready(function() {
        const base_url = "{{ url('/') }}/";

        $('.select2').select2({
            allowClear: true,
            width: '100%'
        });
        $('.loader-wrapper').fadeOut();

        // ===============================
        // Customer Treatment Load
        // ===============================
        $('#select_customer').on('change', function() {
            const customerId = $(this).val();
            $('#customer_treatment_details').html('').trigger('change');
            selectedTreatments = [];
            updateTable();

            if (!customerId) return;

            $('#treatment_loader').show();
            $.ajax({
                url: base_url + "customer_treatment_cat/" + customerId,
                type: "GET",
                success: function(res) {
                    $('#treatment_loader').hide();
                    if (res.status == 200 && res.data) {
                        let html = '';
                        res.data.forEach(t => {
                            const image = t.treatment_image ?
                                base_url + "public/treatment_image/" + t
                                .treatment_image :
                                "{{ asset('assets/logo/renew_logo.png') }}";
                            html += `<option value="${t.treatment_id}" data-name="${t.treatment_name}" data-amount="${t.amount}" data-image="${image}">
                            ${t.treatment_name} - ₹${t.amount}
                        </option>`;
                        });
                        const select = $('#customer_treatment_details');
                        select.html(html).trigger('change');
                        select.select2({
                            placeholder: "Select treatments",
                            templateResult: formatTreatment,
                            templateSelection: formatTreatmentSelection,
                            width: '100%'
                        });
                    }
                },
                error: function() {
                    $('#treatment_loader').hide();
                }
            });
        });

        function formatTreatment(treatment) {
            if (!treatment.id) return treatment.text;
            const amount = $(treatment.element).data('amount');
            const image = $(treatment.element).data('image');
            return $(`<div style="display:flex;align-items:center">
                    <img src="${image}" style="width:30px;height:30px;border-radius:50%;margin-right:10px">
                    <div><strong>${treatment.text}</strong><br><span style="color:#3db082">₹${amount}</span></div>
                </div>`);
        }

        function formatTreatmentSelection(t) {
            return t.text;
        }

        // Add treatment from select2
        $('#customer_treatment_details').on('select2:select', function(e) {
            const el = $(e.params.data.element);
            const id = parseInt(e.params.data.id);
            const name = el.data('name');
            const price = parseFloat(el.data('amount'));
            if (!selectedTreatments.find(t => t.id === id)) {
                selectedTreatments.push({
                    id,
                    name,
                    price,
                    qty: 1
                });
            }
            updateTable();
        });

        $('#customer_treatment_details').on('select2:unselect', function(e) {
            const id = parseInt(e.params.data.id);
            selectedTreatments = selectedTreatments.filter(t => t.id !== id);
            updateTable();
        });

        // ===============================
        // Treatment Grid Load
        // ===============================
        $('#treatment_category_all').on('change', function() {
            const id = $(this).val();
            if (!id) return;
            $('#treatment_category_loader').show();
            $.ajax({
                url: base_url + "treatment_all/" + id,
                type: "GET",
                success: function(data) {
                    $('#treatment_category_loader').hide();
                    if (data.status == 200 && data.data) {
                        let html =
                            "<div class='row' style='max-height:200px;overflow-y:auto;'>";
                        data.data.forEach(treatment => {
                            if (treatment.status == 0) {
                                const img = treatment.treatment_image ? base_url +
                                    "public/product_image/" + treatment
                                    .treatment_image :
                                    "{{ asset('assets/logo/renew_logo.png') }}";
                                const truncatedName = treatment.treatment_name
                                    .length > 10 ?
                                    treatment.treatment_name.substring(0, 10) +
                                    "..." : treatment.treatment_name;
                                html += `<div class='col-lg-4 mb-3'>
                                <div class='product-item text-center p-2 bg-light rounded' style="cursor:pointer"
                                    onclick="toggleTreatmentAll(${treatment.treatment_id},'${treatment.treatment_name}',${treatment.amount})">
                                    <img src="${img}" style="width:60px;height:60px;border-radius:50%;object-fit:cover">
                                    <div><strong style="color:#1d80c3;font-weight:800;">${truncatedName}</strong><br>
                                    <span style="color:#3db082;">₹${treatment.amount}</span></div>
                                </div>
                            </div>`;
                            }
                        });
                        html += "</div>";
                        $('#treatment_details_all').html(html);
                    }
                },
                error: function() {
                    $('#treatment_category_loader').hide();
                }
            });
        });

        window.toggleTreatmentAll = function(id, name, price) {
            const index = selectedTreatmentsAll.findIndex(t => t.id === id);
            if (index === -1) selectedTreatmentsAll.push({
                id,
                name,
                price: parseFloat(price),
                qty: 1
            });
            else selectedTreatmentsAll.splice(index, 1);
            updateTable();
        }

        // ===============================
        // Product Load
        // ===============================
        $('#product_category').on('change', function() {
            const categoryId = $(this).val();
            if (!categoryId) return;
            $('#product_loader').show();
            $.ajax({
                url: base_url + "product_list",
                type: "GET",
                data: {
                    category_id: categoryId
                },
                success: function(res) {
                    $('#product_loader').hide();
                    if (res.status == 200) {
                        let html = "<div class='row'>";
                        res.data.forEach(p => {
                            const img = p.product_image ? base_url +
                                "public/product_image/" + p.product_image :
                                "{{ asset('assets/logo/renew_logo.png') }}";
                            html += `<div class='col-lg-4 mb-3'>
                            <div class='product-item text-center p-2 bg-light rounded' style="cursor:pointer"
                                onclick="toggleProduct(${p.product_id},'${p.product_name}',${p.amount})">
                                <img src="${img}" style="width:60px;height:60px;border-radius:50%">
                                <div style="color:#1d80c3;font-weight:800;">${p.product_name}</div>
                                <div style="color:#3db082">₹${p.amount}</div>
                            </div>
                        </div>`;
                        });
                        html += "</div>";
                        $('#product_list').html(html);
                    }
                },
                error: function() {
                    $('#product_loader').hide();
                }
            });
        });

        window.toggleProduct = function(id, name, price) {
            const index = selectedProducts.findIndex(p => p.id === id);
            if (index === -1) selectedProducts.push({
                id,
                name,
                price,
                qty: 1
            });
            else selectedProducts.splice(index, 1);
            updateTable();
        }

        // ===============================
        // Quantity Adjustment
        // ===============================
        window.adjustQty = function(index, change, type) {
            let list = (type === 'product') ? selectedProducts : (type === 'treatment') ?
                selectedTreatments : selectedTreatmentsAll;
            if (!list[index]) return;
            list[index].qty += change;
            if (list[index].qty < 1) list.splice(index, 1);
            updateTable();
        }

        // ===============================
        // Table Update
        // ===============================
        function updateTable() {
            const tbody = $('#product-list');
            tbody.html('');
            let total = 0;
            let count = 1;

            function addRow(item, index, type) {
                const rowTotal = item.qty * item.price;
                total += rowTotal;
                tbody.append(`<tr>
                <td>${count++}</td>
                <td>${item.name}</td>
                <td><span onclick="adjustQty(${index},-1,'${type}')" style="cursor:pointer;color:red">−</span> ${item.qty} 
                <span onclick="adjustQty(${index},1,'${type}')" style="cursor:pointer;color:green">+</span></td>
                <td>${item.price.toFixed(2)}</td>
                <td>${rowTotal.toFixed(2)}</td>
            </tr>`);
            }
            selectedProducts.forEach((p, i) => addRow(p, i, 'product'));
            selectedTreatments.forEach((t, i) => addRow(t, i, 'treatment'));
            selectedTreatmentsAll.forEach((t, i) => addRow(t, i, 'treatmentall'));
            $('#total_amount_without').text(total.toFixed(2));
            calculateTotal();
        }

        // ===============================
        // Calculate Total + GST + Discount
        // ===============================
        window.calculateTotal = function() {
            let total = parseFloat($('#total_amount_without').text()) || 0;
            const discount = parseFloat($('#discount').val()) || 0;
            if ($('#percentage').is(':checked')) total -= total * (discount / 100);
            else total -= discount;
            total = Math.max(total, 0);

            let cgst = 0,
                sgst = 0,
                igst = 0;
            if (selectedStateId == 23) {
                cgst = total * 0.09;
                sgst = total * 0.09;
            } else igst = total * 0.18;

            $('.cgst_text_value').text(cgst.toFixed(2));
            $('.sgst_text_value').text(sgst.toFixed(2));
            $('.igst_text_value').text(igst.toFixed(2));
            $('#total_amount').text((total + cgst + sgst + igst).toFixed(2));
        }

        $('#discount').on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
            if ($('#percentage').is(':checked') && parseFloat(this.value) >= 100) this.value = '99';
            calculateTotal();
        });
    });

    // ===============================
    // Add Payment
    // ===============================
    function add_payment() {
        const customer_id = $('#select_customer').val();
        const selectedLeadId = $('#select_lead').val();
        const selectedProductCategoryId = $('#product_category').val();
        const selectedTreatmentCategoryId = $('#treatment_category_all').val();
        const selectedTreatmentIds = selectedTreatmentsAll.map(t => t.id);
        const selectedTreatmentIdsCus = selectedTreatments.map(t => t.id);
        const selectedProductIds = selectedProducts.map(p => p.id);

        const payment_date = $('#payment_date').val();
        const discount_type = $('input[name="discount_type"]:checked').val();
        const discount_amount = parseFloat($('#discount').val()) || 0;
        const cash_amt = parseFloat($('#cash').val()) || 0;
        const card_amt = parseFloat($('#card').val()) || 0;
        const cheque_amt = parseFloat($('#loan').val()) || 0;
        const upi_amt = parseFloat($('#upi').val()) || 0;

        if (!customer_id) {
            $('#error_customer_name').html('Please select a customer.');
            return;
        } else $('#error_customer_name').html('');
        if (!payment_date) {
            $('#error_payment_date').html('Please select a payment date.');
            return;
        } else $('#error_payment_date').html('');
        if (cash_amt + card_amt + cheque_amt + upi_amt === 0) {
            alert("Please enter at least one payment method amount.");
            return;
        }

        const data = {
            customer_id,
            lead_id: selectedLeadId,
            treatment_category_id: selectedTreatmentCategoryId,
            treatment_ids: selectedTreatmentIds,
            treatment_ids_cus: selectedTreatmentIdsCus,
            product_category_id: selectedProductCategoryId,
            product_ids: selectedProductIds,
            payment_date,
            discount_type,
            discount_amount,
            cgst: parseFloat($('.cgst_text_value').text()) || 0,
            sgst: parseFloat($('.sgst_text_value').text()) || 0,
            igst: parseFloat($('.igst_text_value').text()) || 0,
            total_amount: parseFloat($('#total_amount').text()) || 0,
            cash: cash_amt,
            card: card_amt,
            cheque: cheque_amt,
            upi: upi_amt
        };

        $('#add_pay').prop('disabled', true);
        $.ajax({
            url: "{{ url('add_billing') }}",
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 200) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ url('billing') }}";
                    }, 3000);
                } else {
                    toastr.error(response.error_msg);
                    $('#add_pay').prop('disabled', false);
                }
            },
            error: function(xhr) {
                toastr.error(response.error_msg);
                $('#add_pay').prop('disabled', false);
            }
        });
    }

    function multi_payment(event) {
        // Parse the values from each payment method input
        const cash = parseFloat(document.getElementById('cash').value) || 0;
        const card = parseFloat(document.getElementById('card').value) || 0;
        const cheque = parseFloat(document.getElementById('loan').value) || 0;
        const upi = parseFloat(document.getElementById('upi').value) || 0;

        // Calculate the total payment made
        const totalPayment = cash + card + cheque + upi;

        // Get the total amount from the element
        const totalAmount = parseFloat(document.getElementById('total_amount').textContent) || 0;

        // Calculate the balance amount
        const balanceAmount = totalAmount - totalPayment;

        // Get reference to elements
        const balanceLabel = document.getElementById('balance_amount_enter');
        const submitButton = document.getElementById('add_pay');

        // Check if payment exceeds total amount
        if (totalPayment > totalAmount) {
            // Hide submit button and show warning
            submitButton.style.display = 'none';
            balanceLabel.innerHTML = `<b>Warning: Payment exceeds the total amount!</b>`;
            balanceLabel.style.color = 'red';
        } else {
            // Show submit button and update balance amount
            submitButton.style.display = 'inline-block';

            // Show balance only if it's positive, hide if balance is zero
            if (balanceAmount > 0) {
                balanceLabel.innerHTML = `<b>Balance Amount: ${balanceAmount.toFixed(2)}</b>`;
                balanceLabel.style.color = 'red';
            } else {
                balanceLabel.innerHTML = '';
            }
        }
    }
    </script>
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>
<!-- $payment->invoice = 'IN/' -->