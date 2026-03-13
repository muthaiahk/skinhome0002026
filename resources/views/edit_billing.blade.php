@include('common')

<body>

    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
    </div>

    <style>
    .summary-card {
        border-radius: 10px;
        background: #f8f9fa;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .summary-value {
        font-weight: 600;
        font-size: 18px;
    }

    .table thead {
        background: #f1f3f4;
    }

    .alert-custom {
        display: none;
    }
    </style>


    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        @include('header')

        <div class="page-body-wrapper">

            @include('sidebar')


            <div class="page-body">

                <div class="container-fluid">

                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Pay Billing</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="payment">Billing Lists</a></li>
                                    <li class="breadcrumb-item">Pay Billing</li>
                                </ol>
                            </div>
                        </div>
                    </div>


                    <form class="form wizard">

                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="card">

                                        <div class="card-body">

                                            <!-- Date + Customer -->
                                            <div class="row mb-4">

                                                <div class="col-lg-4">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="payment_date"
                                                        value="{{ date('Y-m-d') }}">
                                                </div>

                                                <div class="col-lg-4">
                                                    <label class="form-label">Customer</label>
                                                    <select class="form-select select2" disabled>
                                                        <option value="">Select Customer</option>

                                                        @foreach($customers as $customer)
                                                        <option value="{{ $customer->customer_id }}"
                                                            {{ $billing->customer_id == $customer->customer_id ? 'selected' : '' }}>

                                                            {{ $customer->customer_first_name }}
                                                            {{ $customer->customer_last_name }} -
                                                            {{ $customer->customer_phone }}

                                                        </option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                            </div>


                                            <!-- PRODUCT TABLE -->

                                            <div class="table-responsive border rounded">

                                                <table class="table table-hover align-middle mb-0">

                                                    <thead>
                                                        <tr>
                                                            <th width="60">#</th>
                                                            <th>Product / Treatment</th>
                                                            <th width="100">Qty</th>
                                                            <th width="120">Price</th>
                                                            <th width="140" class="text-end">Total</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @php $sno = 1; @endphp

                                                        @foreach($billingTreatments as $treatment)
                                                        <tr>
                                                            <td>{{ $sno++ }}</td>
                                                            <td>{{ $treatment->treatment_name }}</td>
                                                            <td>1</td>
                                                            <td>₹ {{ number_format($treatment->amount,2) }}</td>
                                                            <td class="text-end">₹
                                                                {{ number_format($treatment->amount,2) }}</td>
                                                        </tr>
                                                        @endforeach

                                                        @foreach($billingProducts as $product)
                                                        <tr>
                                                            <td>{{ $sno++ }}</td>
                                                            <td>{{ $product->product_name }}</td>
                                                            <td>1</td>
                                                            <td>₹ {{ number_format($product->amount,2) }}</td>
                                                            <td class="text-end">₹
                                                                {{ number_format($product->amount,2) }}</td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>

                                            </div>


                                            <!-- PAYMENT SUMMARY -->

                                            <div class="row mt-4">

                                                <div class="col-lg-6"></div>

                                                <div class="col-lg-6">

                                                    <!-- TOTAL -->

                                                    <div class="summary-card">
                                                        <span>Total Amount</span>

                                                        <span class="summary-value text-primary">
                                                            ₹ <span
                                                                id="total_amount">{{ number_format($billing->total_amount,2) }}</span>
                                                        </span>
                                                    </div>


                                                    <!-- PAID -->

                                                    <div class="summary-card">
                                                        <span>Paid Amount</span>

                                                        <span class="summary-value text-success">
                                                            ₹ <span
                                                                id="paid_amount">{{ number_format($billing->paid_amount,2) }}</span>
                                                        </span>
                                                    </div>


                                                    <!-- ALERT -->

                                                    <div id="payment_alert" class="alert alert-danger alert-custom">
                                                    </div>


                                                    <!-- BALANCE -->

                                                    <div class="summary-card">

                                                        <span>Balance Amount</span>

                                                        <span class="summary-value text-danger">
                                                            ₹ <span
                                                                id="balance_amount">{{ number_format($billing->balance_amount,2) }}</span>
                                                        </span>

                                                    </div>


                                                    <!-- ENTER AMOUNT -->

                                                    <div class="summary-card">

                                                        <span>Enter Amount</span>

                                                        <input type="number" class="form-control" id="payment_amount"
                                                            style="width:160px" placeholder="Enter amount">

                                                    </div>
                                                    <input type="hidden" id="billing_id"
                                                        value="{{ $billing->billing_id }}">
                                                    <div class="summary-card">
                                                        <button style="background: #004700 !important;" type="button"
                                                            class="btn btn-success w-100" id="pay_amount_btn">

                                                            Pay Amount
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>

                @include('footer')

            </div>
        </div>

        @include('script')
        @include('session_timeout')


        <script>
        $(document).ready(function() {

            let originalBalance = parseFloat("{{ $billing->balance_amount }}");


            $("#payment_amount").on("keyup change", function() {

                let entered = parseFloat($(this).val()) || 0;

                let alertBox = $("#payment_alert");

                if (entered > originalBalance) {
                    alertBox
                        .removeClass("alert-success")
                        .addClass("alert-danger")
                        .text("Entered amount exceeds balance!")
                        .show();

                    $("#balance_amount").text(originalBalance.toFixed(2));

                    return;
                }

                alertBox.hide();

                let newBalance = originalBalance - entered;

                $("#balance_amount").text(newBalance.toFixed(2));

            });



            /* PAY AMOUNT BUTTON */

            $("#pay_amount_btn").click(function() {

                let billing_id = $("#billing_id").val();
                let payment_amount = $("#payment_amount").val();
                let payment_date = $("#payment_date").val();

                if (payment_amount == "" || payment_amount <= 0) {
                    $("#payment_alert")
                        .removeClass("alert-success")
                        .addClass("alert-danger")
                        .text("Please enter valid payment amount")
                        .show();

                    return;
                }

                $.ajax({

                    url: "{{ route('billing.balance_payment','') }}/" + billing_id,

                    type: "POST",

                    data: {
                        payment_amount: payment_amount,
                        payment_date: payment_date,
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        if (response.status == 200) {
                            $("#payment_alert")
                                .removeClass("alert-danger")
                                .addClass("alert-success")
                                .text(response.message)
                                .show();

                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }

                    },

                    error: function() {
                        $("#payment_alert")
                            .removeClass("alert-success")
                            .addClass("alert-danger")
                            .text("Something went wrong")
                            .show();
                    }

                });

            });

        });
        </script>
</body>

</html>