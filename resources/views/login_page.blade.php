@include('common')

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <img class="bg-img-cover bg-center" src="{{ asset('assets/logo/Login_Page_2.jpg') }}">
            </div>

            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div class="login-main">
                            <form class="theme-form" id="loginForm">
                                @csrf

                                <h4>Loginssss   </h4>
                                <p>Enter your usernames & password to login</p>

                                <!-- Success / Error Message -->
                                <div id="loginMessage"></div>

                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input class="form-control" type="text" name="username" placeholder="Username">
                                    <small class="text-danger" id="usernameError"></small>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password"
                                            placeholder="Password">
                                        <div class="show-hide" style="cursor:pointer;">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                    <small class="text-danger" id="passwordError"></small>
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100" type="submit" id="loginBtn">
                                        <span id="btnText">Sign in</span>
                                        <span id="btnLoader" class="spinner-border spinner-border-sm d-none"
                                            role="status"></span>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        $(document).ready(function() {

            // =========================
            // AJAX LOGIN
            // =========================
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // Clear old errors
                $('#usernameError').text('');
                $('#passwordError').text('');
                $('#loginMessage').html('');

                $.ajax({
                    url: "{{ route('login.submit') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    beforeSend: function() {
                        $('#loginBtn').prop('disabled', true);
                        $('#btnLoader').removeClass('d-none');
                        $('#btnText').text('Signing in...');
                    },

                    success: function(response) {
                        $('#loginMessage').html(
                            '<div class="alert alert-success">' + response.message +
                            '</div>'
                        );

                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1000);
                    },

                    error: function(xhr) {

                        $('#loginBtn').prop('disabled', false);
                        $('#btnLoader').addClass('d-none');
                        $('#btnText').text('Sign in');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.username) {
                                $('#usernameError').text(errors.username[0]);
                            }

                            if (errors.password) {
                                $('#passwordError').text(errors.password[0]);
                            }
                        }

                        if (xhr.status === 401) {
                            $('#loginMessage').html(
                                '<div class="alert alert-danger">' + xhr.responseJSON
                                .message + '</div>'
                            );
                        }
                    }
                });
            });

            // =========================
            // SHOW / HIDE PASSWORD
            // =========================
            $(document).on('click', '.show-hide', function() {

                let input = $(this).closest('.form-input').find('input');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    $(this).find('span').removeClass('show').addClass('hide');
                } else {
                    input.attr('type', 'password');
                    $(this).find('span').removeClass('hide').addClass('show');
                }

            });

        });
        </script>

        @include('script')
        @include('session_timeout')
    </div>
</body>

</html>