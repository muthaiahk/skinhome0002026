@include('common')

<body>
    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')

        <div class="page-body-wrapper">
            @include('sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Modify Company</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('edit_company') }}"><i
                                                data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('company') }}">Company Lists</a></li>
                                    <li class="breadcrumb-item">Modify Company</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">

                                    <form id="updateCompanyForm" method="POST"
                                        action="{{ url('update_company', $company->company_id) }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Company Name</label>
                                                <input class="form-control" type="text" name="company_name"
                                                    value="{{ old('company_name', $company->company_name) }}" required>
                                                <small class="text-danger" id="company_name_error"></small>
                                            </div>
                                        </div>

                                        <div class="card-footer text-end">
                                            <a href="{{ url('company') }}" class="btn btn-secondary">Cancel</a>
                                            <button class="btn btn-primary" type="submit" id="submitBtn">
                                                <span id="btnText">Submit</span>
                                                <span id="btnSpinner"
                                                    class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('footer')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- AJAX Script -->
    <script>
    $(document).ready(function() {
        $('#updateCompanyForm').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            // Clear previous error
            $('#company_name_error').text('');

            // Show spinner
            $('#btnText').text('Submitting...');
            $('#btnSpinner').removeClass('d-none');
            $('#submitBtn').prop('disabled', true);

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    toastr.success('Company updated successfully!');
                    setTimeout(function() {
                        window.location.href = "{{ url('company') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.company_name) {
                            $('#company_name_error').text(errors.company_name[0]);
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again!');
                    }
                },
                complete: function() {
                    // Hide spinner & enable button
                    $('#btnText').text('Submit');
                    $('#btnSpinner').addClass('d-none');
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });
    });
    </script>

    @include('script')
    @include('session_timeout')
</body>

</html>