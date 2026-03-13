<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\TreatmentCategoryController;
use App\Http\Controllers\CustomerTreatmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BillingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', function () {
    return view('login_page');
});
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
// Route::post('/login', [LoginController::class,'login'])->name('login.submit');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
// });

// Route::get('/', [LoginController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {

     Route::get('/user_profile', [LoginController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [LoginController::class, 'update'])->name('user.profile.update');

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/dashboard-count', [DashboardController::class,'dashboardCount']);
    Route::get('/customer-chart', [DashboardController::class,'customerChart']);
    Route::get('/customer-chart-fm', [DashboardController::class,'customerGenderChart']);
    Route::get('/appointment-chart-simple', [DashboardController::class,'appointmentChart']);
    Route::get('/treatment-chart-year', [DashboardController::class,'treatmentChart']);
    Route::get('/paymentsales-report', [DashboardController::class,'paymentSalesReport']);


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
     //Setting General CRUD 
    Route::get('/general', [GeneralController::class, 'index'])->name('general.index');
    Route::post('/update_general/{id}', [GeneralController::class, 'update'])->name('general.update');
    Route::get('/company', [CompanyController::class,'Index']);
    // Route::get('/edit_company/{id}', [CompanyController::class,'Edit']);
    // Route::get('/company/{id}', [CompanyController::class,'Update']);
    Route::get('/edit_company/{id}', [CompanyController::class,'edit'])->name('company.edit');
    // Update company
    Route::post('/update_company/{id}', [CompanyController::class,'update'])->name('company.update');
    Route::post('/company/status/{id}', [CompanyController::class, 'updateStatus'])->name('company.status');

     //Setting Branch CRUD 
    Route::prefix('branch')->group(function () {
        Route::get('/', [BranchController::class,'index'])->name('branch.index');
        Route::get('/create', [BranchController::class,'create'])->name('branch.create');
        Route::post('/store', [BranchController::class,'store'])->name('branch.store');
        Route::get('/edit/{id}', [BranchController::class,'edit'])->name('branch.edit');
        Route::put('/update/{id}', [BranchController::class,'update'])->name('branch.update');
        Route::get('/view/{id}', [BranchController::class,'show'])->name('branch.show');
        Route::delete('/delete/{id}', [BranchController::class,'destroy'])->name('branch.destroy');
        Route::get('/toggle-status/{id}', [BranchController::class,'toggleStatus'])->name('branch.toggleStatus');
    });

    Route::prefix('department')->group(function () {
        Route::get('/', [DepartmentController::class,'Index'])->name('department.index');
        Route::get('/create', [DepartmentController::class, 'Create'])->name('department.create'); // <-- Add this
        Route::post('/department/store', [DepartmentController::class,'Add'])->name('department.store');
        Route::get('/edit/{id}', [DepartmentController::class,'Edit'])->name('department.edit');
        Route::post('/update/{id}', [DepartmentController::class,'Update'])->name('department.update');
        Route::delete('/delete/{id}', [DepartmentController::class,'Delete'])->name('department.delete');
        Route::post('/status/{id}', [DepartmentController::class,'Status'])->name('department.status');
    });

    Route::get('/designation', [DesignationController::class, 'Index']); // View page
    Route::get('/designation/list', [DesignationController::class,'Index']); // AJAX table data
    Route::get('/add_designation', [DesignationController::class,'addindex']);
    Route::post('/designationSave', [DesignationController::class,'Save'])->name("designationSave");
    Route::get('/edit_designation/{id}', [DesignationController::class,'Edit']);
    Route::post('/update_designation/{id}', [DesignationController::class,'Update']);
    Route::delete('/delete_designation/{id}', [DesignationController::class,'Delete']);
    Route::post('/designation_status/{id}', [DesignationController::class, 'Status']);

    Route::get('/brand', [BrandController::class,'IndexView']);
    Route::get('/add_brand', [BrandController::class,'AddView']);
    Route::get('/edit_brand/{id}', [BrandController::class,'EditView']);
    Route::post('/add_brand', [BrandController::class,'Add']);
    Route::post('/update_brand/{id}', [BrandController::class,'Update']);
    Route::delete('/delete_brand/{id}', [BrandController::class,'Delete']);
    Route::get('/brand_status/{id}', [BrandController::class,'Status']);


    Route::get('/lead_source', [LeadSourceController::class,'IndexView']);
    Route::get('/add_lead_source', [LeadSourceController::class,'AddView']);
    Route::post('/add_lead_source', [LeadSourceController::class,'Add']);
    Route::get('/edit_lead_source/{id}', [LeadSourceController::class,'EditView']);
    Route::post('/update_lead_source/{id}', [LeadSourceController::class,'Update']);
    Route::get('/view_lead_source/{id}', [LeadSourceController::class,'View']);
    Route::delete('/delete_brand/{id}', [LeadSourceController::class,'Delete']);
    Route::post('/brand_status/{id}', [LeadSourceController::class,'Status']);


    Route::get('/lead_status', [LeadStatusController::class, 'index']);
    Route::post('/lead_status', [LeadStatusController::class, 'store']);
    Route::get('/lead_status/{id}/edit', [LeadStatusController::class, 'edit']);
    Route::put('/lead_status/{id}', [LeadStatusController::class, 'update']);
    Route::delete('/lead_status/{id}', [LeadStatusController::class, 'destroy']);
    Route::get('/lead_status/toggle/{id}', [LeadStatusController::class, 'toggle']);


    Route::get('/product_category', [ProductCategoryController::class,'index']);
    Route::post('/product_category', [ProductCategoryController::class,'store']);
    Route::get('/product_category/{id}/edit', [ProductCategoryController::class,'edit']);
    Route::post('/product_category/{id}', [ProductCategoryController::class,'update']); // changed to POST
    Route::post('/product_category/{id}/delete', [ProductCategoryController::class,'destroy']);
    Route::post('/product_category/{id}/toggle-status', [ProductCategoryController::class,'toggleStatus']);

    Route::get('/product', [ProductController::class,'index'])->name('product.index');
    Route::post('/product', [ProductController::class,'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class,'edit'])->name('product.edit');
    Route::put('/product/{id}', [ProductController::class,'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class,'destroy'])->name('product.destroy');
    Route::put('/product/{id}/status', [ProductController::class,'status'])->name('product.status');


    Route::get('/t_category', [TreatmentCategoryController::class, 'index'])->name('t_category');
    Route::post('/treatment-category', [TreatmentCategoryController::class, 'store']);
    Route::get('/treatment-category/{id}/edit', [TreatmentCategoryController::class, 'edit']);
    Route::put('/treatment-category/{id}', [TreatmentCategoryController::class, 'update']); // use POST + _method=PUT
    Route::delete('/treatment-category/{id}', [TreatmentCategoryController::class, 'destroy']);
    Route::put('/treatment-category/{id}/status', [TreatmentCategoryController::class, 'status']);


    Route::get('/treatment', [TreatmentController::class, 'Index'])->name('treatment');
    Route::get('/add_treatment', function () {
        return view('add_treatment');
    });
    Route::post('/add_treatment', [TreatmentController::class, 'Add']);
    Route::get('/edit_treatment/{id}', [TreatmentController::class, 'Edit']);
    Route::post('/update_treatment/{id}', [TreatmentController::class, 'Update']);
    Route::delete('/delete_treatment/{id}', [TreatmentController::class, 'Delete']);
    Route::put('/treatment_status/{id}', [TreatmentController::class, 'Status']);
    Route::get('/manage_treatment_cat', [TreatmentController::class, 'TreatmentCategory']);
    

    Route::get('/role_permission', [RoleController::class, 'Index'])->name('roles.index');
    Route::post('/role/status/{id}', [RoleController::class, 'Status'])->name('role.status');
    Route::post('/add_role', [RoleController::class, 'Add'])->name('role.add');
    Route::get('/edit_role/{id}', [RoleController::class, 'Edit'])->name('role.edit');
    Route::post('/update_role/{id}', [RoleController::class, 'Update'])->name('role.update');
    Route::post('/delete_role/{id}', [RoleController::class, 'Delete'])->name('role.delete');

    Route::get('/add_permission', [RolePermissionController::class, 'index']);
    Route::post('/role_permission/{id}', [RolePermissionController::class, 'permission']);


    Route::get('/lead', [LeadController::class, 'leadList'])->name('lead');
    Route::get('/add_lead', [LeadController::class, 'create'])->name('lead.create');
    Route::post('/add_lead', [LeadController::class, 'Add'])->name('lead.store');
    Route::get('/edit_lead/{id}', [LeadController::class,'Edit']);
    Route::post('/update_lead/{id}', [LeadController::class,'Update'])->name('lead.update');
    Route::post('/lead/status/{id}', [LeadController::class, 'Status'])->name('lead.status');
    Route::delete('/leads/{id}', [LeadController::class, 'delete'])->name('leads.destroy');
    Route::get('/view_lead/{id}', [LeadController::class, 'ViewLead'])->name('view_lead');
    Route::post('/add_followup', [FollowUpController::class,'Add']);
    Route::post('/convert/{id}', [CustomerController::class, 'Add'])->name('convert.lead');
    
    Route::post('/leads/followup', [LeadController::class, 'addFollowup'])->name('leads.followup');
    Route::get('/followups', [FollowUpController::class, 'all'])->name('followups.index');

    Route::get('/followup', [FollowUpController::class, 'showFollowups']);
    Route::get('/followup_completed/{id}', [FollowUpController::class,'Completed']);
    // Route::post('/followups', [FollowUpController::class, 'add'])->name('followups.store');
    Route::get('/followups/{lead}/history', [FollowUpController::class, 'edit'])->name('followups.history');
    Route::delete('/followups/{id}', [FollowUpController::class, 'delete'])->name('followups.destroy');



    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/edit_customer/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/update/{id}', [CustomerController::class, 'Update'])->name('customer.update');
    Route::get('/view_customer/{id}', [CustomerController::class, 'show'])->name('customer.show');


    Route::get('/treatment_management', [CustomerTreatmentController::class,'All']);
    Route::post('/add_customer_treatment', [CustomerTreatmentController::class,'Add']);
    Route::get('/edit_customer_treatment/{id}', [CustomerTreatmentController::class,'Edit']);
    Route::post('/update_customer_treatment/{id}', [CustomerTreatmentController::class,'Update']);
    Route::delete('/delete_customer_treatment/{id}', [CustomerTreatmentController::class,'Delete']);
    Route::post('/completed_customer_treatment/{id}', [CustomerTreatmentController::class,'Completed']);
    Route::get('/customer_treatment_status/{id}', [CustomerTreatmentController::class,'Status']);   



     //Appointment CRUD 
    Route::get('/appointment', [AppointmentController::class,'All']);
    Route::post('/add_appointment',[AppointmentController::class,'Add']);
    Route::get('/edit_appointment/{id}', [AppointmentController::class,'Edit']);
    Route::post('/update_appointment/{id}', [AppointmentController::class,'Update']);
    Route::delete('/delete_appointment/{id}', [AppointmentController::class,'Delete']);
    Route::get('/appointment_status/{id}', [AppointmentController::class,'Status']);
    Route::get('/appointment_details/{id}', [AppointmentController::class,'Remark']);
    Route::post('/appointment_payment', [AppointmentController::class,'Payment']);

    Route::get('/add_billing',[BillingController::class,'AddBillingView']);

    Route::get('/customer_treatment_list', [PaymentController::class,'Customer']);
    Route::get('/customer_treatment_cat/{id}', [PaymentController::class,'TreatmenCategory']);
    Route::get('/product_list', [ProductController::class,'ProductList']);
    Route::get('/customer_treatment_all/{id}', [PaymentController::class,'Treatment']);
    Route::get('/treatment_all/{id}', [BillingController::class,'TreatmentAll']);

    Route::post('/add_billing', [BillingController::class,'Add'])->name('add_billing');
    Route::get('/billing', [BillingController::class, 'billingIndex'])->name('billing.index');
    Route::get('/edit_billing/{id}', [BillingController::class, 'editBilling'])->name('billing.edit');
    Route::get('getBillingDetails/{id}', [BillingController::class, 'getBillingDetails'])->name('billing.details');
    Route::post('/balance_payment/{id}', [BillingController::class,'BalancePay'])->name('billing.balance_payment');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.list');
    Route::get('/print_payment/{id}', [PaymentController::class,'printPayment']);

    Route::get('/inventory', [InventoryController::class,'All']);
    Route::post('/add_inventory',[InventoryController::class,'Add']);
    Route::get('/edit_inventory/{id}',[InventoryController::class,'Edit']);
    Route::post('/update_inventory/{id}',[InventoryController::class,'Update']);
    Route::delete('/delete_inventory/{id}',[InventoryController::class,'Delete']);

    Route::get('/inventory_category/{id}', [InventoryController::class,'CategoryList']);
    Route::get('/inventory_product/{id}', [InventoryController::class,'ProductList']);
    Route::post('/inventory_product_count', [InventoryController::class,'Count']);

    Route::get('/staff', [StaffController::class,'index'])->name('staff');
    Route::post('/add_staff', [StaffController::class,'Add']);
    Route::get('/edit_staff/{id}', [StaffController::class,'Edit']);
    Route::get('/view_staff/{id}', [StaffController::class,'View']);
    Route::post('/update_staff/{id}', [StaffController::class,'Update']);
    Route::delete('/delete_staff/{id}', [StaffController::class,'Delete']);
    Route::post('/staff_status/{id}', [StaffController::class,'Status']);
    Route::get('/user_profile/{id}', [StaffController::class,'UserEdit']);
    Route::post('/update_user/{id}', [StaffController::class,'UserUpdate']);


    // Route::post('/attendance', [AttendanceController::class,'All']);
    Route::get('/mark_atd', [AttendanceController::class,'MarkAttendance']);
    Route::post('/add_attendance', [AttendanceController::class,'Add']);
    Route::post('/update_attendance', [AttendanceController::class,'Update'])->name('update_attendance');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.monthly');
    Route::post('/attendance-filter',[AttendanceController::class,'attendanceFilter'])
    ->name('attendance.filter');
    Route::post('/get_branch_staff',[AttendanceController::class,'get_branch_staff']);


    Route::get('/report_lead', [ReportController::class,'LeadReport'])->name('report.lead');
    Route::get('/lead-report-export',[ReportController::class,'exportLeadReport'])->name('lead.report.export');
    Route::get('/appointment-report-export',[ReportController::class,'AppointmentReportExport'])->name('appointment.report.export');


    Route::get('/report_app', [ReportController::class, 'AppointmentReport'])
    ->name('report.appointment');

    // Export appointment report to Excel
    Route::get('/report/appointment/export', [ReportController::class, 'AppointmentReportExport'])
        ->name('report.appointment.export');

    Route::get('/report_stock', [ReportController::class,'StockReport'])->name('report.stock');
    Route::get('/report_stock/export', [ReportController::class,'StockReportExport'])->name('report.stock.export');

    Route::get('/report_atd', [ReportController::class,'AttendanceReport']);
    Route::get('/attendance/export', [ReportController::class, 'exportAttendance'])->name('attendance.export');

    Route::get('/report_pay', [ReportController::class, 'paymentReport'])->name('payment.report');
    Route::get('/report_pay/export', [ReportController::class, 'paymentReportExport'])->name('payment.export');


    Route::get('/notifications',[NotificationController::class,'List'])->name('notifications.list');
    Route::get('/notification-view/{id}',[NotificationController::class,'View'])->name('notifications.view');
    Route::post('/notification-clear',[NotificationController::class,'Clear'])->name('notifications.clear');
    Route::get('/notification-all',[NotificationController::class,'All'])->name('notifications.all');
});