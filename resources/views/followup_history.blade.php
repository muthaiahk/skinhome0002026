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
                      <h3>FollowUp History Lists</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">FollowUp History Lists</li>
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
                    <div class="card-body">
                      <div class="row">
                        <div class="card-header text-end">
                          <a href="add_followup_history" type="button" class="btn btn-primary" type="submit" data-bs-original-title="">Add FollowUp</a>
                        </div>
                          <!-- <div class="col-md-4 position-relative">
                            <label class="form-label" for="validationTooltip01">First name</label>
                            <input class="form-control" id="validationTooltip01" type="text" required="" data-bs-original-title="" title="">
                          <div class="valid-tooltip">Looks good!</div>
                        </div> -->
                      </div>
                      <div class="card-body table-responsive">
                        <table class="display" id="followup_history_lists">
                          <thead>
                            <tr>
                              <th class="min-w-100px">Name</th>
                              <th class="min-w-100px">Mobile</th>
                              <th class="min-w-100px">FlwUp Date</th>
                              <th class="min-w-100px">FlwUp Count</th>
                              <th class="min-w-125px">Next FlwUp Date</th>
                              <th class="min-w-100px">Status</th>
                              <th class="min-w-100px">Remarks</th>
                              <th class="min-w-125px">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Srinivasan K</td>
                              <td>9598959695</td>
                              <td>02/10/2022</td>
                              <td>1</td>
                              <td>03/10/2022</td>
                              <td>Possitive</td>
                              <td>Good</td>
                              <td>
                                <a href="view_followup_history"><i class="fa fa-eye eyc"></i></a>
                                <a href="edit_followup_history"><i class="fa fa-edit eyc"></i></a>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#followup_history_delete"><i class="fa fa-trash eyc"></i></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
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
    <div class="modal fade" id="followup_history_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <br>
            <h5 style="text-align: center;">Delete ?</h5><br>
            <div class="mb-3">
              <p class="col-form-label" style="text-align: center !important;">Are you sure you want to delete this FollowUp.</p>
            </div>
          </div>
          <div class="card-footer text-center mb-3">
            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Yes, delete</button>
            <button class="btn btn-light" type="button" data-bs-dismiss="modal">No, Cancel</button>
          </div>
        </div>
      </div>
    </div>
    @include('script')
    @include('session_timeout')
    <script>
      $("#followup_history_lists").kendoTooltip({
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
    <script>

      $("#followup_history_lists").DataTable({
          // "ordering": false,
          "responsive": true,
          "aaSorting":[],
           "language": {
            "lengthMenu": "Show _MENU_",
           },
           "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
          });
    </script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>