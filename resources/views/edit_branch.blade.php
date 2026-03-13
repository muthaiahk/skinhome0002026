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
                        <h3>Modify Branch</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Branch Lists</a></li>
                            <li class="breadcrumb-item active">Modify Branch</li>
                        </ol>
                    </div>

                    <form id="updateBranchForm">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Company Name</label>
                                    <select name="company_id" class="form-control">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                        <option value="{{ $company->company_id }}" @if($branch->company_id ==
                                            $company->company_id) selected @endif>
                                            {{ $company->company_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Name</label>
                                    <input type="text" name="branch_name" class="form-control"
                                        value="{{ $branch->branch_name }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Code</label>
                                    <input type="text" name="branch_code" class="form-control"
                                        value="{{ $branch->branch_code }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Opening Date</label>
                                    <input type="date" name="branch_opening_date" class="form-control"
                                        value="{{ $branch->branch_opening_date }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Authority</label>
                                    <select name="branch_authority" class="form-control">
                                        @foreach($staffs as $staff)
                                        <option value="{{ $staff->staff_id }}" @if($branch->branch_authority ==
                                            $staff->staff_id) selected @endif>{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Phone</label>
                                    <input type="text" name="branch_phone" class="form-control"
                                        value="{{ $branch->branch_phone }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Location</label>
                                    <input type="text" name="branch_location" class="form-control"
                                        value="{{ $branch->branch_location }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Branch Email</label>
                                    <input type="email" name="branch_email" class="form-control"
                                        value="{{ $branch->branch_email }}">
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <input type="checkbox" name="is_franchise" value="1" @if($branch->is_franchise)
                                    checked @endif> Is Franchise
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('branch.index') }}" class="btn btn-secondary">Cancel</a>
                                <button class="btn btn-primary" type="submit">Submit</button>
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
    <script>
    $(document).ready(function() {

        $('#updateBranchForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('branch.update', $branch->branch_id) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {

                    if (response.status == 1) {

                        toastr.success(response.message);

                        setTimeout(function() {
                            window.location.href = "{{ route('branch.index') }}";
                        }, 1500);

                    } else {

                        $.each(response.errors, function(key, value) {
                            toastr.error(value[0]);
                        });

                    }

                },
                error: function() {
                    toastr.error("Something went wrong!");
                }
            });

        });

    });
    </script>
    @include('script')
    @include('session_timeout')

    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>