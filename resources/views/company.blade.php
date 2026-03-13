@section('content')

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
    <!-- tap on top ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('header')
        <!-- Page Header Ends-->

        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('sidebar')
            <!-- Page Sidebar Ends-->

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Company Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Company Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Table -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="company_table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($companies as $company)
                                                <tr data-id="{{ $company->company_id }}">
                                                    <td>{{ $company->company_name }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" class="statusToggle"
                                                                data-id="{{ $company->company_id }}"
                                                                {{ $company->status == 1 ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <!-- Edit button -->
                                                        <a href="{{ route('company.edit', $company->company_id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="status_success" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('footer')
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <!-- DataTables CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        // Status toggle click
        $(document).on('change', '.statusToggle', function() {
            let company_id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/company/status/' + company_id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(res) {
                    if (res.status == 200) {
                        alert('Status updated successfully!');
                    } else {
                        alert('Failed to update status.');
                    }
                },
                error: function(err) {
                    alert('Something went wrong!');
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#company_table').DataTable({
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50],
            "order": [
                [0, "asc"]
            ]
        });

        let logo_img = null;
        let fav_img = null;
        let default_img = null;

        // Edit button click
        $(document).on('click', '.editBtn', function() {
            let tr = $(this).closest('tr');
            let company_id = tr.data('id');

            $.get('/edit_company/' + company_id, function(res) {
                if (res.status == 200) {
                    let data = res.data;
                    $('#company_name').val(data.company_name);
                    $('#mobile').val(data.phone_no);
                    $('#website').val(data.website);
                    $('#Select_date').val(data.date_format);
                    $('#opening_date').val(data.established_date);

                    $('#logo_gs').attr('src', data.logo);
                    $('#fav_gs').attr('src', data.favicon);
                    $('#default_gs').attr('src', data.default_pic);

                    $('#updateBtn').data('id', company_id);
                }
            });
        });

        // Update button click
        $('#updateBtn').click(function() {
            let company_id = $(this).data('id');
            let btn = $(this);
            btn.prop('disabled', true).html('Updating...');

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('company_name', $('#company_name').val());
            formData.append('mobile', $('#mobile').val());
            formData.append('website', $('#website').val());
            formData.append('date_format', $('#Select_date').val());
            formData.append('opening_date', $('#opening_date').val());

            if (logo_img) formData.append('logo', logo_img);
            if (fav_img) formData.append('favicon', fav_img);
            if (default_img) formData.append('default_pic', default_img);

            $.ajax({
                url: '/company/' + company_id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status == 200) {
                        $('#status_success').html('<div class="alert alert-success">' + res
                            .message + '</div>');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        alert(res.message);
                    }
                },
                error: function(err) {
                    alert("Something went wrong!");
                },
                complete: function() {
                    btn.prop('disabled', false).html('Update');
                }
            });
        });
    });
    </script>
</body>

</html>