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
                      <h3>View Role Permission</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="role_permission">Role permission</a></li>
                        <li class="breadcrumb-item"><a href="view_permission">View Role Permission</a></li>
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
                            <label class="form-label">Role</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Company" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date</label>
                            <input class="form-control" type="date" data-bs-original-title="" placeholder="Date" required="" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Time</label>
                            <input class="form-control" type="time" data-bs-original-title="" placeholder="Time" required="" readonly>
                            <div class="valid-tooltip"></div>
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