
<div class="sidebar-wrapper close_icon" >
    <div>
    <div class="logo-wrapper " >
      <a href="dashboard">
        <!-- <img class="img-fluid for-light" src="{{ asset('assets/logo/logo.png') }}" alt=""> -->
        <img class="img-fluid for-light" src="{{ asset('assets/logo/renew_1.png') }}" width="75" id="c_logo"><!--  style="height: 90px !important;width: 90px !important;"> -->
      </a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <div class="logo-icon-wrapper">
      <a href="dashboard">
        <!-- <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""> -->
        <img class="img-fluid" src="{{ asset('assets/logo/renew_3.png') }}" width="60" id="c_logo"><!--  style="height: 40px !important;width: 40px !important;"> -->
      </a>
    </div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          <li class="back-btn"><a href="dashboard"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>
          <li id='dashboard_page' class="sidebar-list"><a class="sidebar-link " href="dashboard">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
            <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
          </svg>
          <span >Dashboard</span></a>
            <ul class="sidebar-submenu">
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
            <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
          </svg>
          <span>Lead management</span></a>
            <ul class="sidebar-submenu">
              <li id='lead_page'><a href="lead">Lead</a></li>
              <li  id='followup_page'><a href="followup">Followup</a></li>
           
            </ul>
          </li>

          <!-- <li class="sidebar-list"><a class="sidebar-link" href="followup"><i data-feather="followup"></i><span>Followup</span></a>
          </li> -->

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
            <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/>
          </svg>
          </i><span>Customer management</span></a>
            <ul class="sidebar-submenu">
              <li  id='customer_page'><a href="customer">Customers</a></li>
              <li  id='customer_treatment_page'><a href="treatment_management">Customer Treatments</a></li>
           
            </ul>
          </li>
          <!-- <li class="sidebar-list"><a class="sidebar-link" href="customer"><i data-feather="users"></i><span>Customer</span></a> -->
            <!-- <ul class="sidebar-submenu">
              <li><a href="box-layout.html">Boxed</a></li>
              <li><a href="layout-rtl.html">RTL</a></li>
              <li><a href="layout-dark.html">Dark Layout</a></li>
              <li><a href="hide-on-scroll.html">Hide Nav Scroll</a></li>
              <li><a href="footer-light.html">Footer Light</a></li>
              <li><a href="footer-dark.html">Footer Dark</a></li>
              <li><a href="footer-fixed.html">Footer Fixed</a></li>
            </ul> -->
          <!-- </li> -->
          <!-- <li class="sidebar-main-title">
            <div>
              <h6 class="lan-8">Applications</h6>
              <p class="lan-9">Ready to use Apps</p>
            </div>
          </li> -->
          <li class="sidebar-list"  id='appointment_page'>
            <!-- <label class="badge badge-light-secondary">New</label> -->
            <a class="sidebar-link" href="appointment">
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
              <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM305 273L177 401c-9.4 9.4-24.6 9.4-33.9 0L79 337c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L271 239c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
            </svg>
              <span>Appointment</span></a>
            <!-- <ul class="sidebar-submenu"> -->
             <!--  <li><a href="projects.html">Project List</a></li>
              <li><a href="projectcreate.html">Create new</a></li> -->
            <!-- </ul> -->
          </li>
          
          <!-- <li class="sidebar-list">  
           
            <a class="sidebar-link sidebar-title link-nav" href="treatment_management"><i data-feather="file-plus"></i><span>Customer Treatments</span></a>
          </li> -->
          <!-- <li class="sidebar-list"  id='billing_page'><a class="sidebar-link" href="billing">
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
              <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
            </svg>
          <span>Billing</span></a>
            <ul class="sidebar-submenu">
            </ul>
          </li> -->
          <li class="sidebar-list" ><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
            <path d="M326.7 403.7c-22.1 8-45.9 12.3-70.7 12.3s-48.7-4.4-70.7-12.3c-.3-.1-.5-.2-.8-.3c-30-11-56.8-28.7-78.6-51.4C70 314.6 48 263.9 48 208C48 93.1 141.1 0 256 0S464 93.1 464 208c0 55.9-22 106.6-57.9 144c-1 1-2 2.1-3 3.1c-21.4 21.4-47.4 38.1-76.3 48.6zM256 84c-11 0-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V312c0 11 9 20 20 20s20-9 20-20V298.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V104c0-11-9-20-20-20zM48 352H64c19.5 25.9 44 47.7 72.2 64H64v32H256 448V416H375.8c28.2-16.3 52.8-38.1 72.2-64h16c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V400c0-26.5 21.5-48 48-48z"/>
          </svg>
            <span>Sales </span></a>
            <ul class="sidebar-submenu">
              <li  id='billing_page'><a href="billing">Billing</a></li>
              <li  id='customer_payment_page'><a href="payment">Receipt</a></li>
              <li  id='sales_page'><a href="sales">Sales</a></li>
            </ul>
          </li>

          <!-- <li class="sidebar-list">   -->
            <!-- <label class="badge badge-light-danger">Latest</label> -->
            <!-- <a class="sidebar-link sidebar-title link-nav" href="sales"><i data-feather="file-plus"></i><span>Sales</span></a>
          </li> -->


          <!-- <li class="sidebar-list"><a class="sidebar-link" href="payment"><i data-feather="credit-card"></i><span>Payment</span></a>
            <ul class="sidebar-submenu"> -->
             <!--  <li><a href="product.html">Product</a></li>
              <li><a href="product-page.html">Product page</a></li>
              <li><a href="list-products.html">Product list</a></li>
              <li><a href="payment-details.html">Payment Details</a></li>
              <li><a href="order-history.html">Order History</a></li>
              <li><a href="invoice-template.html">Invoice</a></li>
              <li><a href="cart.html">Cart</a></li>
              <li><a href="list-wish.html">Wishlist</a></li>
              <li><a href="checkout.html">Checkout</a></li>
              <li><a href="pricing.html">Pricing</a></li> -->
            <!-- </ul>
          </li> -->
          <!-- <li class="sidebar-list"  id='invoice_page'><a class="sidebar-link" href="invoice">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
            <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
          </svg>
          <span>Invoice</span></a>
            <ul class="sidebar-submenu">
              
            </ul>
          </li> -->
          <li class="sidebar-list"  id='inventory_page'><a class="sidebar-link" href="inventory">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
            
            <path d="M64 144c0-26.5 21.5-48 48-48s48 21.5 48 48V256H64V144zM0 144V368c0 61.9 50.1 112 112 112s112-50.1 112-112V189.6c1.8 19.1 8.2 38 19.8 54.8L372.3 431.7c35.5 51.7 105.3 64.3 156 28.1s63-107.5 27.5-159.2L427.3 113.3C391.8 61.5 321.9 49 271.3 85.2c-28 20-44.3 50.8-47.3 83V144c0-61.9-50.1-112-112-112S0 82.1 0 144zm296.6 64.2c-16-23.3-10-55.3 11.9-71c21.2-15.1 50.5-10.3 66 12.2l67 97.6L361.6 303l-65-94.8zM491 407.7c-.8 .6-1.6 1.1-2.4 1.6l4-2.8c-.5 .4-1 .8-1.6 1.2z"/></svg>
          <span>Inventory</span></a>
            <ul class="sidebar-submenu">
              <!-- <li><a href="email-application.html">Email App</a></li>
              <li><a href="email-compose.html">Email Compose</a></li> -->
            </ul>
          </li>

          <li class="sidebar-list" ><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
            
            <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
            <span>HR management</span></a>
            <ul class="sidebar-submenu">
              <li  id='staff_page'><a href="staff">Staff</a></li>
              <li  id='attendance_page'><a href="attendance">Attendance</a></li>
           
            </ul>
          </li>
          
          <!-- <li class="sidebar-list"><a class="sidebar-link link-nav" href="staff"><i data-feather="user-check"></i><span>Staff</span></a></li>

          <li class="sidebar-list"><a class="sidebar-link" href="attendance"><i data-feather="clipboard"></i><span>Attendance</span></a>
            <ul class="sidebar-submenu"> -->
              <!-- <li><a href="email-application.html">Email App</a></li>
              <li><a href="email-compose.html">Email Compose</a></li> -->
            <!-- </ul>
          </li> -->
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
            <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
            <span>Report</span></a>
            <ul class="sidebar-submenu">
              <li id="lead_rpt_page" ><a href="report_lead">Lead Report</a></li>
              <li id="appointment_rpt_page"><a href="report_app">Appointment Report</a></li>
              <li id="stock_rpt_page"><a href="report_stock">Stock Report</a></li>
              <li id="attendance_rpt_page"><a href="report_atd">Attendance Report</a></li>
              <li id="payment_rpt_page"><a href="report_pay">Payment Report</a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"  id='settings_page'><a class="sidebar-link sidebar-title" href="javascript:;">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
            
            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
            <span>Settings</span></a>
            <ul class="sidebar-submenu">
              <li  id='general_setting_page'><a href="general">General Settings</a></li>
              <li id='email_setting_page'><a href="email">Email Configuration</a></li>
              <li id='company_page'><a href="company">Company</a></li>
              <li  id='branch_page'><a href="branch">Branch</a></li>
              <li  id='department_page'><a href="department">Department</a></li>
              <li  id='designation_page'><a href="designation">Designation</a></li>
              <li  id='brand_page'><a href="brand">Brand</a></li>
              <li  id='lead_source_page'><a href="lead_source">Lead Source</a></li>
              <li  id='lead_status_page'><a href="lead_status">Lead Status</a></li>
              <li  id='product_category_page'><a href="product_category">Product Category</a></li>
              <li  id='product_page'><a href="product">Product</a></li>
              <li  id='treatment_category_page'><a href="t_category">Treatment Category</a></li>
              <li  id='treatment_page'><a href="treatment">Treatment</a></li>
              <li  id='role_page'><a href="role_permission">Role</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
    </div>
</div>


