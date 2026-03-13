<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Billing;
use App\Models\CustomerTreatment;
use App\Models\AppointmentPayment;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Models\ProductCategory;
use App\Models\Staff;
use FFI\CData;
use App\Models\Notification;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{

     public function billingIndex(Request $request)
    {
        $branches = Branch::where('status','!=',2)->get();
        // Get staff ID of authen'ticated user
        $staff_id = $request->user()->staff_id;

        if (!$staff_id) {
            abort(403, 'No valid staff ID found.');
        }

        // Get branch IDs assigned to the staff
        $branch_ids_raw = Staff::where('staff_id', $staff_id)->pluck('branch_id')->first();

        // Convert branch IDs to array safely
        if (!$branch_ids_raw) {
            abort(403, 'No branch found for staff.');
        }

        $branch_ids_array = json_decode($branch_ids_raw, true);

        // If decoding fails (maybe it's a comma-separated string), convert to array
        if (!is_array($branch_ids_array)) {
            $branch_ids_array = explode(',', $branch_ids_raw);
        }

        // Ensure array is not empty
        if (empty($branch_ids_array)) {
            abort(403, 'No valid branch IDs found.');
        }

        // Load all billings for these branches
        $billings = Billing::with(['customer', 'lead', 'branch'])
            ->whereHas('customer', function ($query) use ($branch_ids_array) {
                $query->whereIn('branch_id', $branch_ids_array);
            })
            ->where('status', '!=', 2) // Exclude deleted or inactive
            ->orderBy('billing_id', 'desc')
            ->get();

        // Pass billings to Blade

        // echo "<pre>";
        // print_r($billings);
        // exit;

        return view('billing', compact('billings','branches'));
    }
    public function AddBillingView()
    {

        $customers = CustomerTreatment::select('customer.customer_id', 'customer.customer_first_name', 'customer.customer_last_name', 
        'customer.customer_phone', 'customer.status')
        ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
        ->distinct('customer_treatment.customer_id')
        ->where('customer.status', '!=', 2)->get();

        $productcategorys = ProductCategory::where('status','!=',2)->get();

        $products = Product::where('status','!=',2)->get();
         $treatmentCategories = TreatmentCategory::where('status','!=', 2)->get();

        return view('add_billing',compact(
            'customers',
            'productcategorys',
            'treatmentCategories',
            'products'
        ));
    }
    public function editBilling($id)
    {
        $billing = Billing::with('customer')->find($id);

        if (!$billing) {
            return redirect()->back()->with('error', 'Billing record not found.');
        }

        // Decode JSON IDs
        $treatmentIds = json_decode($billing->treatment_id, true) ?? [];
        $productIds = json_decode($billing->product_id, true) ?? [];

        // Get Treatments
        $billingTreatments = Treatment::whereIn('treatment_id', $treatmentIds)
            ->select('treatment_id','treatment_name','amount')
            ->get();

        // Get Products
        $billingProducts = Product::whereIn('product_id', $productIds)
            ->select('product_id','product_name','amount')
            ->get();

        // Customers
        $customers = CustomerTreatment::select(
                'customer.customer_id',
                'customer.customer_first_name',
                'customer.customer_last_name',
                'customer.customer_phone',
                'customer.status'
            )
            ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
            ->distinct()
            ->where('customer.status', '!=', 2)
            ->get();

        // Categories
        $productcategorys = ProductCategory::where('status','!=',2)->get();
        $products = Product::where('status','!=',2)->get();
        $treatmentCategories = TreatmentCategory::where('status','!=', 2)->get();

        return view('edit_billing', compact(
            'customers',
            'billing',
            'billingTreatments',
            'billingProducts',
            'productcategorys',
            'treatmentCategories',
            'products'
        ));
    }
   public function BalancePay($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_amount' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 401,
                'message' => 'Incorrect format input fields',
                'error_msg' => $validator->errors(),
                'data' => null
            ], 401);
        }

        $billingdata = Billing::where('billing_id', $id)->first();

        if (!$billingdata) {
            return response([
                'status' => 404,
                'message' => 'Billing not found'
            ]);
        }

        $staff = Staff::where('staff_id', $request->user()->staff_id)->first();

        $branch_ids = json_decode($staff->branch_id, true);
        $first_branch_id = $branch_ids[0] ?? null;

        if (!$first_branch_id) {
            return response([
                'status' => 401,
                'message' => 'Branch ID missing'
            ]);
        }

        $branch_code = Branch::where('branch_id', $first_branch_id)->value('branch_code');

        $paid_amount = (float)$request->payment_amount;

        // Prevent over payment
        if ($paid_amount > $billingdata->balance_amount) {
            return response([
                'status' => 401,
                'message' => 'Payment exceeds balance amount'
            ]);
        }

        DB::beginTransaction();

        try {

            $lastBilling = Billing::whereNotNull('invoice_no')
                ->orderBy('billing_id', 'desc')
                ->first();

            $lastpayment = Payment::orderBy('p_id', 'desc')->first();

            $year = date("y");

            // Receipt Number
            if (!$lastpayment) {
                $receipt_no = $branch_code . '/RP0001/' . $year;
            } else {
                $slice = explode("/", $lastpayment->receipt_no);
                $last_number = preg_replace('/[^0-9]/', '', $slice[1]);
                $next = (int)$last_number + 1;
                $receipt_no = $branch_code . '/' . sprintf("RP%04d", $next) . '/' . $year;
            }

            // Invoice Number
            if (!$lastBilling) {
                $invoice_no = $branch_code . '/IN0001/' . $year;
            } else {
                $slice = explode("/", $lastBilling->invoice_no);
                $last_number = preg_replace('/[^0-9]/', '', $slice[1]);
                $next = (int)$last_number + 1;
                $invoice_no = $branch_code . '/' . sprintf("IN%04d", $next) . '/' . $year;
            }

            $balance = $billingdata->balance_amount - $paid_amount;

            $payment = new Payment([
                'payment_date' => date("Y-m-d"),
                'customer_id' => $billingdata->customer_id,
                'invoice_no' => $paid_amount >= $billingdata->balance_amount ? $invoice_no : null,
                'receipt_no' => $receipt_no,
                'lead_id' => $billingdata->lead_id,
                'discount_type' => $billingdata->discount_type,
                'discount_amount' => $billingdata->discount_amount,
                'treatment_id' => $billingdata->treatment_id,
                'product_id' => $billingdata->product_id,
                'treatment_amount' => $billingdata->treatment_amount,
                'product_amount' => $billingdata->product_amount,
                'cgst' => $billingdata->cgst,
                'sgst' => $billingdata->sgst,
                'amount' => $paid_amount,
                'total_amount' => $billingdata->total_amount,
                'balance' => $balance,
                'payment_status' => $balance <= 0 ? 1 : 0,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id
            ]);

            $payment->save();

            // Update billing
            $billingdata->paid_amount += $paid_amount;
            $billingdata->balance_amount -= $paid_amount;

            if ($billingdata->balance_amount <= 0) {
                $billingdata->status = 1;
                $billingdata->invoice_no = $invoice_no;
            }

            $billingdata->save();

            DB::commit();

            return response([
                'status' => 200,
                'message' => 'Payment added successfully',
                'data' => $payment
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
    // public function All(Request $request){
    //     $branch_id = $request->branch_id;
    //     $page = $request->input('page', 1); // Default to page 1
    //     $limit = $request->input('limit', 10); // Default limit
    //     $payment = Payment::select('payment.p_id','payment.receipt_no','payment.invoice_no','payment.payment_date','payment.sitting_count','payment.amount','payment.total_amount','payment_status','treatment_category.tcategory_id','treatment_category.tc_name','treatment.treatment_id','treatment.treatment_name','customer.customer_id','customer.customer_first_name','customer.customer_phone','payment.status','payment.balance','customer.branch_id')
    //     ->join('treatment_category','treatment_category.tcategory_id','=','payment.tcate_id')
    //     ->join('treatment','treatment.treatment_id','=','payment.treatment_id')
    //     ->join('customer', 'customer.customer_id','=','payment.customer_id')
    //     ->where('payment.status', '!=', 2)
    //     ->orderBy('payment.p_id','DESC');


    //     if(isset($branch_id)){
    //         if($branch_id > 0){
    //             $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
    //             $payment = $payment->where('customer.branch_id',$idArray);
    //         } 
    //      } 
    //     if($request->tc_id > 0){
    //         $payment = $payment->where('payment.tcate_id',$request->tc_id);
    //     }

    //     if($request->t_id > 0){
    //         $payment = $payment->where('customer.treatment_id',$request->t_id);
    //     }
    //     $payment = $payment->get();
    //     // Get the total count for pagination
    //     $total = $payment->count();

    //     // Get the payments with pagination
    //     $payment = $payment->skip(($page - 1) * $limit)->take($limit)->get();
    //     $payment_ids = Payment::select('p_id','receipt_no','invoice_no')->orderBy('p_id', 'desc')->first();

    //     return response([
    //                         'status'    => 200,
    //                         'message'   => 'Success',
    //                         'error_msg' => null,
    //                         'data'      => $payment ,
    //                         'numbers'   => $payment_ids,
    //                         'total' => $total, // Send back total count
    //                     ],200);

    // }
    public function All(Request $request)
    {
        // Get the authenticated user's staff_id
        $staff_id = $request->user()->staff_id; // Assuming this is a single staff ID
        // return $staff_id;
        // Ensure staff_id is not null or empty
        if (empty($staff_id)) {
            return response()->json(['error' => 'No valid staff ID found.'], 400);
        }

        // Retrieve the corresponding branch_ids for the given staff_id
        $branch_ids = Staff::where('staff_id', $staff_id)->pluck('branch_id')->unique();

        // Decode the branch_id JSON string to an array
        $branch_ids_array = json_decode($branch_ids->first(), true);
        // return $branch_ids_array;
        // If no branch_id is provided in the request, default to the first one from the retrieved list
        $branch_id = $request->input('branch_id') ?? ($branch_ids_array ? $branch_ids_array : null);
        // return $branch_id;
        // Handle case where no branch_id is found
        if (is_null($branch_id)) {
            return response()->json(['error' => 'No branch ID found.'], 400);
        }

        // $branch_id = $request->user()->branch_id;
        $page = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default limit

        // Start building the query
        $paymentQuery = Billing::select(
            'billing.billing_id',
            'billing.receipt_no',
            'billing.billing_no',
            'billing.invoice_no',
            'billing.payment_date',
            'billing.paid_amount',
            'billing.total_amount',
            'customer.customer_id',
            'lead.lead_id',
            'lead.lead_phone',
            'lead.lead_first_name',
            'lead.lead_last_name',
            'customer.customer_first_name',
            'customer.customer_last_name',
            'customer.customer_email',
            'customer.customer_phone',
            'billing.status',
            'billing.balance_amount',
            'customer.branch_id',
            'branch.branch_name'
        )
            // ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'billing.tcate_id')
            // ->join('treatment', 'treatment.treatment_id', '=', 'billing.treatment_id')
            ->leftjoin('customer', 'customer.customer_id', '=', 'billing.customer_id')
            ->leftjoin('branch', 'branch.branch_id', '=', 'customer.branch_id')
            ->leftjoin('lead', 'lead.lead_id', '=', 'billing.lead_id')
            ->where('billing.status', '!=', 2)
            ->orderBy('billing.billing_id', 'desc');

        // Apply filters based on the request
        if (isset($branch_id) && $branch_id > 0) {
            $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
            $paymentQuery->whereIn('customer.branch_id', $idArray);
        }

        $search_input = $request->input('search_input', '');
        if (isset($search_input)) {
            // return $search_input;
            $paymentQuery->where(function ($query) use ($search_input) {
                $query->where('customer.customer_first_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('billing.receipt_no', 'LIKE', "%{$search_input}%")
                    ->orWhere('billing.billing_no', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_last_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_email', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_phone', 'LIKE', "%{$search_input}%")
                    ->orWhere('branch.branch_name', 'LIKE', "%{$search_input}%");
            });
        }

        // if ($request->tc_id > 0) {
        //     $paymentQuery->where('payment.tcate_id', $request->tc_id);
        // }

        // if ($request->t_id > 0) {
        //     $paymentQuery->where('customer.treatment_id', $request->t_id);
        // }

        // Get the total count for pagination
        $total = $paymentQuery->count();

        // Get the payments with pagination
        $payments = $paymentQuery->skip(($page - 1) * $limit)->take($limit)->get();

        // $payment_ids = Payment::select('p_id', 'receipt_no', 'invoice_no')->orderBy('p_id', 'desc')->first();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'error_msg' => null,
            'data' => $payments,
            // 'numbers' => $payment_ids,
            'total' => $total, // Send back total count
        ], 200);
    }


    public function Customer()
    {
        $customers = CustomerTreatment::select('customer.customer_id', 'customer.customer_first_name', 'customer.customer_last_name', 'customer.customer_phone', 'customer.status', 'customer.state_id')->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')->distinct('customer_treatment.customer_id')->where('customer.status', '!=', 2)->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $customers,

        ], 200);
    }

    public function TreatmenCategory($id)
    {

        // $payment_ = Payment::where('customer_id','=',$id)->get;
        $treatment_cat = CustomerTreatment::where('customer_treatment.customer_id', $id)
            ->where('customer_treatment.progress', '!=', 1)
            ->get();

        $treatment_res = [];
        foreach ($treatment_cat as $val) {

            $payment = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->orderBy('payment.p_id', 'DESC')->first();
            $treatment = Treatment::where('treatment_id', $val['treatment_id'])->first();

            $cus = Customer::where('customer_id', $id)->first();

            if ($payment) {
                $total_discount   = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->sum('discount');
                $total_pay_amount = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->sum('amount');



                $treatment_res[] = [
                    'amount' => $payment->total_amount,
                    'discount' =>  $total_discount,
                    'balance' => $payment->balance,
                    'pay_amount' => $total_pay_amount,
                    'treatment_id' => $val['treatment_id'],
                    'treatment_name' => $treatment->treatment_name,
                    'tc_id'     => $val['tc_id'],
                    'status' => $val['status'],
                    'state_id' => $cus ? $cus->state_id : '',
                    'cus_treat_id' => $val['cus_treat_id']

                ];
            } else {
                $treatment_res[]  = [
                    'amount' => $val['amount'],
                    'discount' => 0,
                    'pay_amount' => 0,
                    'balance' => $val['amount'],
                    'treatment_id' => $val['treatment_id'],
                    'treatment_name' =>  $treatment->treatment_name,
                    'tc_id'     => $val['tc_id'],
                    'status' => $val['status'],
                    'state_id' => $cus ? $cus->state_id : '',
                    'cus_treat_id' => $val['cus_treat_id']
                ];
            }
        }


        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $treatment_res,
            'payment'    => $treatment_res,

        ], 200);
    }


    public function getBillingDetails($id)
    {
        // Find the billing record by ID
        $billing = Billing::find($id);

        if (!$billing) {
            return response()->json([
                'status' => 404,
                'message' => 'Billing record not found'
            ], 404);
        }

        // Calculate remaining amount (total amount - paid amount)
        $totalAmount = $billing->total_amount;
        $paidAmount = $billing->paid_amount;
        $remainingAmount = $billing->balance_amount;

        // Prepare data for response
        $details = [
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Billing details retrieved successfully',
            'details' => $details
        ]);
    }
    public function Treatment(Request $request, $id)
    {
        $treatment = CustomerTreatment::where('customer_treatment.customer_id', $request->c_id)->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')->where('customer_treatment.tc_id', $id)->get();
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $treatment,

        ], 200);
    }
    public function TreatmentcategoryAll()
    {

        $treatment_cat = TreatmentCategory::where('status', '!=', 2)->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $treatment_cat,
        ], 200);
    }
    public function TreatmentAll(Request $request, $id)
    {


        // $cat_id = $request->tc_id;

        // return $id;
        $treatment = Treatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'treatment.amount', 'treatment.status')
            ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'treatment.tc_id')
            ->where('treatment.status', '!=', 2)
            ->where('treatment.tc_id', $id);

        if (isset($request->id)) {
            $treatment = $treatment->where('treatment.tc_id', $id);
        }
        // $treatment->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $treatment->get(),
        ], 200);
    }
    public function InvoiceGenerator(Request $request)
    {

        $user_check = Payment::where('customer_id', $request->customer_id)->where('tcate_id', $request->tcategory_id)->orderBy('created_on', 'DESC')->first();

        if ($user_check) {
            $invoice_check = Payment::where('customer_id', $request->customer_id)->where('tcate_id', $request->tcategory_id)->first();

            if ($invoice_check) {

                $invoice = Payment::where('customer_id', $request->customer_id)
                    ->where('treatment_id', $request->treatment_id)->where('tcate_id', $request->tcategory_id)->orderBy('created_on', 'DESC')->get();

                $used = null;
                if (count($invoice) > 0) {
                    $INVOICE_NO = Payment::select('p_id', 'receipt_no', 'invoice_no', 'balance')->where('customer_id', $request->customer_id)->where('treatment_id', $request->treatment_id)->where('tcate_id', $request->tcategory_id)->orderBy('p_id', 'desc')->first();

                    $count = count($invoice) + 1;
                    $used = 'used';
                    $balance = 'balance';
                } else {
                    $INVOICE_NO = Payment::select('p_id', 'receipt_no', 'invoice_no', 'balance')->where('customer_id', $request->customer_id)->orderBy('p_id', 'desc')->first();
                    $count = 1;
                }
            } else {

                $INVOICE_NO = null;
                $count = 1;
                $used = null;
                $balance = 'balance';
            }
        } else {

            $INVOICE_NO = Payment::orderBy('invoice_no', 'DESC')->first();
            $count = 1;
            $used = 'new';
            $balance = null;
        }


        $amount = CustomerTreatment::where('tc_id', $request->tcategory_id)->where('treatment_id', $request->treatment_id)->where('customer_id', $request->customer_id)->first();

        return   response([
            'status'    => 200,
            'message'   => 'Invoice Number',
            'error_msg' => null,
            'numbers'      => $INVOICE_NO,
            'sitting_count' => $count,
            'used'    => $used,
            'total_amount'  => $amount->amount,
            'balance'   =>  $balance  ? $INVOICE_NO->balance : $amount->amount,
        ], 200);
    }

    public function Invoice(Request $request)
    {

        $id = $request->c_id;

        $customer = Customer::where('customer_id', $id)->first();

        $branch = Branch::where('branch_id', $customer ? $customer->branch_id : '')->first();

        $treatment_id = $request->treatment_id;
        $data = explode(",", $treatment_id);
        $payments = Payment::where('invoice_no', '!=', null)->get();

        $numbers = [];
        foreach ($payments as $pays) {

            $slice = explode("/", $pays->invoice_no);
            $result = preg_replace('/[^0-9]/', '', $slice[0]);
            $numbers[] = $result;
        }

        rsort($numbers);
        if (count($payments) > 0) {
            $year = substr(date("y"), -2);
            $result = $numbers[0];

            function invoice_num($input, $pad_len = 3, $prefix = null)
            {


                if (is_string($prefix))
                    return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

                return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
            }

            $response =  invoice_num($result + 1, 3, "-IN-");
            $invoice =  $branch->branch_code . $response . '/' . $year;
        } else {

            $year = substr(date("y"), -2);
            $invoice =  $branch->branch_code . '-IN-001/' . $year;
        }


        $result = [];
        foreach ($data as $val) {

            $cus_treatment = CustomerTreatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'customer_treatment.status', 'customer.customer_id', 'customer.customer_first_name', 'customer_treatment.cus_treat_id', 'customer_treatment.progress', 'customer_treatment.medicine_prefered', 'customer_treatment.remarks', 'customer_treatment.amount', 'customer_treatment.discount')
                ->where('customer_treatment.customer_id', $id)
                ->where('customer_treatment.cus_treat_id', $val)
                ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'customer_treatment.tc_id')
                ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')
                ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
                ->where('customer_treatment.status', '!=', 2)
                ->where('customer_treatment.progress', '!=', 0)->first();

            $discount = Payment::where('customer_id', $id)->where('cus_treat_id', $val)->sum('discount');
            $discount_amount = Payment::where('customer_id', $id)->where('cus_treat_id', $val)->sum('discount_amount');



            $invoice_status = CustomerTreatment::where('customer_treatment.cus_treat_id', $val)->first();
            //   return $invoice_status;
            $invoice_status->generate_invoice = 1;

            $invoice_status->update();

            if ($invoice_status) {
                $payments = Payment::where('customer_id', $id)->where('cus_treat_id', $val)->get();

                foreach ($payments as $pay) {

                    $invoice_upd = Payment::where('p_id', $pay->p_id)->first();

                    $invoice_upd->invoice_no = $invoice;

                    $invoice_upd->update();
                }
            }



            $result[] = [

                'treatment_id'       => $cus_treatment->treatment_id,
                'treatment_name'     => $cus_treatment->treatment_name,
                'tcategory_id'       => $cus_treatment->tcategory_id,
                'tc_name'            => $cus_treatment->tc_name,
                'status'             => $cus_treatment->status,
                'customer_id'        => $cus_treatment->customer_id,
                'customer_first_name' => $cus_treatment->customer_first_name,
                'cus_treat_id'       => $cus_treatment->cus_treat_id,
                'progress'           => $cus_treatment->progress,
                'medicine_prefered'  => $cus_treatment->medicine_prefered,
                'remarks'            => $cus_treatment->remarks,
                'amount'             => $cus_treatment->amount,
                'discount'           => $discount,
                'discount_amount'      => $discount_amount,
                'balance'            => 0,

            ];
        }



        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
            'customer'  => $customer,
            'branch'    => $branch,
            'invoice_no' => $invoice

        ], 200);


        // $invoice = Payment::where('c_id',$request->p_id)->first();

        // if($invoice){

        //     $data = Payment::select('payment.p_id','payment.receipt_no','payment.invoice_no','payment.payment_date','payment.sitting_count','payment.amount','payment.total_amount','payment_status','treatment_category.tcategory_id','treatment_category.tc_name','treatment.treatment_id','treatment.treatment_name','customer.customer_id','customer.customer_first_name','customer.customer_phone','customer.customer_email','customer.customer_address','payment.status')
        //                         ->where('invoice_no',$invoice->invoice_no)
        //                         ->join('treatment_category','treatment_category.tcategory_id','=','payment.tcate_id')
        //                         ->join('treatment','treatment.treatment_id','=','payment.treatment_id')
        //                         ->join('customer', 'customer.customer_id','=','payment.customer_id')
        //                         ->get();



        //     $cgst =  Payment::where('invoice_no',$invoice->invoice_no)->sum('cgst');
        //     $sgst =  Payment::where('invoice_no',$invoice->invoice_no)->sum('sgst');
        //     $discount = CustomerTreatment::where('tc_id', $invoice->tcate_id)->where('treatment_id', $invoice->treatment_id)->where('customer_id', $invoice->customer_id)->first();
        //     $total_discount = $discount->discount;




        // $used = null;
        // if(count($invoice) > 0){
        //     $INVOICE_NO = Payment::select('p_id','receipt_no','invoice_no')->where('customer_id',$request->customer_id)->where('treatment_id',$request->treatment_id)->where('tcate_id',$request->tcategory_id)->orderBy('p_id', 'desc')->first();

        //     $count= count($invoice)+1;
        //     $used = 'used';
        // }else{
        //     $INVOICE_NO = Payment::select('p_id','receipt_no','invoice_no')->where('customer_id',$request->customer_id)->orderBy('p_id', 'desc')->first();
        //     $count = 1;

        // }


        // }else{
        //     $data = null;
        //     $total = 0;
        // }




        // return   response([
        //     'status'    => 200,
        //     'message'   => 'Invoice Number',
        //     'error_msg' => null,
        //     'data'      => $data[0],
        //     'cgst'      => $cgst,
        //     'sgst'      => $sgst,
        //     'discount'  => $total_discount,
        // ],200);

    }
    // public function Add(Request $request)
    // {
    //     // Validate request data
    //     $validator = Validator::make($request->all(), [
    //         'payment_date'     => 'required|date',
    //         'discount_amount'  => 'numeric',
    //         'treatment_amount' => 'numeric',
    //         'product_amount'   => 'numeric',
    //         'cgst'             => 'numeric',
    //         'sgst'             => 'numeric',
    //         'igst'             => 'numeric',
    //         'total_amount'     => 'numeric',
    //         'cash'             => 'numeric',
    //         'card'             => 'numeric',
    //         'cheque'           => 'numeric',
    //         'upi'              => 'numeric',
    //     ]);

    //     // return $request;
    //     // return $request;
    //     if ($validator->fails()) {
    //         return response([
    //             'status'    => 401,
    //             'message'   => 'Incorrect format input fields',
    //             'error_msg' => $validator->errors(),
    //             'data'      => null,
    //         ], 401);
    //     }
    //     $staff = Staff::where('staff_id', $request->user()->staff_id)->first();
    //     // Assuming branch_id is stored as a JSON array in the database
    //     // Decode the JSON array to get branch IDs
    //     $branch_ids = json_decode($staff->branch_id, true); // Use true to decode as an associative array
    //     // return $branch_ids;
    //     // Check if the branch_ids array is not empty and access the first branch ID
    //     $first_branch_id = isset($branch_ids[1]) ? $branch_ids[1] : null;


    //     if ($first_branch_id) {
    //         $branch_code = Branch::where('branch_id', $first_branch_id)->first()->branch_code ?? '';

    //         // Calculate total paid amount
    //         $paid_amount = $request->cash + $request->card + $request->cheque + $request->upi;

    //         $payment_modes = [
    //             'cash'   => $request->cash ?? 0,
    //             'card'   => $request->card ?? 0,
    //             'cheque' => $request->cheque ?? 0,
    //             'upi'    => $request->upi ?? 0,
    //         ];


    //         if ($paid_amount > 0) {
    //             $lastBilling = Billing::orderBy('billing_id', 'desc')->first();
    //             $year = substr(date("y"), -2);

    //             // Generate receipt number
    //             if (!$lastBilling) {
    //                 $receipt_no = $branch_code . '/' . "RP0001" . '/' . $year;
    //             } else {
    //                 $data = $lastBilling->receipt_no;  // Get last receipt_no
    //                 $slice = explode("/", $data);
    //                 $last_receipt_number = isset($slice[1]) ? preg_replace('/[^0-9]/', '', $slice[1]) : 0;
    //                 $next_receipt_number = (int)$last_receipt_number + 1;
    //                 $formatted_receipt_number = sprintf("RP%04d", $next_receipt_number);
    //                 $receipt_no = $branch_code . '/' . $formatted_receipt_number . '/' . $year;
    //             }

    //             // Generate billing number
    //             if (!$lastBilling) {
    //                 $billing_no = $branch_code . '/' . "BI0001" . '/' . $year;
    //             } else {
    //                 $data = $lastBilling->billing_no;  // Get last billing_no
    //                 $slice = explode("/", $data);
    //                 $last_billing_number = isset($slice[1]) ? preg_replace('/[^0-9]/', '', $slice[1]) : 0;
    //                 $next_billing_number = (int)$last_billing_number + 1;
    //                 $formatted_billing_number = sprintf("BI%04d", $next_billing_number);
    //                 $billing_no = $branch_code . '/' . $formatted_billing_number . '/' . $year;
    //             }

    //             // Generate invoice number
    //             if (!$lastBilling) {
    //                 $invoice_no = $branch_code . '/' . "IN0001" . '/' . $year;
    //             } else {
    //                 $data = $lastBilling->invoice_no;  // Get last invoice_no
    //                 $slice = explode("/", $data);
    //                 $last_invoice_number = isset($slice[1]) ? preg_replace('/[^0-9]/', '', $slice[1]) : 0;
    //                 $next_invoice_number = (int)$last_invoice_number + 1;
    //                 $formatted_invoice_number = sprintf("IN%04d", $next_invoice_number);
    //                 $invoice_no = $branch_code . '/' . $formatted_invoice_number . '/' . $year;
    //             }

    //             $treatment_ids_combined = array_merge($request->treatment_ids, $request->treatment_ids_cus);
    //             // Prepare the billing record
    //             $billing = new Billing([
    //                 'payment_date'      => $request->payment_date,
    //                 'customer_id'       => $request->customer_id,
    //                 'invoice_no'        => $paid_amount >= $request->total_amount ? $invoice_no : null,
    //                 'billing_no'        => $billing_no,
    //                 'receipt_no'        => $receipt_no,
    //                 'lead_id'           => $request->lead_id,
    //                 'discount_type'     => $request->discount_type,
    //                 'discount_amount'   => $request->discount_amount,
    //                 'treatment_id'         => json_encode($treatment_ids_combined),
    //                 'product_category_id' => $request->product_category_id,
    //                 'treatment_category_id' => $request->treatment_category_id,
    //                 'product_id'        => json_encode($request->product_ids),
    //                 'treatment_amount'  => $request->treatment_amount,
    //                 'product_amount'    => $request->product_amount,
    //                 'cgst'              => $request->cgst,
    //                 'sgst'              => $request->sgst,
    //                 'igst'              => $request->igst,
    //                 'total_amount'      => $request->total_amount,
    //                 'paid_amount'       => $paid_amount,
    //                 'balance_amount'    => $request->total_amount - $paid_amount,
    //                 'payment_status'    => $paid_amount >= $request->total_amount ? '1' : '0',
    //                 'payment_mode'      => json_encode($payment_modes), // Save as JSON
    //                 'created_by'        => $request->user()->id,
    //                 'updated_by'        => $request->user()->id,
    //             ]);

    //             $billing->save();

    //             if ($billing) {
    //                 $payment = new Payment([
    //                     'payment_date'      => date("Y-m-d"), // need current date 
    //                     'customer_id'       => $billing->customer_id,
    //                     'invoice_no'        => $paid_amount >= $billing->balance_amount ? $invoice_no : null,
    //                     'receipt_no'        => $receipt_no,
    //                     'lead_id'           => $billing->lead_id,
    //                     'discount_type'     => $billing->discount_type,
    //                     'discount_amount'   => $billing->discount_amount,
    //                     'treatment_id'      => $billing->treatment_id,
    //                     'product_id'        => $billing->product_id,
    //                     'treatment_amount'  => $request->treatment_amount,
    //                     'product_amount'    => $request->product_amount,
    //                     'cgst'              => $billing->cgst,
    //                     'sgst'              => $billing->sgst,
    //                     'amount'            => $paid_amount,
    //                     'total_amount'      => $billing->total_amount,
    //                     'balance'           => $billing->total_amount - $paid_amount,
    //                     'payment_status'    => $paid_amount >= $billing->balance_amount ? '1' : '0',
    //                     'payment_mode'      => json_encode($payment_modes),
    //                     'created_by'        => $request->user()->id,
    //                     'updated_by'        => $request->user()->id,
    //                 ]);

    //                 $payment->save();
    //             }
    //             return response([
    //                 'status'    => 200,
    //                 'message'   => 'Billing created successfully',
    //                 'data'      => $billing,
    //             ]);
    //         } else {
    //             return response([
    //                 'status'    => 401,
    //                 'message'   => 'Billing cannot be created',
    //                 'error_msg' => 'Please ensure the payment amount is greater than zero',
    //                 'data'      => null,
    //             ], 200);
    //         }
    //     } else {
    //         return response([
    //             'status'    => 401,
    //             'message'   => 'Branch ID is missing',
    //             'error_msg' => 'No branch ID found for the staff',
    //             'data'      => null,
    //         ], 401);
    //     }
    // }
