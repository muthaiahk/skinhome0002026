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
                                <h3>Branch Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Branch Lists</li>
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
                                    <a id="add_branch" href="{{ route('branch.create') }}" class="btn btn-primary">
                                        Add Branch
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive product-table" id="branch_list">
                                        <table class="display" id="advance-1">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Company Name</th>
                                                    <th>Branch Name</th>
                                                    <th>Branch Authority</th>
                                                    <th>Opening Date</th>
                                                    <th>Branch Contact No</th>
                                                    <th>Branch Location</th>
                                                    <th>Branch Email ID</th>
                                                    <th>Is Franchise</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($branches as $index => $branch)
                                                @php
                                                $franchise = $branch->is_franchise == "1" ? "Yes" : "No";
                                                $statusChecked = $branch->status == "0" ? "checked" : "";
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $branch->company_name }}</td>
                                                    <td>{{ $branch->branch_name }}</td>
                                                    <td>{{ $branch->authority_name }}</td>
                                                    <td>{{ $branch->branch_opening_date }}</td>
                                                    <td>{{ $branch->branch_phone }}</td>
                                                    <td>{{ $branch->branch_location }}</td>
                                                    <td>{{ $branch->branch_email }}</td>
                                                    <td>{{ $franchise }}</td>
                                                    <!-- <td>
                                                        <button
                                                            class="btn btn-sm {{ $branch->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                            onclick="toggleStatus({{ $branch->branch_id }})">
                                                            {{ $branch->status == 1 ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </td> -->
                                                    <td class="media-body switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" {{ $statusChecked }}
                                                                onclick="toggleStatus({{ $branch->branch_id }})">
                                                            <span class="switch-state">
                                                            </span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('branch.show', $branch->branch_id) }}">
                                                            <i class="fa fa-eye eyc"></i>
                                                        </a>

                                                        <a href="{{ route('branch.edit', $branch->branch_id) }}">
                                                            <i class="fa fa-edit eyc"></i>
                                                        </a>

                                                        <a href="javascript:void(0);"
                                                            onclick="deleteBranch({{ $branch->branch_id }})">
                                                            <i class="fa fa-trash eyc text-danger"></i>
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
    <div class="modal fade" id="branch_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes,
                        delete</span></button>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Initialize DataTables (same as your JS function)
    $(document).ready(function() {
        $('#advance-1').DataTable();
    });
    </script>
    <script>
    function deleteBranch(id) {
        if (confirm("Are you sure you want to delete this branch?")) {
            $.ajax({
                url: "/branch/delete/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }

                },
                error: function() {
                    toastr.error("Something went wrong!");
                }
            });
        }
    }



    function toggleStatus(id) {
        $.ajax({
            url: "/branch/toggle-status/" + id,
            type: "GET",
            success: function(response) {

                toastr.success("Status updated successfully!");

                setTimeout(function() {
                    location.reload();
                }, 1000);

            },
            error: function() {
                toastr.error("Unable to update status!");
            }
        });
    }
    </script>
    @include('script')
    @include('session_timeout')

</body>

</html>