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
                      <h3>View Appointment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="appointment">Appointment Lists</a></li>
                        <li class="breadcrumb-item">View Appointment</li>
                      </ol>
                    </div>
                  </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
          <!-- <form class="form wizard">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card">                   
                    <div class="card-body">
                      <div class="row mb-3 m-t-15 custom-radio-ml">
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" disable id="lead_appointment_id_view" type="radio" name="radio1" data-bs-original-title="" title="" onclick="appoint_lead_status_view();">
                          <label class="form-check-label" disable for="lead_appointment_id_view">Lead Appoinment</span></label>
                        </div>
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" id="customer_appointment_id_view" type="radio" name="radio1" data-bs-original-title="" title="" onclick="appoint_lead_status_view();">
                          <label class="form-check-label" for="customer_appointment_id_view">Customer Appoinment</span></label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Name</label>
                          <input class="form-control" type="text" data-bs-original-title="" placeholder="Name" required="" value="" readonly id="user_name">
                          <div class="valid-tooltip"></div>
                        </div>
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Problem</label>
                          <textarea class="form-control" type="text" data-bs-original-title="" placeholder="Problem" required="" rows="1" disabled id="problem"></textarea>
                          <div class="valid-tooltip"></div>
                        </div>
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Treatment Pitched</label>
                          <input class="form-control" type="text" data-bs-original-title="" placeholder="Treatment Pitched" required="" value="" readonly id="treatment_name">
                          <div class="valid-tooltip"></div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Attendted By</label>
                          <input class="form-control" type="text" data-bs-original-title="" placeholder="Attendted By" required="" value="" readonly id="staff_name">
                          <div class="valid-tooltip"></div>
                        </div> 
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Status</label>
                          <input class="form-control" type="text" data-bs-original-title="" placeholder="Status" required="" value="" readonly id="pn_status">
                          <div class="valid-tooltip"></div>
                        </div>
                        <div class="col-lg-4 position-relative" id="lead_status_tbox_view" style="display: none;">
                          <label class="form-label">Lead Status</label>
                          <input class="form-control" type="text" data-bs-original-title="" placeholder="Lead Status" required="" value="" readonly id="lead_status_name">
                          <div class="valid-tooltip"></div>
                        </div>
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Remarks</label>
                          <textarea class="form-control" placeholder="Remarks" required="" rows="1" disabled id="remark"></textarea>
                          <div class="valid-tooltip"></div>
                        </div>   
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </form> -->
        <form class="form wizard">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card"> 
                    <div  id="status_success">
                     
                    </div>                                    
                    <div class="card-body">
                      <!-- <div class="row mb-3 m-t-15 custom-radio-ml">
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" id="lead_appointment_id" type="radio" name="radio1" data-bs-original-title="" title="" checked  onclick="appoint_lead_status();">
                          <label class="form-check-label" for="lead_appointment_id">Lead Appoinment</span></label>
                        </div>
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" id="customer_appointment_id" type="radio" name="radio1" data-bs-original-title="" title=""  onclick="appoint_lead_status();">
                          <label class="form-check-label" for="customer_appointment_id">Customer Appoinment</span></label>
                        </div>
                      </div> -->
                      <div class="row mb-3">
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Name</label>
                            <select class="form-select" id="app_user_name" disabled>
                              
                            </select>
                          <div class="text-danger" id="error_app_user_name"></div>
                        </div>

                        <div class="col-lg-4 position-relative">
                          <div class="row">
                            <div class="col-lg-6">
                              <label class="form-label">Choose Date</label>
                              <input class="form-control digits" type="date" placeholder="Date" required="" value="" id="app_date" readonly/>
                              <div class="text-danger" id="error_app_date"></div>
                            </div>
                            <div  class="col-lg-6">
                              <label class="control-label" for="timepicker">Select Time</label>
	                            <input type="text" class="form-control" id="timepicker" value="" readonly>

                              <div class="text-danger" id="error_app_timepicker"></div>
                            </div>
                          </div>
                          
                          

                        </div>

                        <div class="col-lg-4 position-relative" id="lead_problem_box" >
                          <label class="form-label">Problem</label>
                          <textarea class="form-control" type="text" data-bs-original-title="" placeholder="Problem"  rows="1" id="app_problem"></textarea>
                          <div class="text-danger" id="error_app_problem"></div>
                        </div>

                        <div class="col-lg-4 position-relative " id="cus_tc_box"  style="display: none;" >
                          <label class="form-label">Treatment category</label>
                            <select class="form-select" id="app_cus_tc" disabled>
                              
                            </select>
                          <div class="text-danger" id="error_app_cus_tc"></div>
                        </div>
                        <div class="col-lg-4 position-relative mt-3" id="cus_treatment_box" style="display: none;" >
                          <label class="form-label">Treament Name</label>
                            <select class="form-select" id="app_cus_treatment" disabled >
                              
                            </select>
                          <div class="text-danger" id="error_app_cus_treatment"></div>
                        </div>
        
                        <!-- <div class="col-lg-4 position-relative mt-3" id="lead_status_tbox" style="display: none;">
                          <label class="form-label">Lead Status</label>
                            <select class="form-select" id="app_lead_status">
                              
                            </select>
                          <div class="text-danger" id="error_app_lead_status"></div>
                        </div> -->
                        
                        <div class="col-lg-4 position-relative  mt-3">
                          <label class="form-label">Attended By</label>
                          <input class="form-control" type="text" readonly id="app_staff_name"  data-bs-original-title="" title="" value="">
                          <div class="text-danger" id="error_app_staff_name"></div>
                        </div> 
                        <div class="col-lg-4 position-relative  mt-3">
                          <label class="form-label">Remarks</label>
                          <textarea class="form-control" placeholder="Remarks"  rows="1" id="app_remark" readonly></textarea>
                          <div class="text-danger" id="error_app_remark"></div>
                        </div>   
                      </div>
                      <div class="row mb-3">
                      <input class="form-control" type="hidden" readonly id="is_customer"  data-bs-original-title="" title="" value="">
                      <input class="form-control" type="hidden" readonly id="app_staff_name"  data-bs-original-title="" title="" value="">
                        <!-- <div class="card-footer text-end">
                          <button class="btn btn-secondary" type="reset" data-bs-original-title="" title=""><a href='./appointmrnt.php'><a href='./appointment'>Cancel</a></a></button>
                          <p class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_appointment();">Submit</p>
                        </div> -->
                        <div class="card-footer text-end">
                       
                          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./appointment'>Cancel</a></button>
                          <!-- <p class="btn btn-primary" data-bs-original-title="" title="" id="upd_app" onclick="update_appointment()">Submit</p> -->
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
    
     <script>
      function appoint_lead_status_view()
      {

        var lead_appointment_id_view = document.getElementById("lead_appointment_id_view");
        var lead_status_tbox_view = document.getElementById("lead_status_tbox_view");

        if (lead_appointment_id_view.checked) 
        {
          lead_status_tbox_view.style.display = "block";
        }
        else
        {
          lead_status_tbox_view.style.display = "none";
        }
      };
    
    </script>

    <script>
      document.getElementById("app_staff_name").value = sessionStorage.getItem('username');
      var is_customer = 1;
      function appoint_lead_status()
      {

        var lead_appointment_id = document.getElementById("lead_appointment_id_view");
        var lead_status_tbox = document.getElementById("lead_status_tbox");

        if (lead_appointment_id.checked) 
        {
          lead_status_tbox.style.display = "block";
          is_customer = 0;
        }
        else
        {
          lead_status_tbox.style.display = "none";
        }
      };
    
    </script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>