@include('common')

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
                                <h3>Brand Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('dashboard') }}"><i data-feather="home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">Brand Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Brand table card -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div id="status_success"></div>

                                <div class="card-header text-end">
                                    <a href="{{ url('add_brand') }}" class="btn btn-primary">Add Brand</a>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="brandTable">
                                            <thead>
                                                <tr>
                                                    <th>Brand Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($brands as $brand)
                                                @php
                                                $statusChecked = $brand->status == 1 ? "checked" : "";
                                                @endphp
                                                <tr>
                                                    <td>{{ $brand->brand_name }}</td>

                                                    <!-- Status toggle -->
                                                    <td class="media-body switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $statusChecked }}
                                                                onchange="changeBrandStatus({{ $brand->brand_id }}, this.checked ? 1 : 0)">
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </td>

                                                    <!-- Action buttons -->
                                                    <td>
                                                        <a href="{{ url('edit_brand/'.$brand->brand_id) }}">
                                                            <i class="fa fa-edit text-primary"></i>
                                                        </a>
                                                        <a href="#"
                                                            onclick="confirmDelete({{ $brand->brand_id ?? 0 }})">
                                                            <i class="fa fa-trash eyc"></i>
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
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="brand_delete" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h5>Delete?</h5>
                            <p>Are you sure you want to delete this brand?</p>
                        </div>
                        <div class="card-footer text-center mb-3">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal"
                                id="delete_brand_btn">Yes, delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#brandTable').DataTable();
    });

    function changeBrandStatus(id, status) {
        $.ajax({
            url: `/brand_status/${id}`,
            type: 'GET',
            data: {
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

    let brandToDeleteId = null;

    // Open modal and store ID
    function confirmDelete(id) {
        brandToDeleteId = id;
        $('#brand_delete').modal('show'); // Show Bootstrap modal
    }
    </script>
    @include('script')
    <!-- login js-->
    <!-- Plugin used-->
    @include('session_timeout')


</body>

</html>