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
                                <h3>Lead Source Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Lead Source Lists</li>
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
                                    <a href="/add_lead_source" type="button" class="btn btn-primary" type="submit"
                                        id="add_lead_source" data-bs-original-title="">Add Lead Source</a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered" id="leadSourceTable">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Lead Source</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lead_sources as $i => $source)
                                            <tr id="row_{{ $source->lead_source_id }}">
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $source->lead_source_name }}</td>

                                                <!-- Status Toggle -->
                                                <td class="switch-sm">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                            {{ $source->status == 1 ? 'checked' : '' }}
                                                            onchange="changeStatus({{ $source->lead_source_id }}, this.checked ? 1 : 0)">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </td>

                                                <!-- Actions -->
                                                <td>
                                                    <a href="{{ url('view_lead_source/'.$source->lead_source_id) }}">
                                                        <i class="fa fa-eye text-info"></i>
                                                    </a>

                                                    <a href="{{ url('edit_lead_source/'.$source->lead_source_id) }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        onclick="confirmDelete({{ $source->lead_source_id }})">
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

                    <!-- Container-fluid Ends-->
                </div>
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="lead_source_delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>Delete?</h5>
                    <p>Are you sure you want to delete this Lead Source?</p>
                </div>
                <div class="card-footer text-center mb-3">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" id="delete_btn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#leadSourceTable').DataTable();
    });


    // STATUS CHANGE
    function changeStatus(id, status) {
        $.ajax({
            url: '/brand_status/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(res) {
                toastr.success(res.message);
            },
            error: function(xhr) {
                toastr.error('Status update failed');
            }
        });
    }

    // DELETE
    let deleteId = null;

    function confirmDelete(id) {
        deleteId = id;
        $('#lead_source_delete').modal('show');
    }

    $('#delete_btn').click(function() {

        if (!deleteId) return;

        $.ajax({
            url: '/delete_brand/' + deleteId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(res) {
                toastr.success(res.message);
                $('#lead_source_delete').modal('hide');
                $('#row_' + deleteId).remove();
            },
            error: function(xhr) {
                toastr.error('Delete failed');
            }
        });
    });
    </script>

    @include('script')
    <!-- login js-->
    <!-- Plugin used-->
    @include('session_timeout')


</body>

</html>