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
                      <h3>View Payment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="payment">Payments Lists</a></li>
                        <li class="breadcrumb-item">View Payment</li>
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
                     <div  id="status_success">
                     
                     </div> 
                      <div class="card-body">
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Invoice No</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="invoice_no" placeholder="Invoice No" readonly>
                            <div class="text-danger" id="error_invoice_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Receipt No</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="receipt_no" placeholder="Receipt No" readonly>
                            <div class="text-danger" id="error_receipt_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date</label>
                            <input class="form-control digits" type="date" id="payment_date" placeholder="Date Of Birth"  disabled>
                            <div class="text-danger" id="error_payment_date"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Treatment Categories</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="tcat_name" placeholder="Treatment Categories" readonly>
                            <div class="text-danger" id="error_tc_name"></div>
                          </div>                         
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Treatment Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="treatment_name_v" placeholder="Treatment Name" readonly>
                            <div class="text-danger" id="error_treatment_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Customer Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="first_name" placeholder="Customer Name" readonly>
                            <div class="text-danger" id="error_customer_name"></div>
                          </div>
                        <!-- </div>
                        <div class="row mb-3"> -->
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Count of Sitting</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="sitting_counts" placeholder="sitting_counts" readonly>
                            <div class="text-danger" id="error_sitting_counts"></div>
                          </div> -->
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="amount" placeholder="Amount"  readonly>
                            <div class="text-danger" id="error_amount"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Total Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="total_amount" placeholder="Total Amount"   readonly>
                            <div class="text-danger" id="error_total_amount"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Balance</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="balance" placeholder="Amount"  readonly>
                            <input class="form-control" type="hidden" data-bs-original-title="" id="payment_status" placeholder="Amount"  readonly>
                            <div class="text-danger" id="error_amount"></div>
                          </div>
                        </div>
                        <!-- <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Payment Status</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="payment_status" placeholder="Status"   readonly>
                            <div class="text-danger" id="error_payment_status"></div>
                          </div>
                        </div> -->
                      </div>
                      <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./payment'>Cancel</a></button>
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