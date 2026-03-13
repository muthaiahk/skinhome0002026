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
                                <h3>Billing Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Billing Lists</li>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="row card-header mt-4 mx-3" id="add_treatment">
                                            <div class="col-md-3">
                                                <div id="branch_list">
                                                    <select class="form-select" id="branch_name"
                                                        onChange="selectbranch(event)">
                                                        <option value="0">All Branch</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}">
                                                                {{ $branch->branch_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3"></div>

                                            <div class="col-md-2">
                                                <div class=" text-end float-right">
                                                    <a href="{{ url('/add_billing') }}" class="btn btn-primary"
                                                        type="button">Add Billing</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="status_success">

                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive product-table">
                                            <table class="display table" id="billing-table">
                                                <thead>
                                                    <tr>
                                                        <th>Date / Invoice</th>
                                                        <th>Billing No</th>
                                                        <th>Customer / Lead</th>
                                                        <th>Total Amount</th>
                                                        <th>Paid Amount</th>
                                                        <th>Balance Amount</th>
                                                        <th>Pay Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalAmount = 0;
                                                        $totalPaid = 0;
                                                        $totalBalance = 0;
                                                    @endphp

                                                    @foreach ($billings as $billing)
                                                        @php
                                                            $customerName = $billing->lead
                                                                ? $billing->lead->lead_first_name .
                                                                    '
                                                    ' .
                                                                    $billing->lead->lead_last_name
                                                                : ($billing->customer
                                                                    ? $billing->customer->customer_first_name .
                                                                        '
                                                    ' .
                                                                        $billing->customer->customer_last_name
                                                                    : '');
                                                            $customerPhone = $billing->lead
                                                                ? $billing->lead->lead_phone
                                                                : ($billing->customer
                                                                    ? $billing->customer->customer_phone
                                                                    : '');
                                                            $statusLabel =
                                                                $billing->balance_amount > 0
                                                                    ? "<span class='bg-danger p-1 rounded'>Pending</span>"
                                                                    : "<span class='bg-success p-1 rounded'>Paid</span>";

                                                            $totalAmount += $billing->total_amount;
                                                            $totalPaid += $billing->paid_amount;
                                                            $totalBalance += $billing->balance_amount;
                                                        @endphp
                                                        <tr data-branch="{{ $billing->customer->branch_id ?? '' }}">
                                                            <td>{{ $billing->payment_date }}<br>{{ $billing->invoice_no ?? '' }}
                                                            </td>
                                                            <td>{{ $billing->billing_no }}</td>
                                                            <td>{{ $customerName }}<br>{{ $customerPhone }}</td>
                                                            <td>₹{{ number_format($billing->total_amount, 2) }}</td>
                                                            <td>₹{{ number_format($billing->paid_amount, 2) }}</td>
                                                            <td>₹{{ number_format($billing->balance_amount, 2) }}</td>
                                                            <td>{!! $statusLabel !!}</td>
                                                            <td>
                                                                @if ($billing->balance_amount > 0)
                                                                    <a
                                                                        href="{{ url('edit_billing/' . $billing->billing_id) }}">
                                                                        <i class="fa fa-rupee"
                                                                            style="font-size:20px;color:red"
                                                                            title="Pay Balance"></i>
                                                                    </a>
                                                                @endif
                                                                @if ($billing->invoice_no)
                                                                    <a href="{{ url('print_payment/' . $billing->billing_id) }}"
                                                                        target="_blank">
                                                                        <i class="fa fa-print text-primary"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"><strong>Total (this page)</strong></td>
                                                        <td><strong
                                                                class="text-info">₹{{ number_format($totalAmount, 2) }}</strong>
                                                        </td>
                                                        <td><strong
                                                                class="text-success">₹{{ number_format($totalPaid, 2) }}</strong>
                                                        </td>
                                                        <td><strong
                                                                class="text-danger">₹{{ number_format($totalBalance, 2) }}</strong>
                                                        </td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

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
    <div class="modal fade" id="billing_balance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <!-- Large modal for better visibility -->
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="text-center">Billing Balance</h5>
                    <div id="billing-details" class="text-center mt-3">
                        <div class="row justify-content-center mb-2">
                            <div class="col-auto">
                                <p class="mb-0" style="color: #007bff; font-size: 20px;"><strong>Total
                                        Amount:</strong>
                                    <span id="total-amount" class="fs-2 fw-bold">$0.00</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <p class="mb-0" style="color: #28a745; font-size: 20px;"><strong>Paid Amount:</strong>
                                    <span id="paid-amount" class="fs-2 fw-bold">$0.00</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <p class="mb-0" style="color: #dc3545; font-size: 20px;"><strong>Remaining
                                        Balance:</strong> <span id="remaining-amount" class="fs-2 fw-bold">$0.00</span>
                                </p>
                            </div>
                        </div>

                        <div id="warning-message" class="alert alert-danger mt-2 d-none" role="alert">
                            Warning: Remaining balance exceeds the total amount.
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6 mx-auto">
                                <!-- Center the input field -->
                                <label for="payment-amount" class="form-label"><strong>Enter Amount:</strong></label>
                                <input type="number" class="form-control" id="payment-amount"
                                    placeholder="Enter payment amount" min="0" />
                            </div>
                            <div class="col-md-6 mx-auto">
                                <!-- right end the label field when enter show the balance amount and if == or exceed amoun hide it  -->
                                <label for="payment-amount-balance" class="form-label"><strong>Balance
                                        Amount:</strong></label>
                                <label class="form-control" id="payment-amount-balance">0</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary d-none" type="button" id="pay-balance">Yes, Pay Balance</button>
                </div>
            </div>
        </div>
    </div>


    @include('script')
    @include('session_timeout')

    <script>
        $(document).ready(function() {
            var table = $('#billing-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50, 100],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var parseValue = function(i) {
                        return typeof i === 'string' ? parseFloat(i.replace(/[\₹,]/g, '')) :
                            typeof i === 'number' ? i : 0;
                    };

                    var totalTotal = api.column(3, {
                        page: 'current'
                    }).data().reduce((a, b) => parseValue(a) + parseValue(b), 0);
                    var totalPaid = api.column(4, {
                        page: 'current'
                    }).data().reduce((a, b) => parseValue(a) + parseValue(b), 0);
                    var totalBalance = api.column(5, {
                        page: 'current'
                    }).data().reduce((a, b) => parseValue(a) + parseValue(b), 0);

                    $(api.column(3).footer()).html('₹' + totalTotal.toFixed(2));
                    $(api.column(4).footer()).html('₹' + totalPaid.toFixed(2));
                    $(api.column(5).footer()).html('₹' + totalBalance.toFixed(2));
                }
            });

            // ✅ Branch filter
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var selectedBranch = $('#branch_name').val();
                var rowBranch = $(table.row(dataIndex).node()).data('branch'); // correct

                return selectedBranch == "0" || selectedBranch == rowBranch;
            });

            // Redraw table when branch changes
            $('#branch_name').on('change', function() {
                table.draw();
            });
        });
    </script>
</body>

</html>
