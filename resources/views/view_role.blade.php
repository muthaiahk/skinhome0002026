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
                      <h3>View Manage Role</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="manage_role">Manage Role</a></li>
                        <li class="breadcrumb-item"><a href="view_role">View Manage Role</a></li>
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
                    <div class="card-body">
                      <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Manage Role</label>
                            <input class="form-control" type="text" data-bs-original-title=""  value="" id="role_name" placeholder="Manage Role" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        
                        </div>
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./role_permission'>Cancel</a></button>
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
    @include('script')
    @include('session_timeout')
    
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>