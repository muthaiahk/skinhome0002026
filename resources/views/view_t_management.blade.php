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
                      <h3>Modify Treatment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="treatment_management">Treatment List</a></li>
                        <li class="breadcrumb-item">View Treatment</li>
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
                            <label class="form-label">Customer Name</label>
                            <select class="form-select" id="edit_customer_name" disabled>
                              
                            </select>
                            <div class="text-danger" id="error_edit_customer_name"></div>
                        </div> 

                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Mobile Number</label>
                          <input class="form-control" type="text" readonly  id="mobile" onkeypress="mobile_search(event)" placeholder="Enter mobile number"  data-bs-original-title="" title="" value="" > 
                          <div class="text-danger" id="error_mobile"></div>
                          
                        </div>
                        <div class="col-lg-4 position-relative">
                            <label class="form-label">Treatment Categories</label>
                            <select class="form-select" disabled id="edit_tc_name">
                              
                            </select>
                            <div class="text-danger" id="error_edit_tc_name"></div>
                        </div>
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Treatment Name</label>
                            <select class="form-select" disabled id="edit_treatment_name">
                              
                            </select>
                            <div class="text-danger" id="error_edit_treatment_name"></div>
                        </div>
                                                                         
                      </div>
                        
                          <!-- <div class="col-lg-4 position-relative ">
                            <label class="form-label required">Discount</label>
                            <input class="form-control" required="reuired" type="text" oninput="pay_amount(event)" placeholder="Discount " value='0' id="discount">
                             <div class="text-danger" id="error_discount"></div>
                          </div> -->
                                                        
                                       
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><a href='./treatment_management'>Cancel</a></button>
                           
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