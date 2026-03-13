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
                      <h3>Add Product</h3>
                    </div>
                    <div class="col-6">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard">
                          <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"><a href="product">Product Lists</a></li>
                        <li class="breadcrumb-item">Add Product</li>
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
                    <!-- <div class="card-header">
                      <h5>Lead Lists</h5>
                    </div> -->
                    <div  id="status_success">
                     
                    </div>
                    <div class="card-body">
                      <div class="row mb-3">                         
                        <div class="col-lg-4 position-relative" id="product_brand_list">
                            
                        </div>
                          <div class="col-lg-4 position-relative" id="prod_cat_list">
                           
                          </div>
                          <div class="col-lg-4 position-relative">
                            <label class="form-label">Product Name</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Product Name" id='product_name'>
                            <div class="text-danger" id="error_product_name"></div>
                          </div>
                          <div class="col-lg-4 position-relative mt-2">
                            <label class="form-label">Inc.GST Amount</label>
                            <input class="form-control" type="text" data-bs-original-title="" placeholder="Amount" id='amount' >
                            <div class="text-danger" id="error_amount"></div>
                          </div>
                          <div class="col-lg-4 position-relative mt-2">
                            
                                <label class="form-label"> GST %</label>
                                <select class="form-select" id="gst">
                                  <option value="0">Select</option>
                                  <option value="5">5</option>
                                  <option value="12">12</option>
                                  <option value="18">18</option>
                                  <option value="28">28</option>
                                </select>
            
                                <div class="text-danger" id="error_gst"></div>
                            
                          </div>
                          <div class="col-lg-4">
                              <label class="text-dark mb-1 fs-6 fw-semibold">Product Image</label>
                              <div class="align-items-sm-center gap-4">
                                  <!-- Image preview area with controlled size -->
                                  <img src="{{ asset('assets/images/avtar/3.jpg') }}" alt="product-image"
                                      class="image-preview" id="grade_logo_view" />

                                  <div class="button-wrapper">
                                      <!-- Upload button -->
                                      <div class="d-flex align-items-start mt-2 mb-2">
                                          <label for="product_image" class="btn btn-sm btn-primary me-2" tabindex="0"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Logo">
                                              Add
                                              <input type="file" id="product_image" name="product_image" class="file-in"
                                                    hidden accept="image/png, image/jpeg" onchange="previewImage(event)" />
                                          </label>

                                          <!-- Reset button -->
                                          <button type="button" class="btn btn-sm btn-outline-danger file-reset"
                                                  data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Logo"
                                                  onclick="resetImage()">
                                              Reset
                                          </button>
                                      </div>

                                      <!-- File upload instructions -->
                                      <div class="small">Allowed JPG, PNG. Max size of 800Kb</div>
                                      <div class="text-danger" id="grade_logo_err"></div>
                                  </div>
                              </div>
                          </div>
                        <div class="row mb-3">
                          <div class="card-footer text-end">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" title=""><a href='./product'>Cancel</a></button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title="" id="add_prod" onclick="add_product()">Submit</button>
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
    
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>


<!-- JavaScript for image preview and reset functionality -->
<!-- <script>
   let logofile = document.getElementById('grade_logo_view');
        const fileInput = document.querySelector('.file-in'),
            resetFileInput = document.querySelector('.file-reset');

        if (logofile) {
            const resetImage = logofile.src;
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    logofile.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                logofile.src = resetImage;
            };
        }
    // Preview the uploaded image
   
</script> -->


<!-- JavaScript for image preview and reset functionality -->
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const maxFileSize = 800 * 1024; // 800 KB

        if (file) {
            if (file.size > maxFileSize) {
                document.getElementById('grade_logo_err').textContent = "File size exceeds 800KB!";
                event.target.value = ""; // Clear file input
                return;
            }
            document.getElementById('grade_logo_err').textContent = ""; // Clear error
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('grade_logo_view').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function resetImage() {
        document.getElementById('product_image').value = ""; // Clear file input
        document.getElementById('grade_logo_view').src = "assets/images/avtar/3.jpg"; // Reset to default image
        document.getElementById('grade_logo_err').textContent = ""; // Clear error
    }
</script>

<!-- CSS for image size control -->
<style>
    .image-preview {
        width: 120px;
        height: 120px;
        object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
        border: 1px solid #6c757d;
        border-radius: 5px;
    }
</style>

