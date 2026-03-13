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
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
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
                                <h3>Modify Attendance</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="attendance">Attendance</a></li>
                                    <!-- <li class="breadcrumb-item"><a href="/edit_atd">Modify Attendance</a></li> -->
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
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-3 position-relative">
                                                <label class="form-label">Branch Name</label>
                                                <select class="form-select" id="branch_name">

                                                </select>
                                                <div class="text-danger" id="error_branch_name"></div>
                                            </div>
                                            <div class="col-lg-3 position-relative" id="attendance_staff_list">
                                                <label class="form-label">Staff Name</label>
                                                <select class="form-select">
                                                    <option value="">Select Staff</option>
                                                    <option value="k">Kavya</option>
                                                    <option value="g">Guru</option>
                                                    <option value="j">Jacob</option>
                                                    <option value="h">Hema</option>
                                                    <option value="t">Thiru</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 position-relative">
                                                <label class="form-label">From Date</label>
                                                <input class="form-control" type="date" id="from_date"
                                                    placeholder="From Date" value="From Date">
                                                <div class="text-danger" id="error_from_date"></div>
                                            </div>

                                            <div class="col-lg-3 position-relative">
                                                <label class="form-label">To Date</label>
                                                <input class="form-control" type="date" id="to_date"
                                                    placeholder="To Date" value="To Date">
                                                <div class="text-danger" id="error_to_date"></div>
                                            </div>
                                            <div class="col-lg-3 position-relative mt-2">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" id='attendance_status'>
                                                    <option value="">Mark Attendance </option>
                                                    <option value="present">Present</option>
                                                    <option value="permission">Permission</option>
                                                    <option value="leave">Leave</option>
                                                    <option value="Weekoff">Weekoff</option>
                                                </select>
                                                <div class="text-danger" id="error_attendance"></div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"
                                                    title=""><a href='./attendance'>Cancel</a></button>
                                                <button class="btn btn-primary" type="button" data-bs-original-title=""
                                                    title="" id="update_att"
                                                    onclick="update_attendance()">Submit</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive product-table" id="modify_attendance_list">

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
