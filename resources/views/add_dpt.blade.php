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
                                <h3>Add Department</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                data-feather="home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('department') }}">Department Lists</a>
                                    </li>
                                    <li class="breadcrumb-item">Add Department</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="department_form">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success"></div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label>Company Name</label>
                                                <input class="form-control" type="text" id="company_name"
                                                    value="{{ $companies[0]->company_name ?? '' }}" readonly>
                                                <div class="text-danger" id="error_company_name"></div>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <label class="form-label">Branch Authority</label>
                                                <select name="branch_id" id="branch_id" class="form-control">
                                                    <option value="">Select Branch</option>
                                                    @foreach($brandchs as $brandch)
                                                    <option value="{{ $brandch->branch_id }}">
                                                        {{ $brandch->branch_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Department Name</label>
                                                <input class="form-control" type="text" id="department_name">
                                                <div class="text-danger" id="error_department_name"></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <a href="{{ url('department') }}" class="btn btn-secondary">Cancel</a>
                                            <button type="button" class="btn btn-primary"
                                                id="add_depart">Submit</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- footer start-->
            @include('footer')
            <!-- footer start-->
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#add_depart').click(function(e) {
            e.preventDefault();

            // Clear previous errors
            $('#error_company_name').text('');
            $('#error_department_name').text('');
            $('#status_success').html('');

            // Show loading (spinner inside button)
            let $btn = $(this);
            $btn.prop('disabled', true);
            let originalText = $btn.html();
            $btn.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );

            $.ajax({
                url: "{{ route('department.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    company_name: $('#company_name').val(),
                    branch_id: $('#branch_id').val(),
                    department_name: $('#department_name').val(),
                },
                success: function(res) {
                    if (res.status == 1 || res.status == 200) {
                        toastr.success(res.message);

                        // Optionally reset form
                        $('#department_form')[0].reset();

                        // Re-enable button
                        $btn.prop('disabled', false);
                        $btn.html(originalText);
                    } else {
                        toastr.error(res.message);

                        $btn.prop('disabled', false);
                        $btn.html(originalText);
                    }
                },
                error: function(err) {
                    let errors = err.responseJSON.errors;

                    if (errors) {
                        if (errors.company_name) $('#error_company_name').text(errors
                            .company_name[0]);
                        if (errors.department_name) $('#error_department_name').text(errors
                            .department_name[0]);
                    } else {
                        toastr.error('Server error, please try again!');
                    }

                    // Re-enable button
                    $btn.prop('disabled', false);
                    $btn.html(originalText);
                }
            });
        });
    });
    </script>
    @include('script')
    @include('session_timeout')

    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>