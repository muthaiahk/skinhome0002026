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
                                <h3>Payment Report</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Payment Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="page-title">
                        <form method="get" action="{{ route('payment.report') }}" class="row g-3 mb-3 flex-wrap">
                            <div class="d-flex flex-wrap gap-3 w-100">
                                <!-- Treatment Category -->
                                <div class="flex-fill" style="min-width: 200px;">
                                    <label>Treatment Category</label>
                                    <select name="treatment_cat" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->tc_name }}"
                                                @if ($treatment_cat == $cat->tc_name) selected @endif>
                                                {{ $cat->tc_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Treatment -->
                                <div class="flex-fill" style="min-width: 200px;">
                                    <label>Treatment</label>
                                    <select name="treatment_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($treatments as $t)
                                            <option value="{{ $t->treatment_id }}"
                                                @if ($treatment_id == $t->treatment_id) selected @endif>
                                                {{ $t->treatment_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="flex-fill" style="min-width: 150px;">
                                    <label>Status</label>
                                    <select name="paid_status" class="form-select">
                                        <option value="2" @if ($paid_status == 2) selected @endif>All
                                        </option>
                                        <option value="0" @if ($paid_status == 0) selected @endif>Paid
                                        </option>
                                        <option value="1" @if ($paid_status == 1) selected @endif>Pending
                                        </option>
                                    </select>
                                </div>

                                <!-- Branch -->
                                <div class="flex-fill" style="min-width: 200px;">
                                    <label>Branch</label>
                                    <select name="branch_id" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($branches as $b)
                                            <option value="{{ $b->branch_id }}"
                                                @if ($branch_id == $b->branch_id) selected @endif>
                                                {{ $b->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Range -->
                                <div class="flex-fill" style="min-width: 250px;">
                                    <label>Date Range</label>
                                    <div class="d-flex gap-2">
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ $from_date }}">
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ $to_date }}">
                                        <button class="btn btn-primary" type="submit">Go</button>
                                    </div>
                                </div>

                                <!-- Export Button -->
                                <div class="flex-fill d-flex align-items-end" style="min-width: 150px;">
                                    <a href="{{ route('payment.export', request()->all()) }}"
                                        class="btn btn-success w-100">Export</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="paymentReport" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Treatment</th>
                                        <th>Customer</th>
                                        <th>Count</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>IGST</th>
                                        <th>Paid</th>
                                        <th>Pending</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $p)
                                        @php
                                            $cgst = $p->state_id == 23 ? $p->cgst : 0;
                                            $sgst = $p->state_id == 23 ? $p->sgst : 0;
                                            $igst = $p->state_id != 23 ? $p->cgst + $p->sgst : 0; // adjust as needed
                                            $status_text = $p->pending > 0 ? 'Pending' : 'Paid';
                                        @endphp
                                        <tr>
                                            <td>{{ $p->invoice_no }}</td>
                                            <td>{{ $p->payment_date }}</td>
                                            <td>{{ $p->treatment->category->tc_name ?? '' }}</td>
                                            <td>{{ $p->treatment->treatment_name ?? '' }}</td>
                                            <td>
                                                {{ ($p->customer->customer_first_name ?? '') . ' ' . ($p->customer->customer_last_name ?? '') }}
                                            </td>
                                            <td>{{ $p->sitting_count }}</td>
                                            <td>{{ number_format($p->amount, 2) }}</td>
                                            <td>{{ number_format($p->discount, 2) }}</td>
                                            <td>{{ number_format($cgst, 2) }}</td>
                                            <td>{{ number_format($sgst, 2) }}</td>
                                            <td>{{ number_format($igst, 2) }}</td>
                                            <td>{{ number_format($p->paid_amount, 2) }}</td>
                                            <td>{{ number_format($p->pending, 2) }}</td>
                                            <td>{{ $status_text }}</td>
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
    <div class="modal fade" id="lead_loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document" style="text-align:center;position:relative;top:35%;">
            <!-- <div class="modal-content"> -->
            <img src="{{ asset('assets/images/loader/loader-renew.gif') }}" style="width:50%;" />
            <!-- </div> -->
        </div>
    </div>
    @include('script')
    <!-- login js-->
    <!-- Plugin used-->
    @include('session_timeout')
    <script>
        $(document).ready(function() {
            $('#paymentReport').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                pageLength: 25, // default rows per page
                order: [
                    [1, 'desc']
                ], // order by date descending
            });
        });
    </script>

</body>

</html>
