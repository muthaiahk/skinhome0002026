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
                                <h3>Add Brand</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="brand">Brand Lists</a></li>
                                    <li class="breadcrumb-item">Add Brand</li>
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
                                                <label class="form-label">Brand Name</label>
                                                <input type="text" id="brand_name" class="form-control"
                                                    placeholder="Enter Brand Name">
                                                <div class="text-danger" id="error_brand_name"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <a href="{{ url('brand') }}" class="btn btn-secondary">Cancel</a>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="add_brand()">Submit <span id="btnLoader"
                                                        class="spinner-border spinner-border-sm d-none"></span></button>
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
    <script>
    function add_brand() {

        $('#error_brand_name').text('');

        // Disable button + show loader
        $('#addBrandBtn').prop('disabled', true);
        $('#btnText').addClass('d-none');
        $('#btnLoader').removeClass('d-none');

        $.ajax({
            url: "{{ url('add_brand') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                brand_name: $('#brand_name').val()
            },
            success: function(res) {
                toastr.success(res.success);
                window.location.href = "{{ url('brand') }}";
            },
            error: function(xhr) {

                // Enable button again
                $('#addBrandBtn').prop('disabled', false);
                $('#btnText').removeClass('d-none');
                $('#btnLoader').addClass('d-none');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.brand_name) {
                        $('#error_brand_name').text(errors.brand_name[0]);
                    }
                }
            }
        });
    }
    </script>
    @include('script')
    @include('session_timeout')

    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>