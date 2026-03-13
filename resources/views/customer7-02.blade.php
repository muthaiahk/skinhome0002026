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
                <h3>Customer Lists</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard">
                      <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Customer Lists</li>
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
                <div id="status_success">

                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div id="dashboard_branch_list">
                        <!-- <label class="form-label">Branch</label> -->
                        <select class="form-select" id="branch_name" multiple onchange="selectbranch();">

                        </select>
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>

                    <!-- <div class="card-header text-end">
                          <a href="/add_lead" type="button" class="btn btn-primary" type="submit" data-bs-original-title="">Add Lead</a>
                        </div> -->
                  </div>
                  <div id="loadingIndicator" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading data, please wait...</p>
                  </div>
                  <div class="card-body table-responsive" id="customer_list">

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
  <div class="modal fade" id="customer_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <button class="btn btn-primary" id="delete" data-bs-dismiss="modal">Yes, delete</button>
        </div>
      </div>
    </div>
  </div>
  @include('script')
  @include('session_timeout')
  <script>
    $("#customer_lists").kendoTooltip({
      filter: "td",
      show: function(e) {
        if (this.content.text() != "") {
          $('[role="tooltip"]').css("visibility", "visible");
        }
      },
      hide: function() {
        $('[role="tooltip"]').css("visibility", "hidden");
      },
      content: function(e) {
        var element = e.target[0];
        if (element.offsetWidth < element.scrollWidth) {
          return e.target.text();
        } else {
          return "";
        }
      }
    })
  </script>

  
</body>

</html>