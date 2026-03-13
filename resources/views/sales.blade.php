@include('common')
<body onload="startTime()">
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
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
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
                <h3>Sales Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">                                       
                    <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Sales Lists</li>
                    <!-- <li class="breadcrumb-item active">Default</li> -->
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
                  <div class="row card-header mt-4 mx-3" >     
                    <div class="col-lg-3 position-relative" id="branch_list">
                        <select class='form-select' id='branch_id'>
                          <option value='0'>Select Branch</option></select>
                          <div class="text-danger" id="error_branch_id"></div>
                    </div>
                    <div class="col-lg-3">
                      <input class="form-control" type="date" id="from_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-lg-3">
                      <input class="form-control" type="date" id="to_date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-lg-1">
                      <p class="btn btn-primary" id="data_filter">Go</p>
                    </div>
                    <div class="col-md-2">
                      <div class=" text-end float-right">
                      <a href="add_sales" type="button" class="btn btn-primary" id='add_sales' type="submit" data-bs-original-title="" >Sale</a>
                      </div>
                    </div>
                  </div>
                  <div  id="status_success">
                    
                  </div>
                  <!-- <div class="card-header text-end" style="display:block;">
                    <a href="add_sales" type="button" class="btn btn-primary" type="submit" data-bs-original-title="" >sale</a>
                  </div> -->
                  
                  <div class="card-body">
                    <div class="table-responsive product-table" id="sales_list">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
          <!-- Container-fluid Ends-->
        </div>
      </div>
        <!-- footer start-->
        @include('footer')
        <!-- footer start-->
      </div>
    </div>
    <div class="modal fade" id="sales_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <h5 style="text-align: center;">Delete ?</h5><br>
            <div class="mb-3">
              <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this Data.</p>
            </div>
          </div>
          <div class="card-footer text-center mb-3">
            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="delete">Yes, delete</span></button>
          </div>
        </div>
      </div>
    </div>
    @include('script')
    @include('session_timeout')
    
    <!-- login js-->
    <!-- Plugin used-->
    
   
  </body>
  </html>