<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Appointment;
use App\Models\CustomerTreatment;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\Company;

class CustomerController extends Controller
{

    public function index()
    {

        $branches = Branch::all();

        $query = Customer::select(
            'customer.customer_id',
            'branch.branch_name',
            'customer.customer_first_name',
            'customer.customer_last_name',
            'customer.customer_phone',
            'customer.customer_email',
            'customer.customer_address',
            'customer.status',
            'customer.branch_id'
        )
        ->leftJoin('branch', 'branch.branch_id', '=', 'customer.branch_id')
        ->where('customer.status', '!=', 2);
        // Limit data to 1000 rows max for DataTables front-end efficiency
        $customers = $query->orderBy('customer.customer_id', 'desc')->get();

        // Add ongoing treatment count
        foreach ($customers as $customer) {
            $customer->count = CustomerTreatment::where('customer_id', $customer->customer_id)
                ->where('progress', '0')->count();
        }

        return view('customer', compact('branches', 'customers'));
    }
    public function show($id)
    {
        // Get customer with related data
        $customer = Customer::with(['branch', 'staff', 'state'])
            ->findOrFail($id);

        // Get appointments
        $appointments = Appointment::with(['staff', 'treatment'])
            ->where('customer_id', $id)
            ->get();

        // Get treatments with payment info
        $customerTreatments = CustomerTreatment::with(['treatment', 'category', 'customer'])
            ->where('customer_id', $id)
            ->get()
            ->map(function ($t) {
                $discount = Payment::where('customer_id', $t->customer_id)
                    ->where('treatment_id', $t->treatment_id)
                    ->sum('discount');
                $paid = Payment::where('customer_id', $t->customer_id)
                    ->where('treatment_id', $t->treatment_id)
                    ->sum('amount');

                return [
                    'customer_id' => $t->customer_id,
                    'treatment_auto_id' => $t->treatment_auto_id,
                    'complete_status' => $t->complete_status,
                    'invoice_no' => $t->invoice_no ?? null,
                    'customer_first_name' => $t->customer->customer_first_name,
                    'treatment_id' => $t->treatment_id,
                    'treatment_name' => $t->treatment->treatment_name,
                    'tcategory_id' => $t->tc_id,
                    'tc_name' => $t->category->tc_name,
                    'medicine_prefered' => $t->medicine_prefered,
                    'remarks' => $t->remarks,
                    'amount' => $t->amount,
                    'discount' => $discount,
                    'paid_amount' => $paid,
                    'balance' => $t->amount - ($discount + $paid),
                ];
            });

        // Get payments
        $payments = Payment::where('customer_id', $id)->get();

        $companydetails = Company::first();
        $Branchs = Branch::where('status','!=',2)->get();
        $Staffs = Staff::where('status','!=',2)->get();

        // Pass data to Blade
        return view('view_customer', compact('companydetails','Staffs','Branchs','customer', 'appointments', 'customerTreatments', 'payments'));
    }
    //
    public function List($id, Request $request)
    {

        $customers = Customer::select('customer.customer_id', 'branch.branch_name', 'customer.customer_first_name', 'customer.customer_last_name', 'customer.customer_phone', 'customer.customer_email', 'customer.customer_address', 'lead_source.lead_source_id', 'lead_source.lead_source_name', 'lead_status.lead_status_id', 'lead_status.lead_status_name', 'customer.customer_problem', 'customer.enquiry_date', 'customer.status', 'customer.branch_id', 'branch.branch_name')
            ->leftjoin('treatment', 'treatment.treatment_id', '=', 'customer.treatment_id')
            ->leftjoin('lead_source', 'lead_source.lead_source_id', '=', 'customer.lead_source_id')
            ->leftjoin('lead_status', 'lead_status.lead_status_id', '=', 'customer.lead_status_id')
            ->leftjoin('branch', 'branch.branch_id', '=', 'customer.branch_id')
            ->where('customer.status', '!=', 2)
            ->orderBy('customer.customer_id', 'desc');

        if (isset($id) && $id > 0) {
            $customers = $customers->where('customer.branch_id', $id);
        }

        $search_input = $request->input('search_input', '');
        if (isset($search_input)) {
            // return $search_input;
            $customers->where(function ($query) use ($search_input) {
                $query->where('customer.customer_first_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_last_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_email', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_phone', 'LIKE', "%{$search_input}%")
                    ->orWhere('branch.branch_name', 'LIKE', "%{$search_input}%");
            });
        }
        // return $customers->get();
        $page  = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default limit
        // Get the total count for pagination
        $total = $customers->count();
        $customers = $customers->skip(($page - 1) * $limit)->take($limit)->get();



        $customer = [];
        foreach ($customers as $val) {

            $count = CustomerTreatment::where('progress', '0')->where('customer_id', $val['customer_id'])->get();



            $customer[] = [
                'customer_id' => $val['customer_id'],
                'customer_first_name' => $val['customer_first_name'],
                'customer_last_name' => $val['customer_last_name'],
                'customer_phone' => $val['customer_phone'],
                'customer_email' => $val['customer_email'],
                'customer_address' => $val['customer_address'],
                'lead_source_id' => $val['lead_source_id'],
                'lead_source_name' => $val['lead_source_name'],
                'lead_status_id' => $val['lead_status_id'],
                'lead_status_name' => $val['lead_status_name'],
                'customer_problem' => $val['customer_problem'],
                'enquiry_date' => $val['enquiry_date'],
                'branch_name' => $val['branch_name'],
                'status' => $val['status'],
                'count' => count($count),
                'treament_details' => $count,
                'branch_id' => $val['branch_id']

            ];
        }


        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $customer,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ], 200);
    }
    public function All($id, Request $request)
    {

        $customers = Customer::select('customer.customer_id', 'customer.customer_first_name', 'customer.customer_last_name', 'customer.customer_phone', 'customer.customer_email', 'customer.customer_address', 'lead_source.lead_source_id', 'lead_source.lead_source_name', 'lead_status.lead_status_id', 'lead_status.lead_status_name', 'customer.customer_problem', 'customer.enquiry_date', 'customer.status', 'customer.branch_id', 'branch.branch_name')
            ->leftjoin('treatment', 'treatment.treatment_id', '=', 'customer.treatment_id')
            ->leftjoin('lead_source', 'lead_source.lead_source_id', '=', 'customer.lead_source_id')
            ->leftjoin('lead_status', 'lead_status.lead_status_id', '=', 'customer.lead_status_id')
            ->leftjoin('branch', 'branch.branch_id', '=', 'customer.branch_id')
            ->where('customer.status', '!=', 2)
            ->orderBy('customer.customer_first_name', 'ASC');
        //->get();




        if (isset($id)) {
            if ($id > 0) {
                $customers = $customers->where('customer.branch_id', $id);
            }
        }

        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();



        // if($branch->role_id != 1){
        //     $customers = $customers->where('customer.branch_id',$branch->branch_id);
        // }

        $customers = $customers->get();


        $customer = [];
        foreach ($customers as $val) {

            $count = CustomerTreatment::where('progress', '0')->where('customer_id', $val['customer_id'])->get();



            $customer[] = [
                'customer_id' => $val['customer_id'],
                'customer_first_name' => $val['customer_first_name'],
                'customer_last_name' => $val['customer_last_name'],
                'customer_phone' => $val['customer_phone'],
                'customer_email' => $val['customer_email'],
                'customer_address' => $val['customer_address'],
                'lead_source_id' => $val['lead_source_id'],
                'lead_source_name' => $val['lead_source_name'],
                'lead_status_id' => $val['lead_status_id'],
                'lead_status_name' => $val['lead_status_name'],
                'customer_problem' => $val['customer_problem'],
                'enquiry_date' => $val['enquiry_date'],
                'status' => $val['status'],
                'count' => count($count),
                'treament_details' => $count,
                'branch_id' => $val['branch_id']

            ];
        }


        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $customer,
        ], 200);
    }
    public function Add(Request $request, $id)
    {
            $lead = Lead::find($id);
            if (!$lead) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Lead not found',
                ], 404);
            }


            $customer = Customer::create([
                'branch_id' => $lead->branch_id,
                'staff_id' => $lead->staff_id,
                'customer_first_name' => $lead->lead_first_name,
                'customer_last_name' => $lead->lead_last_name,
                'customer_dob' => $lead->lead_dob,
                'customer_gender' => $lead->lead_gender,
                'customer_age' => $lead->lead_age,
                'customer_phone' => $lead->lead_phone,
                'customer_email' => $lead->lead_email,
                'customer_address' => $lead->lead_address,
                'treatment_id' => $lead->treatment_id ?? 4,
                'enquiry_date' => $lead->enquiry_date,
                'lead_status_id' => $lead->lead_status_id,
                'lead_source_id' => $lead->lead_source_id,
                'customer_problem' => $lead->lead_problem,
                'customer_remark' => $lead->lead_remarks,
                'sitting_count' => 1,
                'created_by' => $lead->created_by,
                'created_on' => $lead->created_on,
                'modified_by' => $lead->modified_by,
                'modified_on' => $lead->modified_on,
                'status' => $lead->status,
                'state_id' => $lead->state_id ?? 0
            ]);

            $lead->convert_status = 1;
            $lead->save();

            return response()->json([
                'status' => 200,
                'message' => 'Customer has been created successfully'
            ]);
    }
    // public function Add(Request $request, $id)
    // {

    //     $lead = Lead::where('lead_id', $id)->first();

    //     if ($lead) {


    //         $name  = $request->brand_name;

    //         $add_customer   = new Customer;

    //         $add_customer->branch_id           = $lead->branch_id;
    //         $add_customer->staff_id            = $lead->staff_id;
    //         $add_customer->customer_first_name = $lead->lead_first_name;
    //         $add_customer->customer_last_name  = $lead->lead_last_name;
    //         $add_customer->customer_dob        = $lead->lead_dob;
    //         $add_customer->customer_gender     = $lead->lead_gender;
    //         $add_customer->customer_age        = $lead->lead_age;
    //         $add_customer->customer_phone      = $lead->lead_phone;
    //         $add_customer->customer_email      = $lead->lead_email;
    //         $add_customer->customer_address    = $lead->lead_address;
    //         $add_customer->treatment_id        = $lead->treatment_id;
    //         $add_customer->enquiry_date        = $lead->enquiry_date;
    //         $add_customer->lead_status_id      = $lead->lead_status_id;
    //         $add_customer->lead_source_id      = $lead->lead_source_id;
    //         $add_customer->customer_problem    = $lead->lead_problem;
    //         $add_customer->customer_remark     = $lead->lead_remarks;
    //         $add_customer->sitting_count       = 1;
    //         $add_customer->created_by          = $lead->created_by;
    //         $add_customer->created_on          = $lead->created_on;
    //         $add_customer->modified_by         = $lead->modified_by;
    //         $add_customer->modified_on         = $lead->modified_on;
    //         $add_customer->status              = $lead->status;
    //         $add_customer->state_id             = $lead->state_id;


    //         $add_customer->save();

    //         if ($add_customer) {

    //             $lead->convert_status = 1;
    //             $lead->update();

    //             $result =   response([
    //                 'status'    => 200,
    //                 'message'   => 'Customer has been created successfully',
    //                 'error_msg' => null,
    //                 'data'      => null,
    //             ], 200);
    //         } else {

    //             $result =   response([
    //                 'status'    => 401,
    //                 'message'   => 'Brand can not be created',
    //                 'error_msg' => 'Brand information is worng please try again',
    //                 'data'      => null,
    //             ], 401);
    //         }
    //     } else {
    //         $result =   response([
    //             'status'    => 401,
    //             'message'   => 'Data not found',
    //             'error_msg' => "Data not found",
    //             'data'      => null,
    //         ], 401);
    //     }


    //     return $result;
    // }

   public function edit($id)
    {
        // Get customer with related data
        $customer = Customer::with(['branch', 'staff', 'state'])
            ->findOrFail($id);

        // Get appointments
        $appointments = Appointment::with(['staff', 'treatment'])
            ->where('customer_id', $id)
            ->get();

        // Get treatments with payment info
        $customerTreatments = CustomerTreatment::with(['treatment', 'category', 'customer'])
            ->where('customer_id', $id)
            ->get()
            ->map(function ($t) {
                $discount = Payment::where('customer_id', $t->customer_id)
                    ->where('treatment_id', $t->treatment_id)
                    ->sum('discount');
                $paid = Payment::where('customer_id', $t->customer_id)
                    ->where('treatment_id', $t->treatment_id)
                    ->sum('amount');

                return [
                    'customer_id' => $t->customer_id,
                    'treatment_auto_id' => $t->treatment_auto_id,
                    'complete_status' => $t->complete_status,
                    'invoice_no' => $t->invoice_no ?? null,
                    'customer_first_name' => $t->customer->customer_first_name,
                    'treatment_id' => $t->treatment_id,
                    'treatment_name' => $t->treatment->treatment_name,
                    'tcategory_id' => $t->tc_id,
                    'tc_name' => $t->category->tc_name,
                    'medicine_prefered' => $t->medicine_prefered,
                    'remarks' => $t->remarks,
                    'amount' => $t->amount,
                    'discount' => $discount,
                    'paid_amount' => $paid,
                    'balance' => $t->amount - ($discount + $paid),
                ];
            });

        // Get payments
        $payments = Payment::where('customer_id', $id)->get();

        $companydetails = Company::first();
        $Branchs = Branch::where('status','!=',2)->get();
        $Staffs = Staff::where('status','!=',2)->get();

        // Pass data to Blade
        return view('edit_customer', compact('companydetails','Staffs','Branchs','customer', 'appointments', 'customerTreatments', 'payments'));
    }

    public function Update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            // 'customer_phone' => 'required|unique:customer,customer_phone,'.$id.',customer_id|max:255',
            // 'customer_email' => 'required|unique:customer,customer_email,'.$id.',customer_id|max:255',
        ]);

        if ($validator->fails()) {
            $result =  response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {
            $upd_customer = Customer::find($id);

            $upd_customer->branch_id           = $request->branch_id;
            $upd_customer->staff_id            = $request->staff_id;
            $upd_customer->customer_first_name = $request->customer_first_name;
            $upd_customer->customer_last_name  = $request->customer_last_name;
            $upd_customer->customer_dob        = $request->customer_dob;
            $upd_customer->customer_gender     = $request->customer_gender;
            $upd_customer->customer_age        = $request->customer_age;
            $upd_customer->customer_phone      = $request->customer_phone;
            $upd_customer->customer_email      = $request->customer_email;
            $upd_customer->customer_address    = $request->customer_address;
            $upd_customer->treatment_id        = $request->treatment_id;
            $upd_customer->lead_status_id      = $request->lead_status_id;
            $upd_customer->lead_source_id      = $request->lead_source_id;
            $upd_customer->customer_problem    = $request->customer_problem;
            $upd_customer->customer_remark     = $request->customer_remarks;
            $upd_customer->sitting_count       = 1;
            $upd_customer->state_id            = $request->state_id;
            $upd_customer->update();

            $result = response([
                'status'    => 200,
                'message'   => 'successfull updated',
                'error_msg' => null,
                'data'      => $upd_customer,
            ], 200);
        }

        return $result;
    }


    public function Delete($id)
    {
        $status = Customer::where('customer_id', $id)->first();
        if ($status) {
            $status->status = 2;
            $status->update();
        }
        return response([
            'data' => null,
            'message' => 'Successfully Delete',
            'status' => 200
        ], 200);
    }

    public function Status(Request $request, $id)
    {

        $customer_status = Customer::where('customer_id', $id)->first();

        if ($customer_status) {
            $customer_status->status = $request->status;
            $customer_status->update();
        } else {
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }

        return response([
            'data' => null,
            'message' => 'Successfully Updated',
            'status' => 200
        ], 200);
    }

    public function Search(Request $request, $id)
    {

        $customers = Customer::where('status', '!=', 2)
            ->where('customer_phone', '=', $id)->get();


        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => $id,
            'data'      => $customers,
        ], 200);
    }
}