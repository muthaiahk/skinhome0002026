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
                                <h3>Payments Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Payments Lists</li>
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
                                                    <select class="form-select" id="branch_name">
                                                        <option value="0">All Branch</option>

                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->branch_id }}">
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-3"></div>
                                            <div class="col-md-2">
                                                {{-- <div class="text-end float-right">
                                                    <a href="/add_payment" type="button" class="btn btn-primary"
                                                        id='add_payment' type="submit" data-bs-original-title="">Add
                                                        Payment</a>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div id="status_success"></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive product-table" id="payment_list">
                                            <table class="table table-bordered table-striped" id="paymentTable">

                                                <thead class="table-light">

                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Receipt No</th>
                                                        <th>Customer / Lead</th>
                                                        <th>Paid Amount</th>
                                                        <th>Total Amount</th>
                                                        <th>Balance Amount</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                        <th style="display:none;">Branch</th>
                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($payment as $item)
                                                        @php
                                                            $name =
                                                                $item->customer_first_name ??
                                                                ($item->lead_first_name ?? 'N/A');
                                                            $phone =
                                                                $item->customer_phone ?? ($item->lead_phone ?? 'N/A');
                                                        @endphp

                                                        <tr>

                                                            <td>{{ $item->payment_date }}</td>

                                                            <td>{{ $item->receipt_no }}</td>

                                                            <td>
                                                                {{ $name }} <br>
                                                                <small>{{ $phone }}</small>
                                                            </td>

                                                            <td>₹{{ $item->amount }}</td>

                                                            <td>₹{{ $item->total_amount }}</td>

                                                            <td>₹{{ $item->balance }}</td>

                                                            <td>
                                                                @if ($item->balance > 0)
                                                                    <span class="badge bg-danger">Pending</span>
                                                                @else
                                                                    <span class="badge bg-success">Paid</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <a href="{{ url('print_payment/' . $item->p_id) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-print text-primary"></i>
                                                                </a>
                                                            </td>

                                                            <td style="display:none;">{{ $item->branch_id }}</td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <tfoot>

                                                    <tr class="table-total-row">

                                                        <td colspan="3"><strong>Total (this page)</strong></td>

                                                        <td id="paidTotal" class="text-info fw-bold"></td>

                                                        <td id="amountTotal" class="text-success fw-bold"></td>

                                                        <td id="balanceTotal" class="text-danger fw-bold"></td>

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

    <div class="modal fade" id="payment_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <h5 style="text-align: center;">Delete ?</h5><br>
                    <div class="mb-3">
                        <p class="col-form-label" style="text-align: center !important;">Are you sure you want to
                            delete this Data.</p>
                    </div>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes,
                        delete</button>
                </div>
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
        $(document).ready(function() {

            var table = $('#paymentTable').DataTable({

                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true,

                columnDefs: [{
                    targets: [8],
                    visible: false
                }],

                footerCallback: function(row, data, start, end, display) {

                    var api = this.api();

                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[₹,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };

                    var paidTotal = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var amountTotal = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var balanceTotal = api
                        .column(5, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    $('#paidTotal').html('₹' + paidTotal.toLocaleString('en-IN', {
                        minimumFractionDigits: 2
                    }));

                    $('#amountTotal').html('₹' + amountTotal.toLocaleString('en-IN', {
                        minimumFractionDigits: 2
                    }));

                    $('#balanceTotal').html('₹' + balanceTotal.toLocaleString('en-IN', {
                        minimumFractionDigits: 2
                    }));

                }

            });


            $('#branch_name').on('change', function() {

                var branch = $(this).val();

                if (branch == 0) {
                    table.column(8).search('').draw();
                } else {
                    table.column(8).search('^' + branch + '$', true, false).draw();
                }

            });

        });
    </script>

    <style>
        .table-total-row {
            font-size: 18px;
            background: #f9f9f9;
        }

        .table-total-row td {
            border-top: 2px solid #ddd;
            padding: 12px;
        }

        .text-info {
            color: #1aa1d6 !important;
        }

        .text-success {
            color: #2e8b57 !important;
        }

        .text-danger {
            color: #e53935 !important;
        }
    </style>

</body>

</html>
