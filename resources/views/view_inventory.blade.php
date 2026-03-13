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
                      <h3>View Inventory</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="inventory">Inventory Lists</a></li>
                        <li class="breadcrumb-item">View Inventory</li>
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
            <form class="form wizard">
              <!-- Container-fluid starts-->
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
                            <label class="form-label">Date</label>
                            <input class="form-control digits" type="date" placeholder="Date Of Birth" id="inventory_date" disabled>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Company Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="company_name" placeholder="Company Name"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Branch</label>
                            <input class="form-control" type="text" data-bs-original-title=""  id="branch_name"placeholder="Branch"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>                        
                        </div>
                        <div class="row mb-3"> 
                        <div class="col-lg-4 position-relative">
                            <label class="form-label">Brand</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="brand_name" placeholder="Brand"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>                         
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Product Categories</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="prod_cat_name" placeholder="Product Categories"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Product Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="product_name" placeholder="Product Name"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Stock in Hand</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="stock_in_hand" placeholder="Stock in Hand"  readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Stock Alert Count</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="stock_alert_count" placeholder="Stock Alert Count" readonly>
                            <div class="valid-tooltip"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Description" rows="1" id="description" disabled></textarea>
                            <div class="valid-tooltip"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./inventory'>Cancel</a></button>
                            <!-- <button class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_branch()">Submit</button> -->
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Container-fluid Ends-->
            </form>
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