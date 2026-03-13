<?php

use Illuminate\Http\Request;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Token Validation
Route::get('login', function () {
    return redirect('/');
})->name('login');
Route::middleware('auth:api')->group(function () {

    //Logout
    Route::post('/logout', [LoginController::class, 'Logout']);

    //Dashborad
    Route::get('/dashborad_count', [DashboardController::class,'Count']);
    Route::get('/dashborad_customer', [DashboardController::class,'Customer']);
    Route::get('/dashborad_appointment', [DashboardController::class,'Appointment']);
    Route::get('/dashborad_treatment', [DashboardController::class,'Treatment']);
    Route::post('/dashboard_comparison', [DashboardController::class,'Comparison']);
    Route::post('/dashboard_comparison_fm', [DashboardController::class,'Comparisonfm']);
    
     //billing module
    Route::post('/add_billing', [BillingController::class,'Add']);
      Route::get('/edit_billing/{id}', [BillingController::class,'Edit']);
    Route::post('/billing', [BillingController::class,'All']);
    Route::get('/treatment_all/{id}', [BillingController::class,'TreatmentAll']);
    Route::get('/treatment_category', [BillingController::class,'TreatmentcategoryAll']);
    Route::get('/customer_treatment_cat/{id}', [BillingController::class,'TreatmenCategory']);
    Route::post('/balance_payment/{id}', [BillingController::class,'BalancePay']);
   
    Route::get('/get_billing_details/{id}', [BillingController::class, 'getBillingDetails']);
    
     Route::get('/billing_invoice/{id}', [BillingController::class,'InvoiceBilling']);
    // Lead CRUD 
    Route::get('/lead/{id}', [LeadController::class,'All']);
    Route::post('/add_lead', [LeadController::class,'Add']);
    Route::get('/edit_lead/{id}', [LeadController::class,'Edit']);
    Route::get('/update_lead/{id}', [LeadController::class,'Update']);
    Route::delete('/delete_lead/{id}', [LeadController::class,'Delete']);
    Route::get('/lead_status/{id}', [LeadController::class,'Status']);

    Route::get('/lead_search/{id}', [LeadController::class,'Search']);
 Route::get('/lead_list', [LeadController::class,'LeadList']);
    //Convert Customer
    Route::get('/convert/{id}', [CustomerController::class,'Add']);

    //Setting Customer CRUD 
    Route::get('/customer/{id}', [CustomerController::class,'All']);
    Route::get('/customer_list/{id}', [CustomerController::class,'List']);
    Route::get('/edit_customer/{id}', [CustomerController::class,'Edit']);
    Route::get('/update_customer/{id}', [CustomerController::class,'Update']);
    Route::delete('/delete_customer/{id}', [CustomerController::class,'Delete']);
    Route::get('/customer_status/{id}', [CustomerController::class,'Status']);

    Route::get('/customer_search/{id}', [CustomerController::class,'Search']);

    //Appointment CRUD 
    Route::get('/appointment', [AppointmentController::class,'All']);
    Route::post('/add_appointment', [AppointmentController::class,'Add']);
    Route::get('/edit_appointment/{id}', [AppointmentController::class,'Edit']);
    Route::get('/update_appointment/{id}', [AppointmentController::class,'Update']);
    Route::delete('/delete_appointment/{id}', [AppointmentController::class,'Delete']);
    Route::get('/appointment_status/{id}', [AppointmentController::class,'Status']);
    Route::get('/appointment_details/{id}', [AppointmentController::class,'Remark']);
    

    Route::post('/appointment_payment', [AppointmentController::class,'Payment']);
    //Treatment Managment
    
    Route::post('/customer_treatment', [CustomerTreatmentController::class,'All']);
    Route::post('/add_customer_treatment', [CustomerTreatmentController::class,'Add']);
    Route::get('/edit_customer_treatment/{id}', [CustomerTreatmentController::class,'Edit']);
    Route::get('/update_customer_treatment/{id}', [CustomerTreatmentController::class,'Update']);
    Route::delete('/delete_customer_treatment/{id}', [CustomerTreatmentController::class,'Delete']);
    Route::post('/completed_customer_treatment/{id}', [CustomerTreatmentController::class,'Completed']);
    Route::get('/customer_treatment_status/{id}', [CustomerTreatmentController::class,'Status']);

    
    Route::post('/customer_list', [CustomerTreatmentController::class,'Customer']);
    Route::get('/cus_treament_list/{id}', [CustomerTreatmentController::class,'Treatment']);
    Route::get('/customer_treatment_invoice/{id}', [CustomerTreatmentController::class,'Invoice']);

    //
    Route::get('/invoice_generator', [paymentController::class,'InvoiceGenerator']);
    Route::post('/invoice', [paymentController::class,'Invoice']);
    Route::post('/invoice_list', [paymentController::class,'InvoiceList']);
    

    //Payment CRUD 
    Route::post('/payment', [paymentController::class,'All']);
    
    Route::get('/customer_treatment_list', [paymentController::class,'Customer']);
    Route::get('/customer_treatment_cat/{id}', [paymentController::class,'TreatmenCategory']);
    Route::get('/customer_treatment_all/{id}', [paymentController::class,'Treatment']);

 
    
    Route::post('/add_payment', [paymentController::class,'Add']);
    Route::get('/edit_payment/{id}', [paymentController::class,'Edit']);
    Route::get('/update_payment/{id}', [paymentController::class,'Update']);
    Route::delete('/delete_payment/{id}', [paymentController::class,'Delete']);
    Route::get('/payment_status/{id}', [paymentController::class,'Status']);

    Route::get('/consultation', [paymentController::class,'Consultation']);
    
    //sales
    Route::get('/sales', [SalesController::class,'All']);
    Route::post('/add_sales', [SalesController::class,'Add']);
    Route::get('/edit_sales/{id}', [SalesController::class,'Edit']);
    Route::get('/update_sales/{id}', [SalesController::class,'Update']);
    Route::delete('/delete_sales/{id}', [SalesController::class,'Delete']);
    Route::get('/sales_status/{id}', [SalesController::class,'Status']);
    Route::get('/get_category/{id}', [SalesController::class,'GetCategory']);
    Route::get('/get_product/{id}', [SalesController::class,'GetProduct']);



    //Inventory CRUD 
    Route::post('/inventory', [InventoryController::class,'All']);
    Route::post('/add_inventory', [InventoryController::class,'Add']);
    Route::get('/edit_inventory/{id}', [InventoryController::class,'Edit']);
    Route::get('/update_inventory/{id}', [InventoryController::class,'Update']);
    Route::delete('/delete_inventory/{id}', [InventoryController::class,'Delete']);
    Route::get('/inventory_status/{id}', [InventoryController::class,'Status']);

    Route::get('/inventory_category/{id}', [InventoryController::class,'CategoryList']);
    Route::get('/inventory_product/{id}', [InventoryController::class,'ProductList']);
    Route::post('/inventory_product_count', [InventoryController::class,'Count']);
    
    
    //Attendance CRUD 
    Route::post('/attendance', [AttendanceController::class,'All']);
    Route::get('/mark_attendance', [AttendanceController::class,'MarkAttendance']);
    Route::post('/add_attendance', [AttendanceController::class,'Add']);
    Route::get('/update_attendance/{id}', [AttendanceController::class,'Update']);
    //Route::get('/update_month/{id}', [AttendanceController::class,'Update']);

    //Reports
    Route::post('/lead_report', [ReportController::class,'LeadReport']);
    Route::post('/appointment_report', [ReportController::class,'AppointmentReport']);
    Route::post('/stock_report', [ReportController::class,'StockReport']);
    Route::post('/attendance_report', [ReportController::class,'AttendanceReport']);
    Route::post('/payment_report', [ReportController::class,'PaymentReport']);


// Notifiy
    Route::get('/notification', [NotificationController::class,'List']);
    Route::get('/notification_view/{id}', [NotificationController::class,'View']);
    Route::get('/all_notification', [NotificationController::class,'All']);
    Route::get('/notification_clear', [NotificationController::class,'Clear']);

    //Setting Role CRUD 
    Route::get('/role', [RoleController::class,'Index']);
    Route::post('/add_role', [RoleController::class,'Add']);
    Route::get('/edit_role/{id}', [RoleController::class,'Edit']);
    Route::get('/update_role/{id}', [RoleController::class,'Update']);
    Route::delete('/delete_role/{id}', [RoleController::class,'Delete']);
    Route::get('/role_status/{id}', [RoleController::class,'Status']);
    
    
    //setting Role Permission 
    Route::get('/role_permission/{id}', [RolePermissionController::class,'Permission']);
    Route::get('/role_permission_view/{id}', [RolePermissionController::class,'Index']);

    Route::get('/role_permission_page/{name}', [RolePermissionController::class,'PagePermission']);
    
   

    //Setting Branch CRUD 
    Route::get('/branch', [BranchController::class,'Index']);
    Route::post('/add_branch', [BranchController::class,'Add']);
    Route::get('/edit_branch/{id}', [BranchController::class,'Edit']);
    Route::get('/update_branch/{id}', [BranchController::class,'Update']);
    Route::delete('/delete_branch/{id}', [BranchController::class,'Delete']);
    Route::get('/branch_status/{id}', [BranchController::class,'Status']);

    //Setting General CRUD 
    Route::get('/general', [GeneralController::class,'Index']);
    Route::post('/update_general/{id}', [GeneralController::class,'Update']);

    //Setting Department CRUD 
    Route::get('/department', [DepartmentController::class,'Index']);
    Route::post('/add_department', [DepartmentController::class,'Add']);
    Route::get('/edit_department/{id}', [DepartmentController::class,'Edit']);
    Route::get('/update_department/{id}', [DepartmentController::class,'Update']);
    Route::delete('/delete_department/{id}', [DepartmentController::class,'Delete']);
    Route::get('/department_status/{id}', [DepartmentController::class,'Status']);

    //Setting Designation CRUD 
    Route::get('/designation', [DesignationController::class,'Index']);
    Route::post('/add_designation', [DesignationController::class,'Add']);
    Route::get('/edit_designation/{id}', [DesignationController::class,'Edit']);
    Route::get('/update_designation/{id}', [DesignationController::class,'Update']);
    Route::delete('/delete_designation/{id}', [DesignationController::class,'Delete']);
    Route::get('/designation_status/{id}', [DesignationController::class,'Status']);

    //Setting Staff CRUD 
    Route::get('/staff', [StaffController::class,'All']);
    Route::post('/add_staff', [StaffController::class,'Add']);
    Route::get('/edit_staff/{id}', [StaffController::class,'Edit']);
    Route::get('/view_staff/{id}', [StaffController::class,'View']);
    Route::get('/update_staff/{id}', [StaffController::class,'Update']);
    Route::delete('/delete_staff/{id}', [StaffController::class,'Delete']);
    Route::get('/staff_status/{id}', [StaffController::class,'Status']);
    Route::get('/user_profile/{id}', [StaffController::class,'UserEdit']);
    Route::post('/update_user/{id}', [StaffController::class,'UserUpdate']);

    //Setting Treatment CRUD 
    Route::get('/treatment', [TreatmentController::class,'Index']);
    Route::post('/add_treatment', [TreatmentController::class,'Add']);
    Route::get('/edit_treatment/{id}', [TreatmentController::class,'Edit']);
    Route::get('/update_treatment/{id}', [TreatmentController::class,'Update']);
    Route::delete('/delete_treatment/{id}', [TreatmentController::class,'Delete']);
    Route::get('/treatment_status/{id}', [TreatmentController::class,'Status']);

    Route::get('/manage_treatment_cat', [TreatmentController::class,'TreatmentCategory']);
    Route::get('/manage_treatment/{id}', [TreatmentController::class,'Treatment']);
    Route::post('/customer_treatment_amount', [TreatmentController::class,'Amount']);
    

    //Setting Treatment Category CRUD 
    Route::get('/treatment_cat', [TreatmentCategoryController::class,'Index']);
    Route::post('/add_treatment_cat', [TreatmentCategoryController::class,'Add']);
    Route::get('/edit_treatment_cat/{id}', [TreatmentCategoryController::class,'Edit']);
    Route::get('/update_treatment_cat/{id}', [TreatmentCategoryController::class,'Update']);
    Route::delete('/delete_treatment_cat/{id}', [TreatmentCategoryController::class,'Delete']);
    Route::get('/treatment_cat_status/{id}', [TreatmentCategoryController::class,'Status']);

 

    //Setting Follwup CRUD 
    Route::get('/followup', [FollowUpController::class,'All']);
    Route::post('/add_followup', [FollowUpController::class,'Add']);
    Route::get('/edit_followup/{id}', [FollowUpController::class,'Edit']);
    Route::get('/update_followup/{id}', [FollowUpController::class,'Update']);
    Route::delete('/delete_followup/{id}', [FollowUpController::class,'Delete']);
    Route::get('/followup_status/{id}', [FollowUpController::class,'Status']);
    Route::get('/followup_completed/{id}', [FollowUpController::class,'Completed']);
    //Setting Product CRUD 
    Route::get('/product', [ProductController::class,'Index']);
    Route::get('/product_list', [ProductController::class,'ProductList']);
    Route::post('/add_product', [ProductController::class,'Add']);
    Route::get('/edit_product/{id}', [ProductController::class,'Edit']);
    Route::get('/update_product/{id}', [ProductController::class,'Update']);
    Route::delete('/delete_product/{id}', [ProductController::class,'Delete']);
    Route::get('/product_status/{id}', [ProductController::class,'Status']);


    //Setting Brand CRUD 
    Route::get('/brand', [BrandController::class,'Index']);
    Route::post('/add_brand', [BrandController::class,'Add']);
    Route::get('/edit_brand/{id}', [BrandController::class,'Edit']);
    Route::get('/update_brand/{id}', [BrandController::class,'Update']);
    Route::delete('/delete_brand/{id}', [BrandController::class,'Delete']);
    Route::get('/brand_status/{id}', [BrandController::class,'Status']);

    //Setting Product Category CRUD 
    Route::get('/product_category', [ProductCategoryController::class,'Index']);
    Route::post('/add_product_category', [ProductCategoryController::class,'Add']);
    Route::get('/edit_product_category/{id}', [ProductCategoryController::class,'Edit']);
    Route::get('/update_product_category/{id}', [ProductCategoryController::class,'Update']);
    Route::delete('/delete_product_category/{id}', [ProductCategoryController::class,'Delete']);
    Route::get('/product_category_status/{id}', [ProductCategoryController::class,'Status']);

    //Setting Lead Resource CRUD 
    Route::get('/lead_source', [LeadSourceController::class,'Index']);
    Route::post('/add_lead_source', [LeadSourceController::class,'Add']);
    Route::get('/edit_lead_source/{id}', [LeadSourceController::class,'EditView']);
    Route::post('/update_lead_source/{id}', [LeadSourceController::class,'Update']);
    Route::delete('/delete_lead_source/{id}', [LeadSourceController::class,'Delete']);
    Route::get('/lead_source_status/{id}', [LeadSourceController::class,'Status']);

    //Setting Lead Resource CRUD 
    Route::get('/lead_status', [LeadStatusController::class,'Index']);
    Route::post('/add_lead_status', [LeadStatusController::class,'Add']);
    Route::get('/edit_lead_status/{id}', [LeadStatusController::class,'Edit']);
    Route::get('/update_lead_status/{id}', [LeadStatusController::class,'Update']);
    Route::delete('/delete_lead_status/{id}', [LeadStatusController::class,'Delete']);
    Route::get('/lead_status_status/{id}', [LeadStatusController::class,'Status']);


    //Setting Lead Resource CRUD 
    Route::get('/company', [CompanyController::class,'Index']);
    Route::get('/edit_company/{id}', [CompanyController::class,'Edit']);
    Route::get('/company/{id}', [CompanyController::class,'Update']);





});


//login 
Route::post('/login', [LoginController::class,'login']);

Route::get('/states', [LoginController::class,'State']);