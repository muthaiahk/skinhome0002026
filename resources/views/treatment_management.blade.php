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
                                <h3>Treatment list</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Treatment list</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters + Add Button -->
                <form class="form wizard">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="row card-header mt-4 mx-3" id="add_treatment">
                                        <div class="col-md-3">
                                            <label class="form-label">Branch</label>
                                            <select class="form-select" id="branch_name">
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->branch_name }}">{{ $branch->branch_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" id="treatment_cat_list">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                <option value="{{ $cat->tc_name }}">{{ $cat->tc_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Treatment</label>
                                            <select class="form-select" id="select_treatment">
                                                <option value="">Select Treatment</option>
                                                @foreach($treatments as $treat)
                                                <option value="{{ $treat->treatment_name }}">
                                                    {{ $treat->treatment_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-end float-right">
                                                <button class="btn btn-primary" id="openTreatmentModal" type="button">
                                                    Add Treatment </button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="select_status">
                                                <option value="">Select Status</option>
                                                <option value="Progress">Progress</option>
                                                <option value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Table -->
                                    <div class="card-body">
                                        <div class="table-responsive product-table">
                                            <table class="table table-bordered" id="treatment_management_list">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No</th>
                                                        <th>Treatment Categories</th>
                                                        <th>Treatment Name</th>
                                                        <th>Customer Name</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Balance</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cus_treatment as $key => $value)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $value->tc_name }} <br> {{ $value->treatment_auto_id }}
                                                            {{ $value->branch_name }}</td>
                                                        <td>{{ $value->treatment_name }}</td>
                                                        <td>{{ $value->customer_first_name }}</td>
                                                        <td>
                                                            @if($value->complete_status == 0)
                                                            <span class="text-primary">Progress</span>
                                                            @else
                                                            <span class="text-success">Completed</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $value->amount }}</td>
                                                        <td>{{ $value->balance }}</td>
                                                        <td>
                                                            @if($value->complete_status == 0)
                                                            <a href="#"
                                                                onclick="modelcomplete({{ $value->cus_treat_id }})">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                            @endif
                                                            <a href="javascript:void(0);" class="editTreatmentBtn"
                                                                data-id="{{ $value->cus_treat_id }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="viewTreatmentBtn"
                                                                data-id="{{ $value->cus_treat_id }}">
                                                                <i class="fa fa-eye"></i>
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
                </form>

                <!-- Delete Modal -->
                <div class="modal fade" id="t_management_delete" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <br>
                                <h5 style="text-align: center;">Delete ?</h5>
                                <br>
                                <div class="mb-3">
                                    <p class="col-form-label" style="text-align: center !important;">Are you sure you
                                        want to delete this data ?</p>
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

                <!-- Complete Modal -->
                <div class="modal fade" id="t_management_completed" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="completeForm">
                                @csrf
                                <div class="modal-body">
                                    <br>
                                    <h5 style="text-align: center;">Complete ?</h5>
                                    <br>
                                    <div class="mb-3">
                                        <p class="col-form-label" style="text-align: center !important;">
                                            Are you sure you want to mark this data as Completed?
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer text-center mb-3">
                                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button class="btn btn-primary" type="button" id="complete">
                                        Yes, Completed
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Add Treatment Modal -->
                <div class="modal fade" id="addTreatmentModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Customer Treatment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addTreatmentForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="form-label">Branch Name</label>
                                            <select class="form-select" name="branch_id" id="branch_name_modal">
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Customer Name</label>
                                            <select class="form-select" name="customer_name" id="customer_name">
                                                <option value="">Select Customer</option>
                                                @foreach($Customers as $Customer)
                                                <option value="{{$Customer->customer_id}}"
                                                    data-number="{{$Customer->customer_phone}}">
                                                    {{$Customer->customer_first_name}} {{$Customer->customer_last_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile">
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Treatment Category</label>
                                            <select class="form-select" name="tc_id" id="tc_name">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                <option value="{{$cat->tcategory_id}}">{{$cat->tc_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Treatment</label>
                                            <select class="form-select" name="treatment_id" id="treatment_name">
                                                <option value="">Select Treatment</option>
                                                @foreach($treatments as $treat)
                                                <option value="{{$treat->treatment_id}}"> {{$treat->treatment_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Remarks</label>
                                            <textarea class="form-control" name="remarks" id="remark"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer mt-4">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            id="submitAddTreatment">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Treatment Modal -->
                <div class="modal fade" id="editTreatmentModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="namechanges">Edit Customer Treatment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editTreatmentForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label class="form-label">Branch Name</label>
                                            <select class="form-select" name="branch_id" id="edit_branch_name_modal">
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Customer Name</label>
                                            <select class="form-select" name="customer_name" id="edit_customer_name">
                                                <option value="">Select Customer</option>
                                                @foreach($Customers as $Customer)
                                                <option value="{{$Customer->customer_id}}"
                                                    data-number="{{$Customer->customer_phone}}">
                                                    {{$Customer->customer_first_name}} {{$Customer->customer_last_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="edit_mobile">
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Treatment Category</label>
                                            <select class="form-select" name="tc_id" id="edit_tc_name">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                <option value="{{$cat->tcategory_id}}">{{$cat->tc_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Treatment</label>
                                            <select class="form-select" name="treatment_id" id="edit_treatment_name">
                                                <option value="">Select Treatment</option>
                                                @foreach($treatments as $treat)
                                                <option value="{{$treat->treatment_id}}"> {{$treat->treatment_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 mt-3">
                                            <label class="form-label">Remarks</label>
                                            <textarea class="form-control" name="remarks" id="edit_remark"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer mt-4">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            id="submitEditTreatment">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- footer start-->
                @include('footer')
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <!-- JS -->
    <script>
    var complete_id = '';

    function modelcomplete(id) {
        complete_id = id;
        $('#t_management_completed').modal('show');
    }

    $('#complete').click(function() {

        if (!complete_id) return;

        let btn = $(this);

        btn.prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm"></span> Processing...');

        $.ajax({
            url: '/completed_customer_treatment/' + complete_id,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(res) {

                btn.prop('disabled', false).html('Yes, Completed');

                if (res.status === 200) {

                    toastr.success(res.message || "Marked as Completed!");

                    // Close modal AFTER success
                    $('#t_management_completed').modal('hide');

                    setTimeout(function() {
                        location.reload();
                    }, 800);

                } else {
                    toastr.error(res.message || "Something went wrong");
                }
            },

            error: function() {

                btn.prop('disabled', false).html('Yes, Completed');
                toastr.error("Server Error");

            }
        });

    });


    $(document).on('click', '.viewTreatmentBtn', function() {
        let id = $(this).data('id');

        // Show the modal
        $('#editTreatmentModal').modal('show');
        $('#namechanges').text("View Customer Treatment");

        $.ajax({
            url: '/edit_customer_treatment/' + id,
            type: 'GET',
            success: function(res) {
                if (res.status === 200) {
                    let d = res.data[0];

                    // Populate fields
                    $('#edit_branch_name_modal').val(d.branch_id);
                    $('#edit_customer_name').val(d.customer_id);
                    $('#edit_mobile').val(d.customer_phone);
                    $('#edit_tc_name').val(d.tcategory_id);
                    $('#edit_treatment_name').val(d.treatment_id);
                    $('#edit_remark').val(d.remarks);

                    // Disable inputs for read-only view
                    $('#editTreatmentForm select, #editTreatmentForm input, #editTreatmentForm textarea')
                        .prop('disabled', true);

                    // Hide update button
                    $('#submitEditTreatment').hide();
                }
            }
        });
    });

    // When modal is closed, re-enable inputs for next edit
    $('#editTreatmentModal').on('hidden.bs.modal', function() {
        $('#editTreatmentForm select, #editTreatmentForm input, #editTreatmentForm textarea').prop('disabled',
            false);
        $('#namechanges').text("Edit Customer Treatment"); // R
        $('#submitEditTreatment').show();
    });
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#treatment_management_list').DataTable({
            pageLength: 10
        });

        // Filters
        $('#branch_name').on('change', function() {
            table.column(1).search($(this).val()).draw();
        });
        $('#treatment_cat_list').on('change', function() {
            table.column(1).search($(this).val()).draw();
        });
        $('#select_treatment').on('change', function() {
            table.column(2).search($(this).val()).draw();
        });
        $('#select_status').on('change', function() {
            table.column(4).search($(this).val()).draw();
        });

        // Open Add Modal
        $('#openTreatmentModal').click(function() {
            $('#addTreatmentModal').modal('show');
            $('#addTreatmentForm')[0].reset();
        });

        // Populate mobile number on customer select
        $('#customer_name').on('change', function() {
            $('#mobile').val($(this).find(':selected').data('number') || '');
        });
        $('#edit_customer_name').on('change', function() {
            $('#edit_mobile').val($(this).find(':selected').data('number') || '');
        });

        // Add Treatment
        $('#addTreatmentForm').submit(function(e) {
            e.preventDefault();
            let btn = $('#submitAddTreatment');
            btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Saving...');
            $.ajax({
                url: '/add_customer_treatment',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    btn.prop('disabled', false).html('Submit');
                    if (data.status == 200) {
                        toastr.success(data.message || "Treatment added successfully!");
                        $('#addTreatmentModal').modal('hide');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('Submit');
                    toastr.error("Something went wrong");
                }
            });
        });

        // Edit Treatment
        $(document).on('click', '.editTreatmentBtn', function() {
            let id = $(this).data('id');
            $('#editTreatmentModal').modal('show');

            $.ajax({
                url: '/edit_customer_treatment/' + id,
                type: 'GET',
                success: function(res) {
                    if (res.status === 200) {
                        let d = res.data[0];
                        $('#edit_branch_name_modal').val(d.branch_id);
                        $('#edit_customer_name').val(d.customer_id);
                        $('#edit_mobile').val(d.customer_phone);
                        $('#edit_tc_name').val(d.tcategory_id);
                        $('#edit_treatment_name').val(d.treatment_id);
                        $('#edit_remark').val(d.remarks);
                        $('#submitEditTreatment').attr('data-id', id);
                    }
                }
            });
        });

        $('#editTreatmentForm').submit(function(e) {
            e.preventDefault();
            let id = $('#submitEditTreatment').attr('data-id');
            let btn = $('#submitEditTreatment');
            btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm"></span> Updating...');
            $.ajax({
                url: '/update_customer_treatment/' + id,
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    btn.prop('disabled', false).html('Update');
                    if (res.status === 200) {
                        toastr.success(res.message);
                        $('#editTreatmentModal').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('Update');
                    toastr.error("Something went wrong");
                }
            });
        });
    });
    </script>
</body>

</html>