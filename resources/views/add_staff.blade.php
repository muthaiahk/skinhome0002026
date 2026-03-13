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
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- loader ends-->
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
                      <h3>New Staff</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="staff">Staff Lists</a></li>
                        <li class="breadcrumb-item"><a href="add_staff">New Staff</a></li>
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
                    <div  id="status_success">
                     
                    </div>             
                    <div class="card-body">
                      <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Staff Name</label>
                            <input class="form-control" type="text"  placeholder="Staff Name" id="staff_name">
                            <div class="text-danger" id="error_staff_name"></div>
                          </div>
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Date Of Birth</label>
                            <input class="form-control futuredate_disable" type="date" placeholder="Date Of Birth" id="staff_dob" onfocusout="check_date(event)">
                            <div class="text-danger" id="error_staff_dob"></div>
                          </div> -->
                        
                          <div class="col-lg-4 position-relative">
                              <label class="form-label">Date Of Birth</label>
                              <input class="form-control futuredate_disable" type="date" placeholder="Date Of Birth" id="staff_dob" onfocusout="check_dates(event)">
                              <div class="text-danger" id="error_staff_dob"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Gender</label>
                            <select class="form-select" id="staff_gender">
                              <option value="0">Select Gender</option>
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                            </select>
                            <div class="text-danger" id="error_staff_gender"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Email ID</label>
                            <input class="form-control" type="text" placeholder="Email ID"  id="staff_email">
                            <div class="text-danger" id="error_staff_email"></div>
                          </div>
                           <div class="col-lg-4 position-relative">
                            <label class="form-label">Mobile Number</label>
                            <input class="form-control" type="text" placeholder="Mobile Number" id="staff_phone">
                            <div class="text-danger" id="error_staff_phone"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Emergency Contact Number</label>
                            <input class="form-control" type="text" placeholder="Emergency Contact Number" id="staff_emg_phone">
                            <div class="text-danger" id="error_staff_emg_phone"></div>
                          </div>             
                        </div>                      
                        <div class="row mb-3">                          
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" type="text" placeholder="Address" rows="1" id="staff_address"></textarea>
                          
                            <div class="text-danger" id="error_staff_address"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Role</label>
                            <select class="form-select" id="role_name">
                           
                            </select>
                            <div class="text-danger" id="error_role_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date Of Joining</label>
                            <input class="form-control futuredate_disable" type="date" placeholder="Date Of Joining" id="staff_doj"  onfocusout="check_date(event)">
                            <div class="text-danger" id="error_staff_doj"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Company Name</label>
                            <input class="form-control" type="text" placeholder="Company Name" value="" readonly id="company_name">
                            <div class="text-danger" id="error_company_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Branch</label>
                            <select class="form-select " multiple id="branch_name">
                              <!-- <option value="php">PHP</option>
                              <option value="javascript">JavaScript</option>
                              <option value="java">Java</option>
                              <option value="sql">SQL</option>
                              <option value="jquery">Jquery</option>
                              <option value=".net">.Net</option> -->
                            </select>
                            <div class="text-danger" id="error_branch_name"></div>
                          </div>

                          <!-- <div class="col-lg-4 position-relative">
                            <strong>Select Language:</strong>
                              <select id="multiple-checkboxes" multiple="multiple">
                                  <option value="php">PHP</option>
                                  <option value="javascript">JavaScript</option>
                                  <option value="java">Java</option>
                                  <option value="sql">SQL</option>
                                  <option value="jquery">Jquery</option>
                                  <option value=".net">.Net</option>
                              </select>
                          </div> -->
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Department</label>
                            <select class="form-select" id="department_name">
                              
                            
                            </select>
                            <div class="text-danger" id="error_department_name"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Designation</label>
                            <select class="form-select" id="designation_name">
                              
                            </select>
                            <div class="text-danger" id="error_designation_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Username</label>
                            <input class="form-control" type="text" placeholder="Username" id="username">
                            <div class="text-danger" id="error_username"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" placeholder="Password" id="password">
                            <div class="text-danger" id="error_password"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./staff'>Cancel</a></button>
                            <p class="btn btn-primary " id="add_staff" data-bs-original-title="" title="" onclick="add_staff()">Submit</p>
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
    
    
    <!-- login js-->
    <!-- Plugin used-->
  </body>
  <script>
       $(document).ready(function() {
        $('.multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script> 
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"> -->
  
  <script>
    function check_dates(event) {
        var dobInput = event.target;
        var dob = new Date(dobInput.value);
        var currentDate = new Date();
        var eighteenYearsAgo = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());

        if (dob > eighteenYearsAgo) {
            document.getElementById("error_staff_dob").innerHTML = "You must be at least 18 years old.";
            dobInput.value = ""; // Clear the input value
        } else {
            document.getElementById("error_staff_dob").innerHTML = "";
        }
    }
</script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
</html>