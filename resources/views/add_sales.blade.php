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
                      <h3>Sales</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="product">Sales Lists</a></li>
                        <li class="breadcrumb-item">Add sale</li>
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
                    <div  id="status_success">
                     
                    </div>
                    <div class="card-body">
                      <div class="row mb-3"> 

                          <div class="col-lg-4 position-relative" id="branch_list">
                              <label class='form-label'>Branch</label>
                              <select class='form-select' id='branch_id'>
                                <option value='0'>Select Branch</option></select>
                                <div class="text-danger" id="error_branch_id"></div>
                          </div>

                          <div class="col-lg-4 position-relative" id="customer_list">
                            <label class='form-label'>Customers</label>
                            <select class='form-select' id='customer_name'>
                              <option value='0'>Select Customer</option></select>
                              <div class="text-danger" id="error_customer_name"></div>
                          </div>                       
                          <div class="col-lg-4 position-relative" id="product_brand_list">
                          
                          </div>
                          <div class="col-lg-4 position-relative mt-4" id="prod_cat_list">
                          <label class='form-label'>Categories</label>
                          <select class='form-select' id='prod_cat_name'>
                            <option value='0'>Select Categories</option></select>
                            <div class="text-danger" id="error_prod_cat_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative mt-4" id="product_list">
                          <label class='form-label'>Product</label>
                          <select class='form-select' id='product_name'>
                            <option value='0'>Select Product</option></select>
                            <div class="text-danger" id="error_product_name"></div>
                          </div>
                          <div class="col-lg-4 mt-4 position-relative">
                            <label class="form-label">Quantity</label>
                            <input class="form-control" type="number" data-bs-original-title="" oninput="add_aquantity(event)" placeholder="Amount" id='quantity' value='1'>
                            <div class="text-danger" id="error_quantity"></div>
                          </div>

                          <div class="col-lg-4 mt-4 position-relative">
                            <label class="form-label">Amount</label>
                            <input class="form-control" type="text" readonly data-bs-original-title="" placeholder="Amount" id='amount'>
                            <div class="text-danger" id="error_amount"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./sales'>Cancel</a></button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="add_sal" onclick="add_sale()">Submit</button>
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