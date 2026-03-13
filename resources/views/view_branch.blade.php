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
                        <h3>View Branch</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Branch Lists</a></li>
                            <li class="breadcrumb-item active">View Branch</li>
                        </ol>
                    </div>

                    <form class="form wizard">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control"
                                        value="{{ $branch->company->company_name ?? '' }}" readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" value="{{ $branch->branch_name }}" readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Opening Date</label>
                                    <input type="date" class="form-control" value="{{ $branch->branch_opening_date }}"
                                        readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Authority</label>
                                    <input type="text" class="form-control" value="{{ $branch->authority->name ?? '' }}"
                                        readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Phone</label>
                                    <input type="text" class="form-control" value="{{ $branch->branch_phone }}"
                                        readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Location</label>
                                    <input type="text" class="form-control" value="{{ $branch->branch_location }}"
                                        readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Email</label>
                                    <input type="email" class="form-control" value="{{ $branch->branch_email }}"
                                        readonly>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="checkbox" @if($branch->is_franchise) checked @endif disabled> Is
                                    Franchise
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('branch.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
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