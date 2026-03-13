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
                <h3>Modify Role</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                    <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item"><a href="role_permission">Role Lists</a></li>
                    <li class="breadcrumb-item">Modify Role</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->         
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">                    
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-lg-4 position-relative">
                        <label class="form-label"><span style="font-size:17px;">Role</span></label>
                        <input class="form-control" type="text" placeholder="Role" value="Accoutant">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="default-according style-1" id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_one" aria-expanded="false" aria-controls="collapseOne"><h6 class=" form-label">Dashboard</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_one" aria-labelledby="headingOne" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingtwo">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_two" aria-expanded="false" aria-controls="collapsetwo"><h6 class=" form-label">Lead</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_two" aria-labelledby="headingtwo" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingthree">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_three" aria-expanded="false" aria-controls="collapsethree"><h6 class=" form-label">Customer</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_three" aria-labelledby="headingthree" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingfour">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_four" aria-expanded="false" aria-controls="collapsefour"><h6 class=" form-label">Appointment</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_four" aria-labelledby="headingfour" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingfive">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_five" aria-expanded="false" aria-controls="collapsefive"><h6 class=" form-label">Staff</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_five" aria-labelledby="headingfive" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingsix">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_six" aria-expanded="false" aria-controls="collapsesix"><h6 class=" form-label">Treatment</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_six" aria-labelledby="headingsix" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingsevan">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_sevan" aria-expanded="false" aria-controls="collapsesevan"><h6 class=" form-label">Payment</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_sevan" aria-labelledby="headingsevan" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingeight">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_eight" aria-expanded="false" aria-controls="collapseeight"><h6 class=" form-label">Inventory</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_eight" aria-labelledby="headingeight" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row mb-3">
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-3">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingnine">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_nine" aria-expanded="false" aria-controls="collapsenine"><h6 class=" form-label">Report</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_nine" aria-labelledby="headingnine" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Lead Report</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Appointment Report</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Stock Report</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Attendance Report</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Payments Report</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingten">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon_ten" aria-expanded="false" aria-controls="collapseten"><h6 class=" form-label">Settings</h6></button>
                            </h5>
                          </div>
                          <div class="collapse" id="collapseicon_ten" aria-labelledby="headingten" data-bs-parent="#accordion">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">General Setting</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Email Configuration</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Company</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Branch</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Department</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Designation</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Brand</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Lead Source</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Lead Status</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Product</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Product Category</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Treatment</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Treatment Category</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                  <h6 class=" form-label">Role</h6>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Add</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Edit</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">View</label>
                                </div>
                                <div class="col-lg-2">
                                  <label class="d-block">
                                  <input class="checkbox_animated" type="checkbox" data-bs-original-title="" title="">Delete</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>              
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="card-footer text-end">
                         <button class="btn btn-secondary" type="reset" >Cancel</button>
                         <button class="btn btn-primary" type="submit" >Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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