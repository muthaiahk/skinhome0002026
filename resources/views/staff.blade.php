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
                                <h3>Staff Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Staff Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form wizard">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success">

                                    </div>
                                    <div class="card-header">
                                        <div class="row mt-3 mx-2">
                                            <div class="col-lg-3">
                                                <select class="form-select" id="branch_filter">
                                                    <option value="">All Branch</option>
                                                    @foreach ($Branchs as $branch)
                                                        <option value="{{ $branch->branch_name }}">
                                                            {{ $branch->branch_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-4">
                                                <select class="form-select" id="department_filter">
                                                    <option value="">All Department</option>
                                                    @foreach ($Departments as $dept)
                                                        <option value="{{ $dept->department_name }}">
                                                            {{ $dept->department_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-3 text-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#addStaffModal">
                                                    Add Staff
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="staffTable">
                                                <thead>
                                                    <tr>
                                                        <th>Sl no</th>
                                                        <th>Staff Name</th>
                                                        <th>Branch</th>
                                                        <th>Department</th>
                                                        <th>Email / Mobile</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($staff as $key => $val)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $val->name }}</td>
                                                            <td>{{ $val->branch_names }}</td>
                                                            <td>{{ $val->department_name }}</td>
                                                            <td>{{ $val->phone_no }}<br>{{ $val->email }}</td>
                                                            <td class="switch-sm">
                                                                <label class="switch">
                                                                    <input type="checkbox"
                                                                        {{ $val->status == 0 ? 'checked' : '' }}
                                                                        onclick="toggleStatus({{ $val->staff_id }}, this)">
                                                                    <span class="switch-state"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="editStaff({{ $val->staff_id }})">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="viewStaff({{ $val->staff_id }})">
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
                </form>
            </div>
            <div class="modal fade" id="staff_delete" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <br>
                            <h5 style="text-align: center;">Delete ?
                            </h5>
                            <br>
                            <div class="mb-3">
                                <p class="col-form-label" style="text-align: center !important;">Are you sure you want
                                    to delete this data ?</p>
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
            <!-- Container-fluid Ends-->
        </div>
    </div>



    {{-- ------------------------------------- Add Staff Model ----------------------------------------------------- --}}
    <!-- Add Staff Modal -->
    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="status_success_modal"></div> <!-- Unique ID -->
                    <form id="staffForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Staff Name</label>
                                <input type="text" class="form-control" name="staff_name" id="staff_name">
                                <div class="text-danger error_staff_name"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" name="staff_dob" id="staff_dob">
                                <div class="text-danger error_staff_dob"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Gender</label>
                                <select class="form-select" name="staff_gender" id="staff_gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="text-danger error_staff_gender"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Email</label>
                                <input type="email" class="form-control" name="staff_email" id="staff_email">
                                <div class="text-danger error_staff_email"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Mobile</label>
                                <input type="text" class="form-control" name="staff_phone" id="staff_phone">
                                <div class="text-danger error_staff_phone"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Emergency Contact</label>
                                <input type="text" class="form-control" name="staff_emg_phone"
                                    id="staff_emg_phone">
                                <div class="text-danger error_staff_emg_phone"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Address</label>
                                <textarea class="form-control" name="staff_address" id="staff_address"></textarea>
                                <div class="text-danger error_staff_address"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Role</label>
                                <select class="form-select" name="role_id" id="role_name">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_role_id"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date Of Joining</label>
                                <input type="date" class="form-control" name="staff_doj" id="staff_doj">
                                <div class="text-danger error_staff_doj"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Company Name</label>
                                <input type="text" class="form-control"
                                    value="{{ $Company->company_name ?? '' }}" readonly>
                                <input type="hidden" name="company_name"
                                    value="{{ $Company->company_name ?? '' }}">
                            </div>

                            <div class="col-lg-4">
                                <label>Branch</label>
                                <select class="form-select" name="branch_id[]" multiple id="branch_name">
                                    @foreach ($Branchs as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_branch_id"></div>
                            </div>

                            <div class="col-lg-4">
                                <label>Department</label>
                                <select class="form-select" name="department_id" id="department_name">
                                    @foreach ($Departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_department_id"></div>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label>Designation</label>
                                <select class="form-select" name="designation_id" id="designation_name">
                                    @foreach ($designations as $des)
                                        <option value="{{ $des->job_id }}">{{ $des->designation }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_designation_id"></div>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" id="username">
                                <div class="text-danger error_username"></div>
                            </div>

                            <div class="col-lg-4 mt-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                                <div class="text-danger error_password"></div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="add_staff_btn">
                        <span id="btn-text">Submit</span>
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- View Staff Modal -->
    <div class="modal fade" id="viewStaffModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name</th>
                            <td id="view_name"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="view_email"></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td id="view_phone"></td>
                        </tr>
                        <tr>
                            <th>Branch</th>
                            <td id="view_branch"></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td id="view_department"></td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td id="view_designation"></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td id="view_gender"></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td id="view_dob"></td>
                        </tr>
                        <tr>
                            <th>Date of Joining</th>
                            <td id="view_doj"></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td id="view_address"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- ----------------------------------------------------------------------------------------------------- --}}
    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="status_success_edit"></div>
                    <form id="editStaffForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Staff Name</label>
                                <input type="text" class="form-control" name="staff_name" id="edit_staff_name">
                                <div class="text-danger error_staff_name"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" name="staff_dob" id="edit_staff_dob">
                                <div class="text-danger error_staff_dob"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Gender</label>
                                <select class="form-select" name="staff_gender" id="edit_staff_gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="text-danger error_staff_gender"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Email</label>
                                <input type="email" class="form-control" name="staff_email" id="edit_staff_email">
                                <div class="text-danger error_staff_email"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Mobile</label>
                                <input type="text" class="form-control" name="staff_phone" id="edit_staff_phone">
                                <div class="text-danger error_staff_phone"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Emergency Contact</label>
                                <input type="text" class="form-control" name="staff_emg_phone"
                                    id="edit_staff_emg_phone">
                                <div class="text-danger error_staff_emg_phone"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Address</label>
                                <textarea class="form-control" name="staff_address" id="edit_staff_address"></textarea>
                                <div class="text-danger error_staff_address"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Role</label>
                                <select class="form-select" name="role_id" id="edit_role_name">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_role_id"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Date Of Joining</label>
                                <input type="date" class="form-control" name="staff_doj" id="edit_staff_doj">
                                <div class="text-danger error_staff_doj"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Branch</label>
                                {{-- <select class="form-select multiple-checkboxes" name="branch_id[]" multiple
                                    id="edit_branch_name">
                                    @foreach ($Branchs as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select> --}}
                                <select class="form-select" name="branch_id[]" multiple id="edit_branch_name">
                                    @foreach ($Branchs as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_branch_id"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Department</label>
                                <select class="form-select" name="department_id" id="edit_department_name">
                                    @foreach ($Departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_department_id"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Designation</label>
                                <select class="form-select" name="designation_id" id="edit_designation_name">
                                    @foreach ($designations as $des)
                                        <option value="{{ $des->job_id }}">{{ $des->designation }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error_designation_id"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" id="edit_username">
                                <div class="text-danger error_username"></div>
                            </div>
                            <div class="col-lg-4">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="edit_password">
                                <div class="text-danger error_password"></div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="update_staff_btn">
                        <span id="update-btn-text">Update</span>
                        <span id="update-btn-spinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- footer start-->
    @include('footer')
    <!-- footer start-->
    </div>
    </div>
    @include('script')
    <!-- login js-->
    <!-- Plugin used-->
    @include('session_timeout')
    <script>
        $(document).ready(function() {

            // ---------------- CSRF Setup ----------------
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ---------------- DataTable ----------------
            var table = $('#staffTable').DataTable();

            $('#branch_filter').on('change', function() {
                table.column(2).search($(this).val(), false, true).draw();
            });

            $('#department_filter').on('change', function() {
                table.column(3).search($(this).val(), false, true).draw();
            });

            // ---------------- DOB Validation ----------------
            $('#staff_dob').on('change', function() {
                var dob = new Date(this.value);
                var today = new Date();
                var eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today
                    .getDate());
                if (dob > eighteenYearsAgo) {
                    $(".error_staff_dob").text("You must be at least 18 years old.");
                    this.value = '';
                } else {
                    $(".error_staff_dob").text('');
                }
            });

            // ---------------- Add Staff ----------------
            $("#add_staff_btn").click(function() {
                $(".text-danger").html("");
                $("#btn-text").text("Submitting...");
                $("#btn-spinner").removeClass("d-none");
                $("#add_staff_btn").attr("disabled", true);

                $.ajax({
                    url: "{{ url('add_staff') }}",
                    type: "POST",
                    data: $("#staffForm").serialize(),
                    success: function(res) {
                        if (res.status === 200) {
                            toastr.success(res.message || "Staff added successfully");
                            setTimeout(() => location.reload(), 1500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, val) {
                                $(".error_" + key).text(val[0]);
                            });
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    },
                    complete: function() {
                        $("#btn-text").text("Submit");
                        $("#btn-spinner").addClass("d-none");
                        $("#add_staff_btn").attr("disabled", false);
                    }
                });
            });

            // ---------------- View Staff ----------------
            window.viewStaff = function(id) {
                $.ajax({
                    url: `/view_staff/${id}`,
                    method: 'GET',
                    success: function(res) {
                        if (res.status === 200 && res.data.length) {
                            const staff = res.data[0];
                            $('#view_name').text(staff.name);
                            $('#view_email').text(staff.email);
                            $('#view_phone').text(staff.phone_no);
                            $('#view_branch').text(staff.branch_name.join(', '));
                            $('#view_department').text(staff.department_name);
                            $('#view_designation').text(staff.designation_name);
                            $('#view_gender').text(staff.gender);
                            $('#view_dob').text(staff.date_of_birth);
                            $('#view_doj').text(staff.date_of_joining);
                            $('#view_address').text(staff.address);
                            $('#viewStaffModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Failed to fetch staff data');
                    }
                });
            }

            // ---------------- Edit Staff ----------------
            window.editStaff = function(id) {
                $.ajax({
                    url: `/edit_staff/${id}`,
                    method: 'GET',
                    success: function(res) {
                        if (res.status === 200) {
                            const staff = res.data;
                            $('#edit_staff_name').val(staff.name);
                            $('#edit_staff_email').val(staff.email);
                            $('#edit_staff_phone').val(staff.phone_no);
                            $('#edit_staff_dob').val(staff.date_of_birth);
                            $('#edit_staff_doj').val(staff.date_of_joining);
                            $('#edit_staff_gender').val(staff.gender);
                            $('#edit_role_name').val(staff.role_id);
                            $('#edit_department_name').val(staff.department_id);
                            $('#edit_designation_name').val(staff.designation_id);
                            $('#edit_staff_address').val(staff.address);
                            $('#edit_username').val(staff.username);
                            $('#edit_password').val(staff.password);

                            // Multi-select branches
                            let branchIds = normalizeBranchIds(staff.branch_id);
                            $('#edit_branch_name').val(branchIds).trigger('change');

                            $('#editStaffModal').modal('show');

                            $('#update_staff_btn').off('click').on('click', function() {
                                updateStaff(id);
                            });
                        }
                    },
                    error: function() {
                        toastr.error('Failed to fetch staff data');
                    }
                });
            }

            // ---------------- Normalize Branch IDs ----------------
            function normalizeBranchIds(branchArray) {
                if (!Array.isArray(branchArray) || branchArray.length === 0) return [];
                return branchArray.flatMap(item => {
                    try {
                        const parsed = JSON.parse(item);
                        return Array.isArray(parsed) ? parsed : [parsed];
                    } catch (e) {
                        return [item];
                    }
                });
            }

            // ---------------- Update Staff ----------------
            function updateStaff(id) {
                $(".text-danger").html("");
                $("#update-btn-text").text("Updating...");
                $("#update-btn-spinner").removeClass("d-none");
                $("#update_staff_btn").attr("disabled", true);

                $.ajax({
                    url: `/update_staff/${id}`,
                    method: 'POST',
                    data: $('#editStaffForm').serialize(),
                    success: function(res) {
                        if (res.status === 200) {
                            toastr.success(res.message || "Staff updated successfully");
                            setTimeout(() => location.reload(), 1500);
                        }
                    },
                    error: function(err) {
                        if (err.responseJSON && err.responseJSON.error_msg) {
                            $.each(err.responseJSON.error_msg, function(key, val) {
                                $('.error_' + key).text(val[0]);
                            });
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    },
                    complete: function() {
                        $("#update-btn-text").text("Update");
                        $("#update-btn-spinner").addClass("d-none");
                        $("#update_staff_btn").attr("disabled", false);
                    }
                });
            }

            // ---------------- Toggle Status ----------------
            window.toggleStatus = function(staff_id, checkboxElem) {
                let new_status = $(checkboxElem).is(':checked') ? 0 : 1;
                $.ajax({
                    url: `/staff_status/${staff_id}`,
                    method: 'POST',
                    data: {
                        status: new_status
                    },
                    success: function(res) {
                        if (res.status === 200) {
                            toastr.success(res.message || "Status updated successfully");
                        } else {
                            toastr.error('Failed to update status');
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                        $(checkboxElem).prop('checked', !$(checkboxElem).is(':checked'));
                    }
                });
            }

        });
    </script>
</body>

</html>
