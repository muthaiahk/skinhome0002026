<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Payment;
use App\Models\CustomerTreatment;
use App\Models\AppointmentPayment;
use App\Models\Treatment;
use App\Models\Product;
use FFI\CData;
use App\Models\Staff;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
{

public function printPayment($id)
{

$payment = Payment::select(
'payment.*',
'customer.customer_first_name',
'customer.customer_phone',
'customer.customer_email',
'customer.customer_address',
'customer.state_id',
'branch.branch_name',
'branch.branch_phone',
'branch.branch_email',
'branch.branch_location'
)
->leftJoin('customer','customer.customer_id','=','payment.customer_id')
->leftJoin('branch','branch.branch_id','=','customer.branch_id')
->where('payment.p_id',$id)
->first();


$treatments = DB::table('treatment')
->join('payment','payment.treatment_id','=','treatment.treatment_id')
->where('payment.p_id',$id)
->select('treatment_name')
->get();

return view('payments.print_receipt',compact('payment','treatments'));

}
public function index()
{

    $branches = Branch::where('status','!=',2)->get();

    $payment = Payment::select(
        'payment.p_id',
        'payment.receipt_no',
        'payment.invoice_no',
        'payment.payment_date',
        'payment.amount',
        'payment.total_amount',
        'payment.payment_status',
        'payment.balance',
        'customer.branch_id',
        'customer.customer_first_name',
        'customer.customer_phone',
        'lead.lead_first_name',
        'lead.lead_phone'
    )
    ->leftJoin('lead', 'lead.lead_id', '=', 'payment.lead_id')
    ->leftJoin('customer', 'customer.customer_id', '=', 'payment.customer_id')
    ->where('payment.status','!=',2)
    ->orderBy('payment.p_id','desc')
    ->get();

    return view('payment',compact('payment','branches'));
}
    public function All(Request $request)
    {
        $branch_id = $request->branch_id;
        $payment = Payment::select(
            'payment.p_id',
            'payment.receipt_no',
            'payment.invoice_no',
            'payment.payment_date',
            'payment.amount',
            'payment.total_amount',
            'payment_status',
            'customer.customer_id',
            'customer.customer_first_name',
            'lead.lead_id',
            'lead.lead_first_name',
            'lead.lead_phone',
            'payment.status',
            'payment.balance',
            'customer.branch_id'
        )
            ->leftjoin('lead', 'lead.lead_id', '=', 'payment.lead_id')
            ->leftjoin('customer', 'customer.customer_id', '=', 'payment.customer_id')
            ->where('payment.status', '!=', 2)
            ->orderBy('payment.p_id', 'desc');

        // ->get();
        //   return $payment;

        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();

        // if($branch->role_id != 1){
        //     $payment = $payment->where('customer.branch_id',$branch->branch_id);
        // }

        if (isset($branch_id)) {
            if ($branch_id > 0) {
                $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
                $payment = $payment->where('customer.branch_id', $idArray);
            }
        }

        $search_input = $request->input('search_input', '');
        if (isset($search_input)) {
            // return $search_input;
            $payment->where(function ($query) use ($search_input) {
                $query->where('customer.customer_first_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('payment.receipt_no', 'LIKE', "%{$search_input}%")
                    ->orWhere('payment.invoice_no', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_last_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_email', 'LIKE', "%{$search_input}%")
                    ->orWhere('customer.customer_phone', 'LIKE', "%{$search_input}%");
            });
        }
        // if($request->tc_id > 0){
        //     $payment = $payment->where('payment.tcate_id',$request->tc_id);
        // }

        // if($request->t_id > 0){
        //     $payment = $payment->where('customer.treatment_id',$request->t_id);
        // }
        // $payment = $payment->get();

        $page = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default limit
        // Get the total count for pagination
        $total = $payment->count();
        $payment = $payment->skip(($page - 1) * $limit)->take($limit)->get();


        $payment_ids = Payment::select('p_id', 'receipt_no', 'invoice_no')->orderBy('p_id', 'desc')->first();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $payment,
            'numbers'   => $payment_ids,
            'total' => $total,
            'page' => $page,
            'limit' => $limit

        ], 200);
    }


    public function Customer()
    {
        $customers = CustomerTreatment::select('customer.customer_id', 'customer.customer_first_name', 'customer.customer_last_name', 'customer.customer_phone', 'customer.status')->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')->distinct('customer_treatment.customer_id')->where('customer.status', '!=', 2)->get();
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $customers,

        ], 200);
    }

    // public function TreatmenCategory($id)
    // {

    //     // $payment_ = Payment::where('customer_id','=',$id)->get;
    //     $treatment_cat = CustomerTreatment::where('customer_treatment.customer_id', $id)
    //         ->where('customer_treatment.progress', '!=', 1)
    //         ->get();

    //     $treatment_res = [];
    //     foreach ($treatment_cat as $val) {

    //         $payment = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->orderBy('payment.p_id', 'DESC')->first();
    //         $treatment = Treatment::where('treatment_id', $val['treatment_id'])->first();

    //         $cus = Customer::where('customer_id', $id)->first();

    //         if ($payment) {
    //             $total_discount   = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->sum('discount');
    //             $total_pay_amount = Payment::where('customer_id', '=', $id)->where('treatment_id', $val['treatment_id'])->where('cus_treat_id', $val['cus_treat_id'])->sum('amount');



    //             $treatment_res[] = [
    //                 'amount' => $payment->total_amount,
    //                 'discount' =>  $total_discount,
    //                 'balance' => $payment->balance,
    //                 'pay_amount' => $total_pay_amount,
    //                 'treatment_id' => $val['treatment_id'],
    //                 'treatment_name' => $treatment->treatment_name,
    //                 'tc_id'     => $val['tc_id'],
    //                 'status' => $val['status'],
    //                 'state_id' => $cus ? $cus->state_id : '',
    //                 'cus_treat_id' => $val['cus_treat_id']

    //             ];
    //         } else {
    //             $treatment_res[]  = [
    //                 'amount' => $val['amount'],
    //                 'discount' => 0,
    //                 'pay_amount' => 0,
    //                 'balance' => $val['amount'],
    //                 'treatment_id' => $val['treatment_id'],
    //                 'treatment_name' =>  $treatment->treatment_name,
    //                 'tc_id'     => $val['tc_id'],
    //                 'status' => $val['status'],
    //                 'state_id' => $cus ? $cus->state_id : '',
    //                 'cus_treat_id' => $val['cus_treat_id']
    //             ];
    //         }
    //     }


    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'data'      => $treatment_res,
    //         'payment'    => $treatment_res,

    //     ], 200);
    // }
    // PaymentController.php
