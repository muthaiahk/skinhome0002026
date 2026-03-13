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
                      <h3>Add Payment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="payment">Payments Lists</a></li>
                        <li class="breadcrumb-item">Add Payment</li>
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
                        <!-- <div class="row mb-3">
                          <div class="col-lg-4 position-relative" id="payment_customer_list" >
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Invoice No</label>
                            <input class="form-control invoice_no_py" type="text" data-bs-original-title="" id="invoice_no" placeholder="Invoice No"  value="" readonly>
                            <div class="text-danger" id="error_invoice_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Receipt No</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="receipt_no" placeholder="Receipt No"  value="" readonly>
                            <div class="text-danger" id="error_receipt_no"></div>
                          </div>
                          
                        </div>
                        <div class="row mb-3"> 
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date</label>
                            <input class="form-control digits" type="date" id="payment_date" placeholder="Payment Date" >
                            <div class="text-danger" id="error_payment_date"></div>
                          </div>                         
                          <div class="col-lg-4 position-relative" id="payment_tc_list">
                            
                          </div>
                           <div class="col-lg-4 position-relative" id="payment_treatment_list">
                              
                          </div>  
                                                                        
                          
                        </div>
                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Count of Sitting</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="sitting_counts" placeholder="Count of Sitting" >
                            <div class="text-danger" id="error_sitting_counts"></div>
                          </div>
                          
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Total Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="total_amount" placeholder="Total Amount" >
                        
                          </div>
                          
                          <div class="col-lg-4 position-relative ">
                            <label class="form-label">Balance Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="balance_amount" placeholder="Balance Amount" >
                        
                          </div>
                          
                        </div> -->
                        <!-- <div class="row mb-3">
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="amount" placeholder="Amount" onInput="pay_amount(event);">
                            <div class="text-danger" id="error_pay_amount"></div>
                          </div>
                          <div class="col-lg-4 ">
                            <div class="row">
                            <div class="col-lg-6">
                              <label class="form-label">CGST (9%)</label>
                              <p class="text-center" id="cgst"></p>
                            </div>
                            <div class="col-lg-6 ">
                              <label class="form-label">SGST (9%)</label>
                              <p class="text-center"  id="sgst"></p>
                            </div>

                            </div>
                            
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                           
                              <p>Pay Now! Options</p>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cash</label>
                                      <input type="text" class="form-control w-50"  id="cash" value=0  oninput="multi_payment(event)" >
                                     
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">Card</label>
                                      <input type="text" class="form-control w-50"  id="card" value=0    oninput="multi_payment(event)">
                                    
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cheque</label>
                                      <input type="text" class="form-control w-50"  id="cheque" value=0  oninput="multi_payment(event)"  >
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">UPI</label>
                                      <input type="text" class="form-control w-50"id="upi" value=0   oninput="multi_payment(event)">
                                  </div>
                              </div>
                          </div>
                        </div> -->

                        <div class="row mb-3">
                          <div class="col-lg-4 position-relative" id="payment_customer_list" >
                            
                          </div>
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Invoice No</label>
                            <input class="form-control invoice_no_py" type="text" data-bs-original-title="" id="invoice_no" placeholder="Invoice No"  value="" readonly>
                            <div class="text-danger" id="error_invoice_no"></div>
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Receipt No</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="receipt_no" placeholder="Receipt No"  value="" readonly>
                            <div class="text-danger" id="error_receipt_no"></div>
                          </div> -->
                          
                       
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Date</label>
                            <input class="form-control digits futuredate_disable " value="{{ date('Y-m-d') }}" onfocusout="check_date(event)" type="date" id="payment_date" placeholder="Payment Date" >
                            <div class="text-danger" id="error_payment_date"></div>
                          </div>                         
                          <!-- <div class="col-lg-4 position-relative" id="payment_tc_list">
                            
                          </div>
                           <div class="col-lg-4 position-relative" id="payment_treatment_list">
                              
                          </div>   -->
                                                                        
                          
                        </div>
                        <div class="row mb-3">
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Count of Sitting</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="sitting_counts" placeholder="Count of Sitting" >
                            <div class="text-danger" id="error_sitting_counts"></div>
                          </div>
                          
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Total Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="total_amount" placeholder="Total Amount" >
                        
                          </div>
                          
                          <div class="col-lg-4 position-relative ">
                            <label class="form-label">Balance Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" readonly id="balance_amount" placeholder="Balance Amount" >
                        
                          </div> -->
                          
                        </div> 
                        <div class="row mb-3">
                          <div class="col-lg-2 position-relative">
                            <label class="form-label"><b>Treatment Name </b></label>
                          </div>
                          <div class="col-lg-3 position-relative">
                            <label class="form-label"> </label>
                          </div>
                          <div class="col-lg-2 position-relative">
                            <label class="form-label"><b>Amount</b></label>
                          </div>
                          <div class="col-lg-3 position-relative">
                            <label class="form-label"><b>Discount</b></label>
                          </div>
                          <div class="col-lg-2 position-relative">
                            <label class="form-label"><b>To Pay</b></label>
                          </div>

                          <div class="row" id="treatment_details">
                              
                          </div>

                          <div class="row">

                            <div class="col-lg-4 position-relative">
                              <label class="form-label"> </label>
                            </div>
                            <div class="col-lg-2 position-relative">
                              <label class="form-label"></label>
                            </div>
                          
                            <div class="col-lg-4 position-relative">
                            
                            
                                <input class="form-control-plaintext" style="text-align:right;width: 100% !important;" type="text" data-bs-original-title="" value ="Taxable Value" readonly id="taxtable" placeholder="" >
                                <input class="form-control-plaintext" style="text-align:right;width: 100% !important;"  type="text" data-bs-original-title="" value ="CGST" readonly id="cgst" placeholder="" >
                                <input class="form-control-plaintext" style="text-align:right;width: 100% !important;"  type="text" data-bs-original-title="" value= "SGST" readonly id="sgst" placeholder="" >
                                <input class="form-control-plaintext" style="text-align:right;width: 100% !important;"  type="text" data-bs-original-title="" value= "IGST" readonly id="igst" placeholder="" >
                                <input class="form-control-plaintext" style="text-align:right;width: 100% !important;"  type="text" data-bs-original-title="" value="Total Pay"  readonly id="total_amount" placeholder="" >
                              
                              
                            </div>
                            <div class="col-lg-2 position-relative">
                              <input class="form-control-plaintext" type="text" data-bs-original-title="" readonly id="taxtable_value" placeholder="" >
                              <input class="form-control-plaintext" type="text" data-bs-original-title="" readonly id="cgst_value" placeholder="" >
                              <input class="form-control-plaintext" type="text" data-bs-original-title="" readonly id="sgst_value" placeholder="" >
                              <input class="form-control-plaintext" type="text" data-bs-original-title="" readonly id="igst_value" placeholder="" >
                              <input class="form-control-plaintext" type="text" data-bs-original-title="" readonly id="total_amount_value" placeholder="" >
                            </div>
                          </div>


                          <div calss="row">
                            <p>Payment details Entery! </p>
                            <div class="col-3">
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cash</label>
                                      <input type="text" class="form-control w-50"  id="cash" value=0  oninput="multi_payment(event)" >
                                     
                                  </div>
                              </div>
                            </div>
                            <div class="col-3">
                            <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">Card</label>
                                      <input type="text" class="form-control w-50"  id="card" value=0    oninput="multi_payment(event)">
                                    
                                  </div>
                              </div>
                            </div>
                            <div class="col-3">
                            <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Loan</label>
                                      <input type="text" class="form-control w-50"  id="cheque" value=0  oninput="multi_payment(event)"  >
                                  </div>
                              </div>
                            </div>
                            <div class="col-3">
                            <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">UPI</label>
                                      <input type="text" class="form-control w-50"id="upi" value=0   oninput="multi_payment(event)">
                                  </div>
                              </div>
                            </div>
                          </div>

                          <!-- <div class="col-lg-4 position-relative">
                           
                              
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cash</label>
                                      <input type="text" class="form-control w-50"  id="cash" value=0  oninput="multi_payment(event)" >
                                     
                                  </div>
                              </div>
                              
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cheque</label>
                                      <input type="text" class="form-control w-50"  id="cheque" value=0  oninput="multi_payment(event)"  >
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">UPI</label>
                                      <input type="text" class="form-control w-50"id="upi" value=0   oninput="multi_payment(event)">
                                  </div>
                              </div>
                          </div> -->


                          
                          <!-- <div class="col-lg-4 position-relative">
                            <label class="form-label">Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" id="amount" placeholder="Amount" onInput="pay_amount(event);">
                            <div class="text-danger" id="error_pay_amount"></div>
                          </div>
                          <div class="col-lg-4 ">
                            <div class="row">
                            <div class="col-lg-6">
                              <label class="form-label">CGST (9%)</label>
                              <p class="text-center" id="cgst"></p>
                            </div>
                            <div class="col-lg-6 ">
                              <label class="form-label">SGST (9%)</label>
                              <p class="text-center"  id="sgst"></p>
                            </div>

                            </div>
                            
                            
                          </div>
                          <div class="col-lg-4 position-relative">
                           
                              <p>Pay Now! Options</p>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cash</label>
                                      <input type="text" class="form-control w-50"  id="cash" value=0  oninput="multi_payment(event)" >
                                     
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">Card</label>
                                      <input type="text" class="form-control w-50"  id="card" value=0    oninput="multi_payment(event)">
                                    
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                      <label class="col-sm-3 col-form-label" for="name">Cheque</label>
                                      <input type="text" class="form-control w-50"  id="cheque" value=0  oninput="multi_payment(event)"  >
                                  </div>
                              </div>
                              <div class="form-inline mb-1">
                                  <div class="col-md-12 form-group">
                                     
                                      <label class="col-sm-3 col-form-label" for="name">UPI</label>
                                      <input type="text" class="form-control w-50"id="upi" value=0   oninput="multi_payment(event)">
                                  </div>
                              </div>
                          </div> -->
                          
                        </div> 
                       
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                          <input type="hidden" id="cus_treat_id" value=''>
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./payment'>Cancel</a></button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title=""  id="add_pay" onclick="add_payment()">Submit</button>
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
<!-- $payment->invoice = 'IN/' -->