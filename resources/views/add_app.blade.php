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
                      <h3>Add Appointment</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="appointment">Appointment Lists</a></li>
                        <li class="breadcrumb-item">Add Appointment</li>
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
                      <div class="row mb-3 m-t-15 custom-radio-ml">
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" id="lead_appointment_id" type="radio" name="radio1" data-bs-original-title="" title=""   onclick="appoint_lead_status();">
                          <label class="form-check-label" for="lead_appointment_id">Lead Appoinment</span></label>
                        </div>
                        <div class="col-lg-3 form-check radio radio-primary">
                          <input class="form-check-input" id="customer_appointment_id" type="radio" name="radio1" data-bs-original-title="" title=""  checked onclick="appoint_lead_status();">
                          <label class="form-check-label" for="customer_appointment_id">Customer Appoinment</span></label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Branch</label>
                            <select class="form-select selectpicker" id="branch_name">
                              
                            </select>
                          <div class="text-danger" id="error_app_branch_name"></div>
                          
                        </div>
                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Name</label>
                            <select class="form-select selectpicker" id="app_user_name">
                              
                            </select>
                          <div class="text-danger" id="error_app_user_name"></div>
                          
                        </div>

                        <div class="col-lg-4 position-relative">
                          <label class="form-label">Mobile Number</label>
                          <input class="form-control" type="text"  id="mobile" onkeypress="mobile_search(event)" placeholder="Enter mobile number"  data-bs-original-title="" title="" value="" > 
                          <div class="text-danger" id="error_mobile"></div>
                          
                        </div>

                        <div class="col-lg-4 position-relative mt-3">
                          <div class="row">
                          <div class="col-lg-6">
                              <label class="form-label">Choose Date</label>
                              <input class="form-control digits" type="date" placeholder="Date" required="" value="{{ date('Y-m-d') }}" id="app_date" min="{{ date('Y-m-d') }}" />
                              <div class="text-danger" id="error_app_date"></div>
                          </div>
                            <div  class="col-lg-6">
                              <label class="control-label" for="timepicker">Select Time</label>
	                            <input type="text" class="form-control" id="timepicker">

                              <div class="text-danger" id="error_app_timepicker"></div>
                            </div>
                          </div>
                          
                          

                        </div>

                        <div class="col-lg-4 position-relative mt-3" id="lead_problem_box" style="display: none;">
                          <label class="form-label">Problem</label>
                          <textarea class="form-control" type="text" data-bs-original-title="" placeholder="Problem"  rows="1" id="app_problem"></textarea>
                          <div class="text-danger" id="error_app_problem"></div>
                        </div>

                        <!-- <div class="col-lg-4 position-relative " id="cus_tc_box"  style="display: none;" >
                          <label class="form-label">Treatment category</label>
                            <select class="form-select" id="app_cus_tc">
                              
                            </select>
                          <div class="text-danger" id="error_app_cus_tc"></div>
                        </div> -->
                        <div class="col-lg-4 position-relative mt-3" id="cus_treatment_box" style="display: block;" >
                          <label class="form-label">Treament Name</label>
                            <select class="form-select" id="app_cus_treatment">
                              
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
                          <textarea class="form-control" placeholder="Remarks"  rows="1" id="app_remark"></textarea>
                          <div class="text-danger" id="error_app_remark"></div>
                        </div>   
                      </div>
                      <div class="row mb-3">
                        <!-- <div class="card-footer text-end">
                          <button class="btn btn-secondary" type="reset" data-bs-original-title="" title=""><a href='./appointmrnt.php'><a href='./appointment'>Cancel</a></a></button>
                          <p class="btn btn-primary"  data-bs-original-title="" title="" onclick="add_appointment();">Submit</p>
                        </div> -->
                        <div class="card-footer text-end">
                       
                          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./appointment'>Cancel</a></button>
                          <p class="btn btn-primary" data-bs-original-title="" title="" id="add_app" onclick="add_appointment()">Submit</p>
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

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>

      $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd" 
      });

      $("#timepicker").timepicker({
        timeFormat: "h:mm p", 
        interval: 30,
        minTime: "06", 
        maxTime: "23:55pm", 
        defaultTime: "06", 
        startTime: "01:00", 
        dynamic: true,
        dropdown: true, 
        scrollbar: false 
      });
 
 
    </script>
    <script>
      document.getElementById("app_staff_name").value = sessionStorage.getItem('username');
      var is_customer = 1;
      

      function appoint_lead_status()
      {

        var lead_appointment_id = document.getElementById("lead_appointment_id");
        var lead_problem_box = document.getElementById("lead_problem_box");
       // var cus_tc_box = document.getElementById("cus_tc_box");
        var cus_treatment_box = document.getElementById("cus_treatment_box");

        if (lead_appointment_id.checked) 
        {
      
          lead_problem_box.style.display = "block";
          //cus_tc_box.style.display = "none";
          cus_treatment_box.style.display = "none";
          is_customer = 1;
          var b_id = $('#branch_name').val();
          getuserall(b_id,1);

        }
        else
        {

          //cus_tc_box.style.display = "block";
          cus_treatment_box.style.display = "block";
          lead_problem_box.style.display = "none";
          is_customer = 0;
          var b_id = $('#branch_name').val();
          getuserall(b_id);
          
        }


      };


      
    
    </script>

    

    

    

    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>