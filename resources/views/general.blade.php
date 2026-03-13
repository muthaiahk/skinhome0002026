@include('common')
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet"
    type="text/css" />

<body>
    <!-- loader starts-->
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
    <!-- loader ends-->

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('header')
        <div class="page-body-wrapper">
            @include('sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>General Settings</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">General Settings</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Container-fluid starts-->
                <form class="form wizard" id="general_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div id="status_success"></div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <!-- Logo -->
                                            <div class="col-lg-4 position-relative avatar">
                                                <label class="form-label">Logo</label>
                                                <div class="image-input image-input-outline" id="logo">
                                                    <div class="image-input-wrapper"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                                        <input type="file" onchange="img_logo(this);"
                                                            id="profile_avatar_logo" name="profile_avatar_logo"
                                                            accept=".png, .jpg, .jpeg" style="display: none;" />
                                                        <input type="hidden" name="profile_avatar_logo_remove" /><br>
                                                        <img class="img-100 b-r-8" id="logo_gs"
                                                            src="{{ $general->logo ?? asset('assets/logo/blank.png') }}" />
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Favicon -->
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Favicon</label>
                                                <div class="image-input image-input-outline" id="fav">
                                                    <div class="image-input-wrapper"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                                        <input type="file" onchange="img_fav(this);"
                                                            id="profile_avatar_fav" name="profile_avatar_fav"
                                                            accept=".png, .jpg, .jpeg" style="display: none;" />
                                                        <input type="hidden" name="profile_avatar_fav_remove" /><br>
                                                        <img class="img-100 b-r-8" id="fav_gs"
                                                            src="{{ $general->favicon ?? asset('assets/logo/blank.png') }}" />
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Default Profile -->
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Default profile</label>
                                                <div class="image-input image-input-outline" id="default_profile">
                                                    <div class="image-input-wrapper"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-hover-text-primary btn-shadow">
                                                        <input type="file" onchange="img_default(this);"
                                                            id="profile_avatar_default" name="profile_avatar_default"
                                                            accept=".png, .jpg, .jpeg" style="display: none;" />
                                                        <input type="hidden" name="profile_avatar_default_remove" /><br>
                                                        <img class="img-100 b-r-8" id="default_gs"
                                                            src="{{ $general->default_pic ?? asset('assets/logo/blank.png') }}" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Company Name</label>
                                                <input class="form-control" type="text"
                                                    value="{{ $general->company_name ?? '' }}"
                                                    placeholder="Company Name" required id="company_name">
                                            </div>

                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Date Format</label>
                                                <select class="form-select" id="Select_date">
                                                    <option
                                                        {{ ($general->date_format ?? '') == 'YYYY/MM/DD' ? 'selected' : '' }}>
                                                        YYYY/MM/DD</option>
                                                    <option
                                                        {{ ($general->date_format ?? '') == 'DD/MM/YYYY' ? 'selected' : '' }}>
                                                        DD/MM/YYYY</option>
                                                    <option
                                                        {{ ($general->date_format ?? '') == 'MM/DD/YYYY' ? 'selected' : '' }}>
                                                        MM/DD/YYYY</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Time</label>
                                                <select class="form-select" id="Select_time">
                                                    <option
                                                        {{ ($general->time_zone ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>
                                                        Asia/Kolkata (UTC+05:30)</option>
                                                    <option
                                                        {{ ($general->time_zone ?? '') == 'Atlantic/Azores' ? 'selected' : '' }}>
                                                        Atlantic/Azores (UTC-01:00)</option>
                                                    <option
                                                        {{ ($general->time_zone ?? '') == 'Asia/Beirut' ? 'selected' : '' }}>
                                                        Asia/Beirut (UTC+02:00)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Mobile</label>
                                                <input class="form-control" type="text"
                                                    value="{{ $general->phone_no ?? '' }}" placeholder="Mobile" required
                                                    id="mobile">
                                            </div>

                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Company Website</label>
                                                <input class="form-control" type="url"
                                                    value="{{ $general->website ?? '' }}" placeholder="Company Website"
                                                    required id="website">
                                            </div>

                                            <div class="col-lg-4 position-relative">
                                                <label class="form-label">Opening Date</label>
                                                <input class="form-control" type="date"
                                                    value="{{ $general->established_date ?? '' }}" required
                                                    id="opening_date">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="card-footer text-end">
                                                <button id="update_btn" class="btn btn-primary" type="button"
                                                    onclick="upd_general();">Update</button>
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

            @include('footer')
        </div>
    </div>

    @include('script')
    @include('session_timeout')

    <script>
    var logo_img = "";
    var fav_img = "";
    var default_img = "";

    function img_logo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#logo_gs').attr('src', e.target.result).width(200).height(100);
            };
            reader.readAsDataURL(input.files[0]);
            logo_img = input.files[0];
        }
    }

    function img_fav(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#fav_gs').attr('src', e.target.result).width(200).height(100);
            };
            reader.readAsDataURL(input.files[0]);
            fav_img = input.files[0];
        }
    }

    function img_default(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#default_gs').attr('src', e.target.result).width(200).height(100);
            };
            reader.readAsDataURL(input.files[0]);
            default_img = input.files[0];
        }
    }

    function upd_general() {
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'POST'); // for Laravel update route
        formData.append('company_name', $('#company_name').val());
        formData.append('mobile', $('#mobile').val());
        formData.append('website', $('#website').val());
        formData.append('date_format', $('#Select_date').val());
        formData.append('opening_date', $('#opening_date').val());

        if (logo_img) formData.append('logo', logo_img);
        if (fav_img) formData.append('favicon', fav_img);
        if (default_img) formData.append('default_pic', default_img);

        var $btn = $('#update_btn'); // assign button an ID
        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

        $.ajax({
            url: "{{ route('general.update', $general->g_set_id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#status_success').html('<div class="alert alert-success">' + response.message +
                    '</div>');

                // Wait 2 seconds then refresh
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    alert("Validation error");
                } else {
                    alert("Something went wrong");
                }
                $btn.prop('disabled', false).html('Update'); // reset button
            }
        });
    }
    </script>

</body>