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
                                <h3>Modify Department</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                data-feather="home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('department') }}">Department Lists</a>
                                    </li>
                                    <li class="breadcrumb-item">Modify Department</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="edit_department_form">
                    @csrf
                    <input type="hidden" id="department_id" value="{{ $department->department_id }}">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success"></div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <!-- Company Name -->
                                            <div class="col-lg-4">
                                                <label>Company Name</label>
                                                <input class="form-control" type="text" id="company_name"
                                                    value="{{ $department->company_name }}" readonly>
                                                <div class="text-danger" id="error_company_name"></div>
                                            </div>

                                            <!-- Branch Dropdown -->
                                            <div class="col-lg-4 mb-3">
                                                <label>Branch Authority</label>
                                                <select name="branch_id" id="branch_id" class="form-control">
                                                    <option value="">Select Branch</option>
                                                    @foreach($branches as $branch)
                                                    <option value="{{ $branch->branch_id }}"
                                                        {{ $department->branch_id == $branch->branch_id ? 'selected' : '' }}>
                                                        {{ $branch->branch_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" id="error_branch_id"></div>
                                            </div>

                                            <!-- Department Name -->
                                            <div class="col-lg-4">
                                                <label>Department Name</label>
                                                <input class="form-control" type="text" id="department_name"
                                                    value="{{ $department->department_name }}">
                                                <div class="text-danger" id="error_department_name"></div>
                                            </div>
                                        </div>

                                        <div class="card-footer text-end">
                                            <a href="{{ url('department') }}" class="btn btn-secondary">Cancel</a>
                                            <button type="button" class="btn btn-primary" id="upd_depart">
                                                <span id="loading_text" style="display:none;"><i
                                                        class="fa fa-spinner fa-spin"></i> Updating...</span>
                                                <span id="btn_text">Submit</span>
                                            </button>
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
    $('#upd_depart').click(function() {
        update_department();
    });

    function update_department() {
        // Clear previous errors
        $('#error_company_name').text('');
        $('#error_branch_id').text('');
        $('#error_department_name').text('');
        $('#status_success').html('');

        var id = $('#department_id').val();

        // Show loading
        $('#btn_text').hide();
        $('#loading_text').show();

        $.ajax({
            url: "/department/update/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                company_name: $('#company_name').val(),
                branch_id: $('#branch_id').val(),
                department_name: $('#department_name').val()
            },
            success: function(res) {
                $('#btn_text').show();
                $('#loading_text').hide();

                if (res.status == 200) {
                    toastr.success('Department updated successfully!');
                    setTimeout(() => {
                        window.location.href = "{{ url('department') }}";
                    }, 1000);
                } else {
                    toastr.error(res.message || 'Update failed');
                }
            },
            error: function(err) {
                $('#btn_text').show();
                $('#loading_text').hide();

                if (err.responseJSON?.errors) {
                    let errors = err.responseJSON.errors;
                    if (errors.branch_id) $('#error_branch_id').text(errors.branch_id[0]);
                    if (errors.department_name) $('#error_department_name').text(errors.department_name[0]);
                } else {
                    toastr.error('Server error! Please try again.');
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