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
              <!-- <div><a class="logo text-start" href="/dashboard"><img class="img-fluid for-light" src="{{ asset('assets/images/logo/login.png') }}" alt="looginpage"><img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="looginpage"></a></div> -->
              <!-- <div class="login-main"> 
                <form class="theme-form">
                  <h4>Login</h4>
                  <p>Enter your username & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Username</label>
                    <input class="form-control" type="text" placeholder="Username" id="username">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="p_word" placeholder="Password" id="password">
                      <div class="show-hide" onclick="show_password();" id="pass">
                          <span class="show"></span>
                      </div>
                   
                    </div>
                  </div>
                  <p class="text-danger" id="login_error"></p>
                  <div class="form-group mb-0">
                  
                    <a  class="btn btn-primary btn-block w-100" type="submit" id="login" onclick="login()">Sign in</a>
                  </div>
                
                </form>
              </div> -->
              <div class="login-main"> 
                <form class="theme-form" onsubmit="event.preventDefault(); login();">
                  <h4>Login</h4>
                  <p>Enter your username & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Username</label>
                    <input class="form-control" type="text" placeholder="Username" id="username">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="p_word" placeholder="Password" id="password">
                      <div class="show-hide" onclick="show_password();" id="pass"><span class="show"></span></div>
                    </div>
                  </div>
                  <p class="text-danger" id="login_error"></p>
                  <div class="form-group mb-0">
                    <button id="loginButton" class="btn btn-primary btn-block w-100" type="submit">
                      <span class="button-text">Sign in</span>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                    </button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
      @include('script')
      
      <script>
        if(sessionStorage.getItem('token')){
          //alert(sessionStorage.getItem('token'))
          window.location.href = "./dashboard";
        }

        function show_password(){
                 var x = document.getElementById("password");
          if (x.type === "password") {
            x.type = "text";
            
          } else {
            x.type = "password";
          }
        }
        // function show_password() {
        //     var passwordInput = document.getElementById('password'); // Assuming you have an input field with id 'password'
        //     var toggleButton = document.getElementById('pass');
        //     var showSpan = toggleButton.querySelector('.show');

        //     if (passwordInput.type === 'password') {
        //         passwordInput.type = 'text';
        //         showSpan.textContent = 'Hide';
        //     } else {
        //         passwordInput.type = 'password';
        //         showSpan.textContent = 'Show';
        //     }
        // }
      </script>
      <!-- Plugin used-->
    </div>
  </body>
</html>