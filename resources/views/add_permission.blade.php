@include('common')

<body>
    <!-- Loader starts -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- Loader ends -->

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')
        <div class="page-body-wrapper">
            @include('sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Add Role</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('role_permission') }}">Role Lists</a>
                                    </li>
                                    <li class="breadcrumb-item">Add Role</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form starts -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="rolePermissionForm">
                                        @csrf
                                        <input type="hidden" name="role_id" value="{{ $roleId }}">

                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label class="form-label">Role Name</label>
                                                <input type="text" class="form-control" name="role_name"
                                                    value="{{ $roleName }}" readonly>
                                            </div>
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Select All</label>
                                                <input type="checkbox" id="select_all"
                                                    class="checkbox_animated setting_checkbox">
                                            </div>
                                        </div>

                                        @php
                                        $pages =
                                        ['dashboard','lead','followup','customer','customer_treatment','appointment','customer_payment','consultation','sales','invoice','inventory','staff','attendance','report','setting'];
                                        $actions = ['list','add','edit','view','delete'];
                                        @endphp

                                        <div class="default-according style-1" id="accordion">
                                            @foreach($pages as $index => $page)
                                            @php
                                            $permission = $rolePermissions->firstWhere('page', $page);
                                            $permissionArray = $permission ? explode(',', $permission->permission) : [];
                                            @endphp
                                            <input type="hidden" name="page[]" value="{{ $page }}">
                                            <div class="card">
                                                <div class="card-header" id="heading{{ $index }}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                                            aria-controls="collapse{{ $index }}">
                                                            <h6 class="form-label">
                                                                {{ ucfirst(str_replace('_',' ', $page)) }}</h6>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapse{{ $index }}"
                                                    aria-labelledby="heading{{ $index }}" data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            @foreach($actions as $action)
                                                            <div class="col-lg-3">
                                                                <label class="d-block">
                                                                    <input type="checkbox"
                                                                        class="checkbox_animated {{ $page }}_checkbox"
                                                                        name="{{ $page }}_permission[]"
                                                                        value="{{ $action }}"
                                                                        {{ in_array($action, $permissionArray) ? 'checked' : '' }}>
                                                                    {{ ucfirst($action) }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="window.history.back();">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Toast -->
                                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                                        <div id="permissionToast"
                                            class="toast align-items-center text-bg-success border-0" role="alert"
                                            aria-live="assertive" aria-atomic="true">
                                            <div class="d-flex">
                                                <div class="toast-body">Permissions updated successfully!</div>
                                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                                    data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Select All JS -->
                <script>
                const selectAll = document.getElementById('select_all');
                const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#select_all)');

                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });

                checkboxes.forEach(cb => cb.addEventListener('change', function() {
                    selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
                }));
                </script>

                <!-- AJAX Submit -->
                <script>
                document.getElementById('rolePermissionForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch("{{ url('/role_permission/'.$roleId) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 200) {
                                toastr.success(data.message);
                                setTimeout(() => {
                                    window.location.href = "{{ route('roles.index') }}";
                                }, 1500);
                            } else {
                                toastr.error('Failed to save permissions');
                            }
                        })
                        .catch(err => toastr.error('An error occurred'));
                });
                </script>

                @include('footer')
            </div>
        </div>
    </div>

    @include('script')
    @include('session_timeout')
</body>

</html>