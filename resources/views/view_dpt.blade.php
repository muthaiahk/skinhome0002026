@include('common')

<body>
    @include('header')
    @include('sidebar')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>View Department</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('department') }}">Department Lists</a></li>
                            <li class="breadcrumb-item">View Department</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <label>Company Name</label>
                                        <input class="form-control" value="{{ $department->company_name }}" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Branch Name</label>
                                        <input class="form-control" value="{{ $department->branch_name }}" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Department Name</label>
                                        <input class="form-control" value="{{ $department->department_name }}" readonly>
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <a href="{{ url('department') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('footer')
    @include('script')
</body>

</html>