public function TreatmenCategory($id)
{
    $treatment_cat = CustomerTreatment::where('customer_treatment.customer_id', $id)
        ->where('customer_treatment.progress', '!=', 1)
        ->get();

    $treatment_res = [];

    $cus = Customer::where('customer_id', $id)->first();
    $state_id = $cus ? $cus->state_id : '';

    foreach ($treatment_cat as $val) {
        $payment = Payment::where('customer_id', $id)
            ->where('treatment_id', $val->treatment_id)
            ->where('cus_treat_id', $val->cus_treat_id)
            ->orderBy('p_id', 'DESC')
            ->first();

        $treatment = Treatment::where('treatment_id', $val->treatment_id)->first();

        if ($payment) {
            $total_discount   = Payment::where('customer_id', $id)
                ->where('treatment_id', $val->treatment_id)
                ->where('cus_treat_id', $val->cus_treat_id)
                ->sum('discount');

            $total_pay_amount = Payment::where('customer_id', $id)
                ->where('treatment_id', $val->treatment_id)
                ->where('cus_treat_id', $val->cus_treat_id)
                ->sum('amount');

            $treatment_res[] = [
                'amount' => $payment->total_amount,
                'discount' =>  $total_discount,
                'balance' => $payment->balance,
                'pay_amount' => $total_pay_amount,
                'treatment_id' => $val->treatment_id,
                'treatment_name' => $treatment->treatment_name,
                'tc_id'     => $val->tc_id,
                'status' => $val->status,
                'state_id' => $state_id,
                'cus_treat_id' => $val->cus_treat_id
            ];
        } else {
            $treatment_res[]  = [
                'amount' => $val->amount,
                'discount' => 0,
                'pay_amount' => 0,
                'balance' => $val->amount,
                'treatment_id' => $val->treatment_id,
                'treatment_name' =>  $treatment->treatment_name,
                'tc_id'     => $val->tc_id,
                'status' => $val->status,
                'state_id' => $state_id,
                'cus_treat_id' => $val->cus_treat_id
            ];
        }
    }

    return response()->json([
        'status'    => 200,
        'message'   => 'Success',
        'data'      => $treatment_res
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

    public function InvoiceGenerator(Request $request)
    {

        $user_check = Payment::where('customer_id', $request->customer_id)->where('tcate_id', $request->tcategory_id)->orderBy('created_on', 'DESC')->first();

        if ($user_check) {
            $invoice_check = Payment::where('customer_id', $request->customer_id)->where('tcate_id', $request->tcategory_id)->first();

            if ($invoice_check) {

                $invoice = Payment::where('customer_id', $request->customer_id)->where('treatment_id', $request->treatment_id)->where('tcate_id', $request->tcategory_id)->orderBy('created_on', 'DESC')->get();

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

        // $invoice_gen = Payment::where('invoice_no','!=',null)->orderby('invoice_no', 'desc')->first();

        // if($invoice_gen){


        //     $year = substr( date("y"), -2);
        //     $slice = explode("/", $invoice_gen->invoice_no);
        //     $result = preg_replace('/[^0-9]/',' ', $slice[0]); 


        //     function invoice_num ($input, $pad_len = 3  , $prefix = null) {


        //         if (is_string($prefix))
        //             return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        //         return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
        //     }

        //     $response =  invoice_num($result+1, 3, '-IN-');
        //     $invoice =  $branch->branch_code.$response.'/'.$year;

        // }else{
        //     $year = substr( date("y"), -2);
        //     $invoice =  'IN-001/'.$year;
        // }


        $payments = Payment::where('invoice_no', '!=', null)->get();

        $numbers = [];
        // foreach($payments as $pays){

        //     $slice = explode("/", $pays->invoice_no);
        //     $result = preg_replace('/[^0-9]/','', $slice[0]); 
        //     $numbers[] =$result; 


        // } 
        foreach ($payments as $pays) {
            $slice = explode("/", $pays->invoice_no);
            if (isset($slice[0])) {
                $parts = explode("-", $slice[0]);
                if (isset($parts[2])) {
                    $result = preg_replace('/[^0-9]/', '', $parts[2]);
                    $numbers[] = $result;
                }
            }
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
    public function Add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            //'invoice_no' => 'required|unique:payment|max:255',
            //'invoice_no' => 'required|unique:payment,invoice_no,'.$id.',p_id|max:255',
            //'receipt_no' => 'required|unique:payment|max:255',

        ]);


        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {

            $payment_date     = $request->payment_date;
            $customer_id      = $request->customer_id;
            $cgst             = $request->cgst;
            $sgst             = $request->sgst;
            $payment_status   = $request->payment_status;
            $treatment_details = json_decode($request->treatment_details);


            $payments = json_decode($payment_status);

            $amt = 0;

            foreach ($payments as $pay) {
                $amt = $amt + $pay->amount;
            }


            if ($amt > 0) {


                foreach ($treatment_details as $val) {


                    if ($val->amount != 0) {
                        $discount_amount = $val->discount_type == 2 ? ($val->amount * $val->discount) / 100 : $val->discount;
                        $chk_pay = Payment::where('customer_id', $customer_id)->where('cus_treat_id', $val->cus_treat_id)->orderby('p_id', 'desc')->first();

                        if ($chk_pay) {

                            $sitting_count = Payment::where('cus_treat_id', $val->cus_treat_id)->get();

                            $receipt_gen = Payment::where('cus_treat_id', $val->cus_treat_id)->orderby('p_id', 'desc')->first();


                            if ($receipt_gen) {

                                $year = substr(date("y"), -2);
                                $slice = explode("/", $receipt_gen->receipt_no);
                                $result = preg_replace('/[^0-9]/', ' ', $slice[0]);


                                function invoice_num($input, $pad_len = 3, $prefix = null)
                                {
                                    if ($pad_len <= strlen($input))
                                        trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

                                    if (is_string($prefix))
                                        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

                                    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
                                }

                                $response =  invoice_num($result + 1, 3, "RP-");
                                $receipt =  $response . '/' . $year;
                            } else {
                                $year = substr(date("y"), -2);
                                $receipt =  'RP-001/' . $year;
                            }

                            $cus_treatment = CustomerTreatment::where('cus_treat_id', $val->cus_treat_id)->first();
                            $add_payment   = new Payment;

                            $balance = ($chk_pay->balance) - ($val->amount + $val->discount);

                            $add_payment->invoice_no      = null;
                            $add_payment->receipt_no      = $receipt;
                            $add_payment->payment_date    = $payment_date;
                            $add_payment->tcate_id        = $cus_treatment->tc_id;
                            $add_payment->treatment_id    = $cus_treatment->treatment_id;
                            $add_payment->customer_id     = $customer_id;
                            $add_payment->sitting_count   = count($sitting_count) + 1;
                            $add_payment->amount          = $val->amount;
                            $add_payment->total_amount    = $chk_pay->balance;
                            $add_payment->balance         = $balance;
                            $add_payment->discount        = $val->discount;
                            $add_payment->discount_type   = $val->discount_type;
                            $add_payment->discount_amount   = $discount_amount;
                            $add_payment->cgst            = $cgst;
                            $add_payment->sgst            = $sgst;
                            $add_payment->payment_status  = $payment_status;
                            $add_payment->created_by      = $request->user()->id;
                            $add_payment->updated_by      = $request->user()->id;
                            $add_payment->cus_treat_id    = $val->cus_treat_id;

                            $add_payment->save();

                            if ($balance == 0) {

                                $customer_trt = CustomerTreatment::where('cus_treat_id', $val->cus_treat_id)->first();

                                $customer_trt->progress = 1;
                                $customer_trt->update();
                            }

                            if ($add_payment) {

                                $app_status = Appointment::where('customer_id', $add_payment->customer_id)->orderBy('appointment_id', 'desc')->first();

                                $app_status->app_status = 2;
                                $app_status->update();



                                $result =    response([
                                    'status'    => 200,
                                    'message'   => 'Payment has been  successfully Done',
                                    'error_msg' => null,
                                    'data'      => null,
                                ], 200);
                            } else {

                                $result =  response([

                                    'status'    => 401,
                                    'message'   => 'Payment can not be created',
                                    'error_msg' => 'Payment information is worng please try again',
                                    'data'      => null,
                                ], 401);
                            }
                        } else {


                            $year = substr(date("y"), -2);

                            $cus_treatment = CustomerTreatment::where('cus_treat_id', $val->cus_treat_id)->first();

                            $add_payment   = new Payment;

                            $balance = $cus_treatment->amount - ($val->amount + $val->discount);

                            $add_payment->invoice_no      = null;
                            $add_payment->receipt_no      = 'RP-001/' . $year;
                            $add_payment->payment_date    = $payment_date;
                            $add_payment->tcate_id        = $cus_treatment->tc_id;
                            $add_payment->treatment_id    = $cus_treatment->treatment_id;
                            $add_payment->customer_id     = $customer_id;
                            $add_payment->sitting_count   = 1;
                            $add_payment->amount          = $val->amount;
                            $add_payment->total_amount    = $cus_treatment->amount;
                            $add_payment->balance         = $balance;
                            $add_payment->discount        = $val->discount;
                            $add_payment->discount_type   = $val->discount_type;
                            $add_payment->discount_amount   = $discount_amount;
                            $add_payment->cgst            = $cgst;
                            $add_payment->sgst            = $sgst;
                            $add_payment->payment_status  = $payment_status;
                            $add_payment->created_by      = $request->user()->id;
                            $add_payment->updated_by      = $request->user()->id;
                            $add_payment->cus_treat_id  = $val->cus_treat_id;


                            $add_payment->save();


                            if ($add_payment->balance == 0) {


                                $customer_trt = CustomerTreatment::where('cus_treat_id', $val->cus_treat_id)->first();
                                $customer_trt->progress = 1;
                                $customer_trt->update();
                            }



                            if ($add_payment) {

                                $app_status = Appointment::where('customer_id', $add_payment->customer_id)->orderBy('appointment_id', 'desc')->first();

                                $app_status->app_status = 2;
                                $app_status->update();

                                $result =   response([
                                    'status'    => 200,
                                    'message'   => 'Payment has been  successfully Done',
                                    'error_msg' => null,
                                    'data'      => null,
                                ], 200);
                            } else {

                                $result =  response([

                                    'status'    => 401,
                                    'message'   => 'Payment can not be created',
                                    'error_msg' => 'Payment information is worng please try again',
                                    'data'      => null,
                                ], 401);
                            }
                        }
                    }
                }
            } else {
                return  response([

                    'status'    => 401,
                    'message'   => 'Payment can not be created',
                    'error_msg' => 'Payment information is worng please try again',
                    'data'      => null,
                ], 200);
            }

            return $result;
        }
    }
    // public function Edit($id){
    //     $payment = Payment::select('payment.p_id','payment.receipt_no','payment.invoice_no','payment.payment_date','payment.sitting_count','payment.amount','payment.total_amount','payment_status','treatment_category.tcategory_id','treatment_category.tc_name','treatment.treatment_id','treatment.treatment_name','customer.customer_id','customer.customer_first_name','customer.customer_address','customer.customer_email','customer.customer_phone','customer.state_id','payment.status','payment.balance','payment.cgst','payment.sgst')
    //     ->join('treatment_category','treatment_category.tcategory_id','=','payment.tcate_id')
    //     ->join('treatment','treatment.treatment_id','=','payment.treatment_id')
    //     ->join('customer', 'customer.customer_id','=','payment.customer_id')->where('p_id', $id)->get();
    //     return response([
    //         'data' => $payment,
    //         'status' => 200
    //     ],200);
    // }
    public function Edit($id)
    {

        $branch_id = request()->query('branch_id'); // Get from query strin
        // return $branch_id;
        // Get the billing details based on the $id
        $billing = Payment::find($id);
        $branch = Branch::find($branch_id);

        // Check if billing data exists
        if (!$billing) {
            return response([
                'message' => 'Payment data not found',
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
        $payment = Payment::select(
            'payment.p_id',
            'payment.invoice_no',
            'payment.payment_date',
            'payment.amount',
            'payment.total_amount',
            'payment.payment_status',
            'customer.customer_id',
            'customer.customer_first_name',
            'customer.customer_address',
            'customer.customer_email',
            'customer.customer_phone',
            'customer.state_id',
            'lead.lead_first_name',
            'lead.lead_last_name',
            'lead.lead_phone',
            'lead.lead_email',
            'payment.status',
            'payment.balance',
            'payment.discount_amount',
            'payment.cgst',
            'payment.payment_mode',
            'payment.sgst'
        )
            ->leftJoin('customer', 'customer.customer_id', '=', 'payment.customer_id')
            ->leftJoin('lead', 'lead.lead_id', '=', 'payment.lead_id')
            ->where('payment.p_id', $id)
            ->first();

        // Combine the data into a single response
        return response([
            'data' => [
                'payment' => $payment,
                'treatments' => $treatments,
                'products' => $products,
                'branch' => $branch,
            ],
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
        $app_payment = AppointmentPayment::select('appointment_payment.app_pay_id', 'appointment_payment.mode', 'appointment_payment.amount', 'appointment_payment.created_at', 'lead.lead_id', 'lead.lead_first_name', 'lead.lead_last_name', 'lead.lead_address', 'lead.lead_email', 'lead.lead_phone', 'lead.branch_id')
            ->join('appointment', 'appointment.appointment_id', '=', 'appointment_payment.app_id')
            ->join('lead', 'lead.lead_id', '=', 'appointment.lead_id');
        if (isset($request->lead_id)) {
            $app_payment = $app_payment->where('lead.lead_id', $request->lead_id);
        }

        if (isset($request->branch_id)) {
            if ($request->branch_id > 0) {
                // $app_payment = $app_payment->where('lead.branch_id',$id);
                $app_payment = $app_payment->where('lead.branch_id', $request->branch_id);
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
        $branch = Branch::where('branch_id', $customer ? $customer->branch_id : 0)->first();
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
            //return  $data;
            $result = [];

            foreach ($data as $d) {

                $cus_treatment = CustomerTreatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'customer_treatment.status', 'customer.customer_id', 'customer.customer_first_name', 'customer_treatment.cus_treat_id', 'customer_treatment.progress', 'customer_treatment.medicine_prefered', 'customer_treatment.remarks', 'customer_treatment.amount', 'customer_treatment.discount')
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
                    'remarks'            => $cus_treatment ? $cus_treatment->remarks : '',
                    'amount'             => $cus_treatment ? $cus_treatment->amount : '',
                    'discount'           => $discount,
                    'discount_amount'      => $discount_amount,
                    'balance'            => 0,

                ];
            }
            //  return  $result;
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