<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                            placeholder="Search Cuba .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span
                                class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper col-4 p-0">
            <div class="logo-wrapper"><a href="dashboard"><img class="img-fluid"
                        src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul>
                <li class="onhover-dropdown">

                    <div class="notification-box">
                        <i data-feather="bell"></i>
                        <span class="badge rounded-pill badge-primary" id="notify_count">0</span>
                    </div>

                    <div class="onhover-show-div notification-dropdown" style="overflow:auto; max-height:400px;"
                        id="notify_list">

                        <h6 class="f-18 mb-0 dropdown-title">Notifications</h6>

                        <ul id="notification_ul"></ul>

                        <div class="d-flex justify-content-between p-2">
                            <span onclick="notify_clear()" style="cursor:pointer;color:red">
                                Clear
                            </span>

                            <a href="{{ route('notifications.all') }}">Check all</a>
                        </div>

                    </div>

                </li>
                <li class="onhover-dropdown p-0 me-0">
                    <div class="media profile-media"><img class="b-r-10" style="width:50px;height:50px;"
                            src="{{ asset('assets/images/dashboard/22626.png') }}" id="profile_pic" alt="">
                        <div class="media-body" id="h_username"><span></span>
                            <p class="mb-0 font-roboto" id="h_rolename"><i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="user_profile"><i data-feather="user"></i><span>Account </span></a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-in"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</div>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        load_notifications();

    });


    function load_notifications() {
        $.ajax({

            url: "{{ route('notifications.list') }}",
            type: "GET",

            success: function(res) {

                let html = '';

                $('#notify_count').text(res.count);

                if (res.data.length == 0) {
                    html += `<li class="p-2">No Notifications</li>`;
                }

                res.data.forEach(function(item) {

                    html += `
                <li class="b-l-primary border-4">
                    <p onclick="view_notify(${item.notify_id})" style="cursor:pointer">
                        ${item.title ?? ''} ${item.content ?? ''}
                    </p>

                    <span class="font-danger">
                        ${timeAgo(item.created_at)}
                    </span>
                </li>
                `;

                });

                $('#notification_ul').html(html);

            }

        });
    }
</script>

<script>
    function notify_clear() {
        $.ajax({

            url: "{{ route('notifications.clear') }}",
            type: "POST",

            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function() {

                load_notifications();

            }

        });
    }
</script>

<script>
    function timeAgo(date) {
        let seconds = Math.floor((new Date() - new Date(date)) / 1000);

        let interval = seconds / 86400;

        if (interval > 1) {
            return Math.floor(interval) + " days ago";
        }

        interval = seconds / 3600;

        if (interval > 1) {
            return Math.floor(interval) + " hours ago";
        }

        interval = seconds / 60;

        if (interval > 1) {
            return Math.floor(interval) + " minutes ago";
        }

        return Math.floor(seconds) + " seconds ago";
    }
    setInterval(function() {

        load_notifications();

    }, 10000);
</script>
<script>
    function view_notify(id) {
        $.ajax({

            url: "/notification-view/" + id,
            type: "GET",

            success: function() {

                load_notifications();

            }

        });
    }
</script>
