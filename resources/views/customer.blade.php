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
                                <h3>Customer Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Customer Lists</li>
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
                                <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                                <div id="status_success">

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div id="dashboard_branch_list">
                                                <select class="form-select" id="branch_name">
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                    <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body table-responsive">
                                        <table id="customer_table" class="table table-bordered display"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Sl no</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>On going<br>Treament</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $index => $customer)
                                                <tr data-branch-id="{{ $customer->branch_id }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $customer->customer_first_name }}
                                                        {{ $customer->customer_last_name }}<br><span
                                                            class="badge badge-info">{{ $customer->branch_name }}</span>
                                                    </td>
                                                    <td>{{ $customer->customer_address }}</td>
                                                    <td>{{ $customer->customer_phone }}</td>
                                                    <td>{{ $customer->customer_email }}</td>
                                                    <td><span
                                                            class="badge badge-primary fs-5">{{ $customer->count }}</span>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ url('edit_customer', ['c_id' => $customer->customer_id]) }}"><i
                                                                class="fa fa-edit eyc"></i></a>
                                                        <a href="{{ url('view_customer/'.$customer->customer_id) }}">
                                                            <i class="fa fa-eye eyc"></i>
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
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <div class="modal fade" id="customer_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <h5 style="text-align: center;">Delete ?</h5><br>
                    <div class="mb-3">
                        <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete
                            this Data.</p>
                    </div>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                    <button class="btn btn-primary" id="delete" data-bs-dismiss="modal">Yes, delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    $(document).ready(function() {
        var table = $('#customer_table').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "searching": true
        });

        // Filter DataTable on branch selection
        $('#branch_name').on('change', function() {
            var selectedBranch = $(this).val();

            if (selectedBranch) {
                // Use DataTables search to filter by branch_id in the hidden column or row attribute
                table.rows().every(function() {
                    var rowBranch = $(this.node()).data('branch-id').toString();
                    if (rowBranch === selectedBranch) {
                        $(this.node()).show();
                    } else {
                        $(this.node()).hide();
                    }
                });
            } else {
                // Show all rows if no branch selected
                table.rows().every(function() {
                    $(this.node()).show();
                });
            }

            table.draw(false);
        });
    });
    </script>

</body>

</html>