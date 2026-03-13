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
                                <h3>Add Designation</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="designation">Designation Lists</a></li>
                                    <li class="breadcrumb-item">Add Designation</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <form class="form wizard">
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
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Comapany Name</label>
                                                <input class="form-control" type="text" data-bs-original-title=""
                                                    placeholder="Comapany Name" id="company_name"
                                                    value="{{ $designations->company_name}}" readonly>
                                                <div class="text-danger" id="error_company_name"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Designation</label>
                                                <input class="form-control" type="text" data-bs-original-title=""
                                                    placeholder="Designation" id="designation">
                                                <div class="text-danger" id="error_designation"></div>
                                            </div>
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" type="text" data-bs-original-title=""
                                                    placeholder="Description" rows="1" id="description"></textarea>
                                                <div class="text-danger" id="error_description"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"
                                                    title=""><a href='./designation'>Cancel</a></button>
                                                <button class="btn btn-primary" type="button" data-bs-original-title=""
                                                    title="" id="add_desig" onclick="add_designation()">Submit</button>
                                                <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
    function add_designation() {
        // Clear previous errors and messages
        $('#error_company_name').text('');
        $('#error_designation').text('');
        $('#error_description').text('');
        $('#status_success').html('');

        // Disable button and show loading text
        let btn = $('#add_desig');
        let originalText = btn.html();
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: "{{ route('designationSave') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                company_name: $('#company_name').val(),
                designation: $('#designation').val(),
                description: $('#description').val()
            },
            success: function(res) {
                if (res.status === 200) {
                    toastr.success(res.message);
                    // Reset the form
                    $('#designation').val('');
                    $('#description').val('');
                } else {
                    toastr.error(res.message || 'Something went wrong');
                }
            },
            error: function(err) {
                let errors = err.responseJSON?.errors;
                if (errors) {
                    if (errors.company_name) $('#error_company_name').text(errors.company_name[0]);
                    if (errors.designation) $('#error_designation').text(errors.designation[0]);
                    if (errors.description) $('#error_description').text(errors.description[0]);
                } else {
                    toastr.error('Server error, please try again!');
                }
            },
            complete: function() {
                // Re-enable button and restore text
                btn.prop('disabled', false);
                btn.html(originalText);
            }
        });
    }
    </script>
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>