public function Add(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'payment_date'     => 'required|date',
        'discount_amount'  => 'numeric',
        'treatment_amount' => 'numeric',
        'product_amount'   => 'numeric',
        'cgst'             => 'numeric',
        'sgst'             => 'numeric',
        'igst'             => 'numeric',
        'total_amount'     => 'numeric',
        'cash'             => 'numeric',
        'card'             => 'numeric',
        'cheque'           => 'numeric',
        'upi'              => 'numeric',
    ]);

    if ($validator->fails()) {
        return response([
            'status'    => 401,
            'message'   => 'Incorrect format input fields',
            'error_msg' => $validator->errors(),
            'data'      => null,
        ], 401);
    }

    $staff = Staff::where('staff_id', $request->user()->staff_id)->first();
    $branch_ids = json_decode($staff->branch_id, true) ?? [];
    $first_branch_id = $branch_ids[1] ?? null;

    if (!$first_branch_id) {
        return response([
            'status'    => 401,
            'message'   => 'Branch ID is missing',
            'error_msg' => 'No branch ID found for the staff',
            'data'      => null,
        ], 401);
    }

    $branch_code = Branch::where('branch_id', $first_branch_id)->first()->branch_code ?? '';

    // Calculate total paid amount
    $paid_amount = floatval($request->cash) + floatval($request->card) + floatval($request->cheque) + floatval($request->upi);

    if ($paid_amount <= 0) {
        return response([
            'status'    => 401,
            'message'   => 'Billing cannot be created',
            'error_msg' => 'Please ensure the payment amount is greater than zero',
            'data'      => null,
        ], 200);
    }

    // Prepare arrays safely
    $treatment_ids = $request->treatment_ids ?? [];
    $treatment_ids_cus = $request->treatment_ids_cus ?? [];
    $product_ids = $request->product_ids ?? [];

    $treatment_ids_combined = array_merge($treatment_ids, $treatment_ids_cus);

    // Generate receipt, billing, and invoice numbers
    $lastBilling = Billing::orderBy('billing_id', 'desc')->first();
    $year = substr(date("y"), -2);

    // Helper function
    $generateNumber = function($lastNumber, $prefix) use ($branch_code, $year) {
        if (!$lastNumber) return $branch_code . '/' . $prefix . '0001/' . $year;
        $parts = explode('/', $lastNumber);
        $num = isset($parts[1]) ? preg_replace('/[^0-9]/', '', $parts[1]) : 0;
        $next = sprintf($prefix . '%04d', (int)$num + 1);
        return $branch_code . '/' . $next . '/' . $year;
    };

    $receipt_no = $generateNumber($lastBilling->receipt_no ?? null, 'RP');
    $billing_no = $generateNumber($lastBilling->billing_no ?? null, 'BI');
    $invoice_no = $generateNumber($lastBilling->invoice_no ?? null, 'IN');

    // Payment modes JSON
    $payment_modes = [
        'cash'   => floatval($request->cash) ?? 0,
        'card'   => floatval($request->card) ?? 0,
        'cheque' => floatval($request->cheque) ?? 0,
        'upi'    => floatval($request->upi) ?? 0,
    ];

    // Create billing
    $billing = new Billing([
        'payment_date'          => $request->payment_date,
        'customer_id'           => $request->customer_id,
        'invoice_no'            => $paid_amount >= $request->total_amount ? $invoice_no : null,
        'billing_no'            => $billing_no,
        'receipt_no'            => $receipt_no,
        'lead_id'               => $request->lead_id,
        'discount_type'         => $request->discount_type,
        'discount_amount'       => floatval($request->discount_amount) ?? 0,
        'treatment_id'          => json_encode($treatment_ids_combined),
        'product_category_id'   => $request->product_category_id,
        'treatment_category_id' => $request->treatment_category_id,
        'product_id'            => json_encode($product_ids),
        'treatment_amount'      => floatval($request->treatment_amount) ?? 0,
        'product_amount'        => floatval($request->product_amount) ?? 0,
        'cgst'                  => floatval($request->cgst) ?? 0,
        'sgst'                  => floatval($request->sgst) ?? 0,
        'igst'                  => floatval($request->igst) ?? 0,
        'total_amount'          => floatval($request->total_amount) ?? 0,
        'paid_amount'           => $paid_amount,
        'balance_amount'        => (floatval($request->total_amount) ?? 0) - $paid_amount,
        'payment_status'        => $paid_amount >= floatval($request->total_amount) ? '1' : '0',
        'payment_mode'          => json_encode($payment_modes),
        'created_by'            => $request->user()->id,
        'updated_by'            => $request->user()->id,
    ]);
    $billing->save();

    // Create payment entry
    $payment = new Payment([
        'payment_date'      => date("Y-m-d"),
        'customer_id'       => $billing->customer_id,
        'invoice_no'        => $paid_amount >= $billing->balance_amount ? $invoice_no : null,
        'receipt_no'        => $receipt_no,
        'lead_id'           => $billing->lead_id,
        'discount_type'     => $billing->discount_type,
        'discount_amount'   => $billing->discount_amount,
        'treatment_id'      => $billing->treatment_id,
        'product_id'        => $billing->product_id,
        'treatment_amount'  => floatval($request->treatment_amount) ?? 0,
        'product_amount'    => floatval($request->product_amount) ?? 0,
        'cgst'              => $billing->cgst,
        'sgst'              => $billing->sgst,
        'amount'            => $paid_amount,
        'total_amount'      => $billing->total_amount,
        'balance'           => $billing->total_amount - $paid_amount,
        'payment_status'    => $paid_amount >= $billing->balance_amount ? '1' : '0',
        'payment_mode'      => json_encode($payment_modes),
        'created_by'        => $request->user()->id,
        'updated_by'        => $request->user()->id,
    ]);
    $payment->save();

    return response([
        'status'  => 200,
        'message' => 'Billing created successfully',
        'data'    => $billing,
    ]);
}
    
    public function InvoiceBilling($id)
    {
        // Get the billing details based on the $id
        $billing = Billing::find($id);

        // Check if billing data exists
        if (!$billing) {
            return response([
                'message' => 'Billing data not found',
                'status' => 404
            ], 404);
        }

        // Decode the treatment_id and product_id fields
        $treatmentIds = json_decode($billing->treatment_id, true); // Ensure it's an array
        $productIds = json_decode($billing->product_id, true);     // Ensure it's an array

        // Ensure both are arrays
        if (!is_array($treatmentIds)) {
            $treatmentIds = [];
        }
        if (!is_array($productIds)) {
            $productIds = [];
        }

        // Fetch the relevant treatment and product data separately
        $treatments = Treatment::whereIn('treatment_id', $treatmentIds)->get(['treatment_id', 'treatment_name']);
        $products = Product::whereIn('product_id', $productIds)->get(['product_id', 'product_name']);

        // Fetch payment details and join with customer and lead
        $payment = Billing::select(
            'billing.billing_id',
            'billing.invoice_no',
            'billing.payment_date',
            'billing.paid_amount',
            'billing.total_amount',
            'billing.payment_status',
            'customer.customer_id',
            'customer.customer_first_name',
            'customer.customer_last_name',
            'customer.customer_address',
            'customer.customer_email',
            'customer.customer_phone',
            'customer.state_id',
            'lead.lead_first_name',
            'lead.lead_last_name',
            'lead.lead_phone',
            'lead.lead_email',
            'billing.status',
            'billing.balance_amount',
            'billing.discount_amount',
            'billing.cgst',
            'billing.sgst'
        )
            ->leftJoin('customer', 'customer.customer_id', '=', 'billing.customer_id')
            ->leftJoin('lead', 'lead.lead_id', '=', 'billing.lead_id')
            ->where('billing.billing_id', $id)
            ->first();

        // Combine the data into a single response
        return response([
            'data' => [
                'payment' => $payment,
                'treatments' => $treatments,
                'products' => $products,
            ],
            'status' => 200
        ], 200);
    }

    public function Edit($id)
    {
        $payment = Billing::select('billing.billing_id', 'billing.receipt_no', 'billing.invoice_no', 'billing.payment_date', 'billing.paid_amount', 'billing.total_amount', 'payment_status', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'treatment.treatment_id', 'treatment.treatment_name', 'customer.customer_id', 'customer.customer_first_name', 'customer.customer_last_name', 'customer.customer_address', 'customer.customer_email', 'customer.customer_phone', 'customer.state_id', 'billing.status', 'billing.balance_amount', 'billing.cgst', 'billing.sgst')
            ->leftJoin('treatment_category', 'treatment_category.tcategory_id', '=', 'billing.treatment_category_id')
            ->leftJoin('treatment', 'treatment.treatment_id', '=', 'billing.treatment_id')
            ->leftJoin('customer', 'customer.customer_id', '=', 'billing.customer_id')
            ->where('billing_id', $id)->get();
        return response([
            'data' => $payment,
            'status' => 200
        ], 200);
    }
    public function Update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [


            'receipt_no' => 'required|unique:payment,receipt_no,' . $id . ',p_id|max:255',
        ]);

        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {

            $invoice_no     = $request->invoice_no;
            $receipt_no     = $request->receipt_no;
            $payment_date   = $request->payment_date;
            $tcate_id        = $request->tcategory_id;
            $treatment_id   = $request->treatment_id;
            $customer_id    = $request->customer_id;
            $sitting_count  = $request->sitting_counts;
            $amount         = $request->amount;
            $total_amount   = $request->total_amount;
            $balance   = $request->balance_amount;
            $cgst   = $request->cgst;
            $sgst   = $request->sgst;
            $payment_status = $request->payment_status;

            $upd_payment = Payment::find($id);


            $upd_payment->invoice_no      = $invoice_no;
            $upd_payment->receipt_no      = $receipt_no;
            $upd_payment->payment_date    = $payment_date;
            $upd_payment->tcate_id         = $tcate_id;
            $upd_payment->treatment_id    = $treatment_id;
            $upd_payment->customer_id     = $customer_id;
            $upd_payment->sitting_count   = $sitting_count;
            $upd_payment->amount          = $amount;
            $upd_payment->total_amount    = $total_amount;
            $upd_payment->balance         = $balance;
            $upd_payment->sgst            = $sgst;
            $upd_payment->cgst            = $cgst;
            $upd_payment->payment_status  = $payment_status;
            $upd_payment->updated_by      = $request->user()->id;

            $upd_payment->update();

            $result =   response([
                'status'    => 200,
                'message'   => 'successfull updated',
                'error_msg' => null,
                'data'      => $upd_payment,
            ], 200);
        }

        return $result;
    }
    public function Delete($id)
    {
        $status = Payment::where('p_id', $id)->first();

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

        $payment_status = Payment::where('p_id', $id)->first();

        if ($payment_status) {
            $payment_status->status = $request->status;
            $payment_status->updated_by      = $request->user()->id;
            $payment_status->update();
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

    public function Consultation(Request $request)
    {
        $branch_id = $request->branch_id;
        $app_payment = AppointmentPayment::select('appointment_payment.app_pay_id', 'appointment_payment.mode', 'appointment_payment.amount', 'appointment_payment.created_at', 'lead.lead_id', 'lead.lead_first_name', 'lead.lead_last_name', 'lead.lead_address', 'lead.lead_email', 'lead.lead_phone', 'lead.branch_id')
            ->join('appointment', 'appointment.appointment_id', '=', 'appointment_payment.app_id')
            ->join('lead', 'lead.lead_id', '=', 'appointment.lead_id');
        if (isset($request->lead_id)) {
            $app_payment = $app_payment->where('lead.lead_id', $request->lead_id);
        }



        if (isset($branch_id)) {
            if ($branch_id > 0) {
                $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
                // $app_payment = $app_payment->where('lead.branch_id',$id);
                $app_payment = $app_payment->whereIn('lead.branch_id', $idArray);
            }
        }
        if (isset($request->from) && isset($request->to)) {
            $app_payment = $app_payment->whereBetween('created_at', [$request->from, $request->to]);
        }

        //  $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->id)->first();

        // if($branch->role_id != 1){
        //     $app_payment = $app_payment->where('lead.branch_id',$branch->branch_id);
        // }



        $app_payment = $app_payment->get();

        return response([
            'data' => $app_payment,
            'message' => 'Successfully Updated',
            'status' => 200
        ], 200);
    }


    public function InvoiceList(Request $request)
    {

        $customer_id = $request->c_id;

        $payments = Payment::where('customer_id', $customer_id)->get();
        // collect($payments)->where('cusomer_id', $customer_id)->pluck('invoice_no')->flatten();
        // return $payments;

        $invoices = $payments->unique('invoice_no');


        $id = $request->c_id;

        $customer = Customer::where('customer_id', $customer_id)->first();
        $branch   = Branch::where('branch_id', $customer ? $customer->branch_id : 0)->first();
        // $branch = Branch::where('branch_id',$customer?$customer->branch_id:'')->get();
        // if(isset($request->branch_id)){
        //     if($request->branch_id > 0){
        //         $branch = $branch->where('branch.branch_id',$request->branch_id);
        //     } 
        //  } 
        $resonse = [];

        foreach ($invoices as $val) {


            $cus_treatments = Payment::where('invoice_no', $val->invoice_no)->get();
            $data = $cus_treatments->unique('cus_treat_id');
            //  return  $data;
            $result = [];

            foreach ($data as $d) {

                $cus_treatment = CustomerTreatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'customer_treatment.status', 'customer.customer_id', 'customer.customer_first_name', 'customer_treatment.cus_treat_id', 'customer_treatment.progress', 'customer_treatment.medicine_prefered', 'customer_treatment.remarks', 'customer_treatment.amount', 'customer_treatment.discount', 'customer_treatment.modified_on')
                    ->where('customer_treatment.customer_id', $customer_id)
                    ->where('customer_treatment.cus_treat_id', $d->cus_treat_id)
                    ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'customer_treatment.tc_id')
                    ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')
                    ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
                    ->where('customer_treatment.status', '!=', 2)
                    ->where('customer_treatment.progress', '!=', 0)->first();

                $discount = Payment::where('customer_id', $customer_id)->where('invoice_no', $val->invoice_no)->sum('discount');
                $discount_amount = Payment::where('customer_id', $customer_id)->where('invoice_no', $val->invoice_no)->sum('discount_amount');


                $result[] = [

                    'treatment_id'       => $d->treatment_id,
                    'treatment_name'     => $cus_treatment ? $cus_treatment->treatment_name : '',
                    'tcategory_id'       => $d->tcate_id,
                    'tc_name'            => $cus_treatment ? $cus_treatment->tc_name : '',
                    'status'             => $cus_treatment ? $cus_treatment->status : '',
                    'customer_id'        => $cus_treatment ? $cus_treatment->customer_id : '',
                    'customer_first_name' => $cus_treatment ? $cus_treatment->customer_first_name : '',
                    'cus_treat_id'       => $cus_treatment ? $cus_treatment->cus_treat_id : '',
                    'progress'           => $cus_treatment ? $cus_treatment->progress : '',
                    'medicine_prefered'  => $cus_treatment ? $cus_treatment->medicine_prefered : '',
                    'invoice_date'        => $cus_treatment ? date('d-m-Y', strtotime($cus_treatment->modified_on)) : '',
                    'remarks'            => $cus_treatment ? $cus_treatment->remarks : '',
                    'amount'             => $cus_treatment ? $cus_treatment->amount : '',
                    'discount'           => $discount,
                    'discount_amount'      => $discount_amount,
                    'balance'            => 0,

                ];
            }
            // return  $result;

            $resonse[] = [
                'treatments'      => $result,
                'customer'  => $customer,
                'branch'    => $branch,
                'invoice_no' => $val->invoice_no

            ];
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $resonse,
        ], 200);

        // return $uniqueCollection;
    }
    public function InvoiceAll(Request $request)
    {

        $customer_id = $request->branch_id;

        $payments = Payment::where('customer_id', $customer_id)->get();
        // collect($payments)->where('cusomer_id', $customer_id)->pluck('invoice_no')->flatten();
        // return $payments;

        $invoices = $payments->unique('invoice_no');


        $id = $request->c_id;

        $customer = Customer::where('customer_id', $customer_id)->first();
        $branch   = Branch::where('branch_id', $customer ? $customer->branch_id : 0)->first();
        // $branch = Branch::where('branch_id',$customer?$customer->branch_id:'')->get();
        // if(isset($request->branch_id)){
        //     if($request->branch_id > 0){
        //         $branch = $branch->where('branch.branch_id',$request->branch_id);
        //     } 
        //  } 
        $resonse = [];

        foreach ($invoices as $val) {


            $cus_treatments = Payment::where('invoice_no', $val->invoice_no)->get();
            $data = $cus_treatments->unique('cus_treat_id');
            //  return  $data;
            $result = [];

            foreach ($data as $d) {

                $cus_treatment = CustomerTreatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'customer_treatment.status', 'customer.customer_id', 'customer.customer_first_name', 'customer_treatment.cus_treat_id', 'customer_treatment.progress', 'customer_treatment.medicine_prefered', 'customer_treatment.remarks', 'customer_treatment.amount', 'customer_treatment.discount', 'customer_treatment.modified_on')
                    ->where('customer_treatment.customer_id', $customer_id)
                    ->where('customer_treatment.cus_treat_id', $d->cus_treat_id)
                    ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'customer_treatment.tc_id')
                    ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')
                    ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
                    ->where('customer_treatment.status', '!=', 2)
                    ->where('customer_treatment.progress', '!=', 0)->first();

                $discount = Payment::where('customer_id', $customer_id)->where('invoice_no', $val->invoice_no)->sum('discount');
                $discount_amount = Payment::where('customer_id', $customer_id)->where('invoice_no', $val->invoice_no)->sum('discount_amount');


                $result[] = [

                    'treatment_id'       => $d->treatment_id,
                    'treatment_name'     => $cus_treatment ? $cus_treatment->treatment_name : '',
                    'tcategory_id'       => $d->tcate_id,
                    'tc_name'            => $cus_treatment ? $cus_treatment->tc_name : '',
                    'status'             => $cus_treatment ? $cus_treatment->status : '',
                    'customer_id'        => $cus_treatment ? $cus_treatment->customer_id : '',
                    'customer_first_name' => $cus_treatment ? $cus_treatment->customer_first_name : '',
                    'cus_treat_id'       => $cus_treatment ? $cus_treatment->cus_treat_id : '',
                    'progress'           => $cus_treatment ? $cus_treatment->progress : '',
                    'medicine_prefered'  => $cus_treatment ? $cus_treatment->medicine_prefered : '',
                    'invoice_date'        => $cus_treatment ? date('d-m-Y', strtotime($cus_treatment->modified_on)) : '',
                    'remarks'            => $cus_treatment ? $cus_treatment->remarks : '',
                    'amount'             => $cus_treatment ? $cus_treatment->amount : '',
                    'discount'           => $discount,
                    'discount_amount'      => $discount_amount,
                    'balance'            => 0,

                ];
            }
            // return  $result;

            $resonse[] = [
                'treatments'      => $result,
                'customer'  => $customer,
                'branch'    => $branch,
                'invoice_no' => $val->invoice_no

            ];
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $resonse,
        ], 200);

        // return $uniqueCollection;
    }
}