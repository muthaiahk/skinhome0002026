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
                                <h3>Add Lead Source</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="lead_source">Lead Source Lists</a></li>
                                    <li class="breadcrumb-item">Add Lead Source</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <form class="form wizard" id="leadSourceForm">
                    @csrf
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
                                                <label class="form-label">Lead Source</label>
                                                <input class="form-control" type="text" data-bs-original-title=""
                                                    id="lead_source_name" placeholder="Source name">
                                                <div class="text-danger" id="error_lead_source_name"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"
                                                    title=""><a href='./lead_source'>Cancel</a></button>
                                                <button class="btn btn-primary" type="button" id="add_l_source"
                                                    onclick="add_lead_source()">

                                                    <span id="btn_text">Submit</span>
                                                    <span id="btn_loader"
                                                        class="spinner-border spinner-border-sm d-none"></span>
                                                </button>
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
    function add_lead_source() {

        // Clear old errors
        $('#error_lead_source_name').text('');

        // Button loading start
        $('#add_l_source').prop('disabled', true);
        $('#btn_text').addClass('d-none');
        $('#btn_loader').removeClass('d-none');

        $.ajax({
            url: '/add_lead_source',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                lead_source_name: $('#lead_source_name').val().trim()
            },
            success: function(res) {

                toastr.success(res.message);

                // Redirect after 1 second
                setTimeout(function() {
                    window.location.href = "/lead_source";
                }, 1000);
            },
            error: function(xhr) {

                // Stop loading
                $('#add_l_source').prop('disabled', false);
                $('#btn_text').removeClass('d-none');
                $('#btn_loader').addClass('d-none');

                if (xhr.status === 401) {
                    let errors = xhr.responseJSON.error_msg;

                    if (errors.lead_source_name) {
                        $('#error_lead_source_name')
                            .text(errors.lead_source_name[0]);
                    }
                } else {
                    toastr.error('Something went wrong');
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