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
                      <h3>Modify Payment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="payment">Payments Lists</a></li>
                        <li class="breadcrumb-item">Modify Payment</li>
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
                            <input class="form-control" type="text" data-bs-original-title="" id="invoice_no" placeholder="Invoice No"  value="" readonly>
                            <div class="text-danger" id="error_invoice_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Receipt No</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="receipt_no" placeholder="Receipt No"  value="" readonly>
                            <div class="text-danger" id="error_receipt_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date</label>
                            <input class="form-control digits" type="date" id="payment_date"placeholder="Payment Date"  value="">
                            <div class="text-danger" id="error_payment_date"></div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative" id="payment_customer_list">
                            
                          </div>
                          <div class="col-lg-4 position-relative" id="payment_tcatgory_list">
                           
                          </div>                          
                          <div class="col-lg-4 position-relative" id="payment_treatment_list">
                           
                          </div>
                          
                        
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Total Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="total_amount" placeholder="Total Amount"  value="">
                            <div class="text-danger" id="error_total_amount"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Balance</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="balance" placeholder="Balance"  value="">
                            <div class="text-danger" id="error_balance_amount"></div>
                          </div>
                          
                        
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="amount" placeholder="Amount" onInput="pay_amount(event)"  value="">
                            <div class="text-danger" id="error_amount" ></div>
                          </div>

                          <div class="col-lg-4 mt-3">
                            <div class="row">
                              <div class="col-lg-6">
                                <label class="form-label">CGST (9%)</label>
                                <p  id="cgst"></p>
                              </div>
                              <div class="col-lg-6 ">
                                <label class="form-label">SGST (9%)</label>
                                <p  id="sgst"></p>
                              </div>

                            </div>
                          </div>

                          <div class="col-lg-4 position-relative mt-3">
                              <label class="form-label">Payment Status</label>
                              <input class="form-control" type="text" readonly data-bs-original-title=""  placeholder="Payment Status" value = "completed" >
                             
                              <input class="form-control" type="hidden" data-bs-original-title="" id="payment_status" placeholder="Payment Status" >
                              <div class="text-danger" id="error_payment_status"></div>
                          </div>
                        
                        </div>
                          
                        
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./payment'>Cancel</a></button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="upd_payment" onclick="update_payment()">Submit</button>
                          </div>
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