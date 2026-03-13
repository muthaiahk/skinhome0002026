@include('common')

<body onload="startTime()">
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
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
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
                                <h3>Department Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Department Lists</li>
                                    <!-- <li class="breadcrumb-item active">Default</li> -->
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
                                <div id="status_success">

                                </div>
                                <div class="card-header text-end">
                                    <a href="{{ route('department.create') }}" class="btn btn-primary">Add
                                        Department</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="table table-bordered" id="departmentTable">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Branch Name</th>
                                                    <th>Department Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($departments as $dept)
                                                @php
                                                $statusChecked = $dept->status == "0" ? "checked" : "";
                                                @endphp
                                                <tr>
                                                    <td>{{ $dept->company_name }}</td>
                                                    <td>{{ $dept->branch_name }}</td>
                                                    <td>{{ $dept->department_name }}</td>

                                                    <!-- <td>
                                                        <button
                                                            class="btn btn-sm {{ $dept->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                            onclick="changeStatus({{ $dept->department_id }}, {{ $dept->status == 1 ? 0 : 1 }})">
                                                            {{ $dept->status == 1 ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </td> -->

                                                    <td class="media-body switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $statusChecked }}
                                                                onclick="changeStatus({{ $dept->department_id }}, {{ $dept->status == 1 ? 0 : 1 }})">
                                                            <span class="switch-state">
                                                            </span>
                                                        </label>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('department.edit', $dept->department_id) }}">
                                                            <i class="fa fa-edit text-primary"></i>
                                                        </a>

                                                        <a href="javascript:void(0);"
                                                            onclick="openDeleteModal({{ $dept->department_id }})">
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
                    <!-- Container-fluid Ends-->
                </div>
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <div class="modal fade" id="department_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <br>
                    <h5>Delete ?</h5><br>
                    <p>Are you sure you want to delete this Data.</p>

                    <!-- Hidden input to store ID -->
                    <input type="hidden" id="delete_department_id">
                </div>

                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">
                        No, Cancel
                    </button>

                    <button class="btn btn-primary" type="button" id="confirmDelete">
                        Yes, delete
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#departmentTable').DataTable();
    });
    </script>
    <script>
    function changeStatus(id, status) {
        $.ajax({
            url: "/department/status/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: status
            },
            success: function(response) {
                toastr.success(response.message);
                // setTimeout(function() {
                //     location.reload();
                // }, 1000);
            }
        });
    }
    </script>
    <script>
    function openDeleteModal(id) {
        $('#delete_department_id').val(id);
        $('#department_delete').modal('show');
    }


    // When clicking Yes Delete
    $('#confirmDelete').click(function() {

        let id = $('#delete_department_id').val();

        $.ajax({
            url: "/department/delete/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                $('#department_delete').modal('hide');

                if (response.status == 200) {
                    toastr.success(response.message);

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error("Delete failed!");
                }
            },
            error: function() {
                toastr.error("Something went wrong!");
            }
        });

    });
    </script>
    @include('script')
    @include('session_timeout')

</body>

</html>