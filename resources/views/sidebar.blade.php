<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ url('dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/logo/renew_1.png') }}" width="75" id="c_logo">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ url('dashboard') }}">
                <img class="img-fluid" src="{{ asset('assets/logo/renew_3.png') }}" width="60" id="c_logo">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">

                    <li class="back-btn">
                        <a href="{{ url('dashboard') }}">
                            <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                        </a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                    <!-- Dashboard -->
                    <li id='dashboard_page' class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                                <path
                                    d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Lead Management -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('lead*', 'followup*', 'add_lead*', 'add_followup*') ? 'active' : '' }}" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                                <path
                                    d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                            </svg>
                            <span>Lead management</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('lead*', 'followup*', 'add_lead*', 'add_followup*') ? 'display: block !important;' : '' }}">
                            <li id='lead_page'><a class="{{ Request::is('lead*') ? 'active' : '' }}" href="{{ url('lead') }}">Lead</a></li>
                            <li id='followup_page'><a class="{{ Request::is('followup*') ? 'active' : '' }}" href="{{ url('followup') }}">Followup</a></li>
                        </ul>
                    </li>

                    <!-- Customer Management -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('customer*', 'treatment_management*') ? 'active' : '' }}" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                                <path
                                    d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z" />
                            </svg>
                            <span>Customer management</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('customer*', 'treatment_management*') ? 'display: block !important;' : '' }}">
                            <li id='customer_page'><a class="{{ Request::is('customer*') && !Request::is('customer_treatment*') ? 'active' : '' }}" href="{{ url('customer') }}">Customers</a></li>
                            <li id='customer_treatment_page'><a class="{{ Request::is('treatment_management*') || Request::is('customer_treatment*') ? 'active' : '' }}" href="{{ url('treatment_management') }}">Customer
                                    Treatments</a></li>
                        </ul>
                    </li>

                    <!-- Appointment -->
                    <li class="sidebar-list" id='appointment_page'>
                        <a class="sidebar-link sidebar-title link-nav {{ Request::is('appoint*') ? 'active' : '' }}" href="{{ url('appointment') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                                <path
                                    d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                            <span>Appointment</span>
                        </a>
                    </li>

                    <!-- Sales -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('billing*', 'payment*', 'add_billing*') ? 'active' : '' }}" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                <path
                                    d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 84c-11 0-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V312c0 11 9 20 20 20s20-9 20-20V298.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V104c0-11-9-20-20-20zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z" />
                            </svg>
                            <span>Sales</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('billing*', 'payment*', 'add_billing*') ? 'display: block !important;' : '' }}">
                            <li id='billing_page'><a class="{{ Request::is('billing*', 'add_billing*') ? 'active' : '' }}" href="{{ url('billing') }}">Billing</a></li>
                            <li id='customer_payment_page'><a class="{{ Request::is('payment*') ? 'active' : '' }}" href="{{ url('payment') }}">Receipt</a></li>
                        </ul>
                    </li>

                    <!-- HR Management -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('staff*', 'attendance*') ? 'active' : '' }}" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                                <path
                                    d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                            <span>HR management</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('staff*', 'attendance*') ? 'display: block !important;' : '' }}">
                            <li id='staff_page'><a class="{{ Request::is('staff*') ? 'active' : '' }}" href="{{ url('staff') }}">Staff</a></li>
                            <li id='attendance_page'><a class="{{ Request::is('attendance*') ? 'active' : '' }}" href="{{ url('attendance') }}">Attendance</a></li>
                        </ul>
                    </li>

                    <!-- Customer Reports -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('report*') ? 'active' : '' }}" href="javascript:;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                                viewBox="0 0 384 512">
                                <path
                                    d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                            </svg>
                            <span>Report</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('report*') ? 'display: block !important;' : '' }}">
                            <li id="lead_rpt_page"><a class="{{ Request::is('report_lead') ? 'active' : '' }}" href="{{ url('report_lead') }}">Lead Report</a></li>
                            <li id="appointment_rpt_page"><a class="{{ Request::is('report_app') ? 'active' : '' }}" href="{{ url('report_app') }}">Appointment Report</a>
                            </li>
                            <li id="stock_rpt_page"><a class="{{ Request::is('report_stock') ? 'active' : '' }}" href="{{ url('report_stock') }}">Stock Report</a></li>
                            <li id="attendance_rpt_page"><a class="{{ Request::is('report_atd') ? 'active' : '' }}" href="{{ url('report_atd') }}">Attendance Report</a></li>
                            <li id="payment_rpt_page"><a class="{{ Request::is('report_pay') ? 'active' : '' }}" href="{{ url('report_pay') }}">Payment Report</a></li>
                        </ul>
                    </li>

                    <!-- Settings -->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ Request::is('general', 'email', 'company*', 'branch*', 'department*', 'designation*', 'brand*', 'lead_source*', 'lead_status*', 'product*', 't_category*', 'treatment*', 'role_permission*') ? 'active' : '' }}" href="#">
                            <i data-feather="settings"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sidebar-submenu" style="{{ Request::is('general', 'email', 'company*', 'branch*', 'department*', 'designation*', 'brand*', 'lead_source*', 'lead_status*', 'product*', 't_category*', 'treatment*', 'role_permission*') ? 'display: block !important;' : '' }}">
                            <li><a class="{{ Request::is('general*') ? 'active' : '' }}" href="{{ url('general') }}">General Settings</a></li>
                            <li><a class="{{ Request::is('email*') ? 'active' : '' }}" href="{{ url('email') }}">Email Configuration</a></li>
                            <li><a class="{{ Request::is('company*') ? 'active' : '' }}" href="{{ url('company') }}">Company</a></li>
                            <li><a class="{{ Request::is('branch*') ? 'active' : '' }}" href="{{ url('branch') }}">Branch</a></li>
                            <li><a class="{{ Request::is('department*') ? 'active' : '' }}" href="{{ url('department') }}">Department</a></li>
                            <li><a class="{{ Request::is('designation*') ? 'active' : '' }}" href="{{ url('designation') }}">Designation</a></li>
                            <li><a class="{{ Request::is('brand*') ? 'active' : '' }}" href="{{ url('brand') }}">Brand</a></li>
                            <li><a class="{{ Request::is('lead_source*') ? 'active' : '' }}" href="{{ url('lead_source') }}">Lead Source</a></li>
                            <li><a class="{{ Request::is('lead_status*') ? 'active' : '' }}" href="{{ url('lead_status') }}">Lead Status</a></li>
                            <li><a class="{{ Request::is('product_category*') ? 'active' : '' }}" href="{{ url('product_category') }}">Product Category</a></li>
                            <li><a class="{{ Request::is('product*') && !Request::is('product_category*') ? 'active' : '' }}" href="{{ url('product') }}">Product</a></li>
                            <li><a class="{{ Request::is('t_category*') ? 'active' : '' }}" href="{{ url('t_category') }}">Treatment Category</a></li>
                            <li><a class="{{ Request::is('treatment*') && !Request::is('treatment_management*') ? 'active' : '' }}" href="{{ url('treatment') }}">Treatment</a></li>
                            <li><a class="{{ Request::is('role_permission*') ? 'active' : '' }}" href="{{ url('role_permission') }}">Role</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
