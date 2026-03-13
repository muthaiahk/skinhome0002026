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
                      <h3>Notification Lists</h3>
                    </div>
                    
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Notification Lists</li>
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
                    <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                    
                    <div  id="status_success">
                     
                    </div> 
                    <div class="card-body">
                      <!-- <div class="row card-header ">
                        <div class="col-md-3">
                            <div  id="dashboard_branch_list">
                              <select class="form-select"  id="branch_name" multiple onchange="selectbranch();">
                                
                              </select>
                              <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-9">
                          <div class=" text-end">
                            <a href="/add_lead" type="button" class="btn btn-primary" type="submit" data-bs-original-title=""  id="add_lead">Add Lead</a>
                          </div>
                        </div>
                      
                      </div> -->
                      
                      <div class="card-body table-responsive" id="notification_list">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
      $("#lead_lists").kendoTooltip({
        filter: "td",
        show: function(e){
          if(this.content.text() !=""){
            $('[role="tooltip"]').css("visibility", "visible");
          }
        },
        hide: function(){
          $('[role="tooltip"]').css("visibility", "hidden");
        },
        content: function(e){
          var element = e.target[0];
          if(element.offsetWidth < element.scrollWidth){
            return e.target.text();
          }else{
            return "";
          }
        }
      })
    </script>
    
    <!-- <script>
          (function($) 
          {
              $('#basic-3').DataTable();
          })(jQuery);
    </script> -->
    <!-- login js-->
    <!-- Plugin used-->
    
  </body>
</html>