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
                      <h3>View Staff</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="staff">Staff Lists</a></li>
                        <li class="breadcrumb-item">View Staff</li>
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
                    <div class="card-body">
                      <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Staff Name</label>
                            <input class="form-control" type="text"  placeholder="Staff Name" Value="" id="staff_name_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date Of Birth</label>
                            <input class="form-control" type="date" placeholder="Date Of Birth" Value="" id="staff_dob_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Gender</label>
                            <input class="form-control" type="text" placeholder="Gender" Value="" id="staff_gender_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Email ID</label>
                            <input class="form-control" type="text" placeholder="Email ID" id="staff_email_v" Value="" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                           <div class="col-lg-4 position-relative">
                            <label class="form-label">Mobile Number</label>
                            <input class="form-control" type="text" placeholder="Mobile Number" Value="" id="staff_phone_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Emergency Contact Number</label>
                            <input class="form-control" type="text" placeholder="Emergency Contact Number" Value="" id="staff_emg_phone_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>             
                        </div>                      
                        <div class="row mb-3">                          
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" type="text" placeholder="Address" rows="1" Value="" required="" readonly id="staff_address_v"></textarea>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Role</label>
                            <input class="form-control" type="text" placeholder="Role" Value="" id="role_name_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date Of Joining</label>
                            <input class="form-control" type="date" placeholder="Date Of Joining" Value="" id="staff_doj_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Company Name</label>
                            <input class="form-control" type="text" placeholder="Company Name" Value="" id="company_name_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Branch</label>
                            <input class="form-control" type="text" placeholder="Branch" Value="" required="" readonly id="branch_name_v">
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Department</label>
                            <input class="form-control" type="text" placeholder="Department" Value="" id="department_name_v" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Designation</label>
                            <input class="form-control" type="text" placeholder="Designation" Value="" required="" id="designation_name_v"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Username</label>
                            <input class="form-control" type="text" readonly placeholder="Username" id="username_v">
                            <div class="text-danger" id="error_username"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="text" readonly placeholder="Password" id="password_v">
                            <div class="text-danger" id="error_password"></div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./staff'>Cancel</a></button>
                            <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                          </div>
                      </div>
                        <!-- <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="reset">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
                          </div>
                      </div> -->
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
</html>