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
                                <h3>Stock Report</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">
                                            <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Stock Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="page-title">
                        <form method="GET" action="{{ route('report.stock') }}" class="row g-3 mb-3 align-items-end">

                            <div class="col-md-2">
                                <label for="branch_id" class="form-label">Branch</label>
                                <select name="branch_id" id="branch_id" class="form-select">
                                    <option value="">All Branch</option>
                                    @foreach ($Branches as $branch)
                                        <option value="{{ $branch->branch_id }}"
                                            {{ request('branch_id') == $branch->branch_id ? 'selected' : '' }}>
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="brand_id" class="form-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-select">
                                    <option value="">All Brand</option>
                                    @foreach ($Brands as $brand)
                                        <option value="{{ $brand->brand_id }}"
                                            {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="prod_category_id" class="form-label">Category</label>
                                <select name="prod_category_id" id="prod_category_id" class="form-select">
                                    <option value="">All Category</option>
                                    @foreach ($Categories as $cat)
                                        <option value="{{ $cat->prod_cat_id }}"
                                            {{ request('prod_category_id') == $cat->prod_cat_id ? 'selected' : '' }}>
                                            {{ $cat->prod_cat_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select name="product_id" id="product_id" class="form-select">
                                    <option value="">All Product</option>
                                    @foreach ($Products as $prod)
                                        <option value="{{ $prod->product_id }}"
                                            {{ request('product_id') == $prod->product_id ? 'selected' : '' }}>
                                            {{ $prod->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Go</button>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <a href="{{ route('report.stock.export', request()->all()) }}"
                                    class="btn btn-success w-100">Export</a>
                            </div>

                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="stockTable">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Branch</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Product</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->branch_name }}</td>
                                            <td>{{ $row->brand_name }}</td>
                                            <td>{{ $row->prod_cat_name }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td>{{ $row->stock_in_hand }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer start-->
        @include('footer')
        <!-- footer start-->
    </div>
    </div>

    @include('script')
    <!-- login js-->
    <!-- Plugin used-->
    @include('session_timeout')

    <script>
        $(document).ready(function() {
            $('#stockTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'csv', 'print']
            });
        });
    </script>

</body>

</html>
