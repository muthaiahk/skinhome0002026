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
                      <h3>Invoice Generate</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Invoice generate</li>                
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
        <form class="form wizard">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div  id="status_success">
                     
                  </div>    
                  <!-- <div class="card-header" id="add_treatment">
                    <div class=" text-end float-right">
                      <a href="/add_t_management"><button class="btn btn-primary " type="button">Add Treament</button></a>                
                    </div>
                  </div>   -->
                    <div class="card-body">  
                      
                      <div class="row">
                        <div class="col-lg-3 position-relative" >
                          <label class="form-label">Branch</label>
                              <select class='form-select' id='branch_name'>
                              <option value='0'>Select Branch</option></select>
                            <div class="text-danger" id="error_branch_id"></div>
                        </div>
                        <div class="col-lg-4 position-relative">
                            <label class="form-label">Customer Name</label>
                            <select class="form-select"  id="customer_name">
                                                          
                            </select>
                            <div class="text-danger" id="error_customer_name"></div>
                        </div> 
                        
                      </div>
                      <div class="table-responsive product-table mt-3" >
                        <div class="container">
                          <div class="row">
                            <div class="col-12">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Treament  Name</th>
                                    <th scope="col">Amount</th>                                 
                                  </tr>
                                </thead>
                                <tbody id="treatment_management_list">
                                  <tr>
                                  
                                   
                                  </tr>
                                  
                                </tbody>
                                
                                
                              </table>
                              
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row px-1 mt-3">
                        <h6>Invoice List</h6>
                        <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Treament  Name</th>
                                    <th scope="col">Action</th>                                 
                                  </tr>
                                </thead>
                                <tbody id="invoice_treatment_list">
                                  <tr>
                                      <td colspan="3" class=" text-center text-danger">Data Not Found</td>
                                  </tr>
                                  
                                </tbody>
                                
                                
                              </table>
                      </div>

                    </div>

                    
                 </div>
              </div>
            </form>
          </div>
          
          <!-- Container-fluid Ends-->
        </div>
      </div>
        <!-- footer start-->
        @include('footer')
        <!-- footer start-->
      </div>
    </div>
    @include('script')
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    
    <!-- login js-->
    <!-- Plugin used-->
       
  </body>
</html>