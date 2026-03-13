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
                                <h3>Designation Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Designation Lists</li>
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
                                    <a href="add_designation" type="button" class="btn btn-primary" type="submit"
                                        data-bs-original-title="">Add Designation</a>
                                </div>

                                <div class="card-body">
                                    <table id="designationTable" class="table table-bordered table-striped"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Designation</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($designations as $designation)
                                            <tr>
                                                <td>{{ $designation->company_name }}</td>
                                                <td>{{ $designation->designation }}</td>
                                                <td>{{ $designation->description ?? 'N/A' }}</td>

                                                <td class="media-body switch-sm">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                            {{ $designation->status == 1 ? 'checked' : '' }}
                                                            onchange="changeStatus({{ $designation->job_id }}, this.checked ? 1 : 0)">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ url('edit_designation/' . $designation->job_id) }}"
                                                        class="text-primary me-2" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                        onclick="confirmDelete({{ $designation->job_id }})"
                                                        class="text-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
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

                    <!-- Container-fluid Ends-->
                </div>
            </div>

            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Are you sure you want to delete this designation?</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    $(document).ready(function() {
        $('#designationTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10
        });
    });

    function changeStatus(id, status) {
        $.ajax({
            url: `/designation_status/${id}`,
            type: 'POST', // POST request
            data: {
                _token: '{{ csrf_token() }}', // CSRF token included here
                status: status
            },
            success: function(res) {
                toastr.success('Status updated successfully');
            },
            error: function() {
                toastr.error('Error updating status');
            }
        });
    }

    let deleteId = null;

    function confirmDelete(id) {
        deleteId = id;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    $('#confirmDeleteBtn').click(function() {
        if (!deleteId) return;
        $.ajax({
            url: `/delete_designation/${deleteId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                toastr.success('Designation deleted successfully');
                location.reload();
            },
            error: function() {
                toastr.error('Failed to delete designation');
            }
        });
    });
    </script>
    <!-- login js-->
    <!-- Plugin used-->

</body>

</html>