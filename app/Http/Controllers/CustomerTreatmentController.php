<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CustomerTreatment;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\TreatmentCategory;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\Treatment;

class CustomerTreatmentController extends Controller
{
    //
   public function All(Request $request)
    {
        // Get all treatments (no paginate, needed for DataTables filtering)
        $cus_treatment = CustomerTreatment::select(
            'treatment.treatment_id',
            'branch.branch_name',
            'customer_treatment.treatment_auto_id',
            'customer_treatment.complete_status',
            'treatment.treatment_name',
            'treatment_category.tcategory_id',
            'treatment_category.tc_name',
            'customer_treatment.status',
            'customer.customer_id',
            'customer.customer_first_name',
            'customer_treatment.cus_treat_id',
            'customer_treatment.progress',
            'customer_treatment.medicine_prefered',
            'customer_treatment.remarks',
            'customer_treatment.amount',
            'customer_treatment.discount',
            'customer.branch_id',
            'customer_treatment.created_on'
        )
        ->join('treatment_category','treatment_category.tcategory_id','=','customer_treatment.tc_id')
        ->join('treatment','treatment.treatment_id','=','customer_treatment.treatment_id')
        ->join('customer','customer.customer_id','=','customer_treatment.customer_id')
        ->leftJoin('branch','branch.branch_id','=','customer.branch_id')
        ->where('customer_treatment.status','!=',2)
        ->orderBy('customer_treatment.created_on','desc')
        ->get();

        // Add invoice, balance, etc
        // foreach ($cus_treatment as $item) {

        //     $status = Payment::where('tcate_id',$item->tcategory_id)
        //         ->where('treatment_id',$item->treatment_id)
        //         ->where('customer_id',$item->customer_id)
        //         ->where('balance',0)
        //         ->first();

        //     $b = Payment::where('tcate_id',$item->tcategory_id)
        //         ->where('treatment_id',$item->treatment_id)
        //         ->where('customer_id',$item->customer_id)
        //         ->orderBy('p_id','desc')
        //         ->first();

        //     $item->p_id = $status ? $status->p_id : 0;
        //     $item->invoice_no = $status ? $status->invoice_no : '';
        //     $item->balance = $b ? $b->balance : $item->amount;
        // }

        $branches = Branch::where('status','!=',2)->get();
        $categories = TreatmentCategory::where('status','!=',2)->get();
        $treatments = Treatment::where('status','!=',2)->get();
        $Customers = Customer::get();

        return view('treatment_management', compact(
            'cus_treatment',
            'branches',
            'categories',
            'treatments',
            'Customers'
        ));
    }
    //   public function Add(Request $request){
    //         // return $request;
    //         $validator = Validator::make($request->all(), [ 

    //                                                     ]);


    //         if($validator->fails()) {
    //             $result =   response([
    //                                     'status'    => 401,
    //                                     'message'   => 'Incorrect format input feilds',
    //                                     'error_msg'     => $validator->messages()->get('*'),
    //                                     'data'      => null ,
    //                                 ],401);


    //         }else{

    //             $chk = CustomerTreatment::where('tc_id',$request->tc_id)->where('treatment_id',$request->treatment_id)->where('customer_id',$request->customer_id)->where('progress','0')->first();

    //             if($chk){
    //                 return  response([
    //                     'status'    => 400,
    //                     'message'   => 'Treatment Already assigned this customer',
    //                     'error_msg' => null,
    //                     'data'      => null ,
    //                 ],200);
    //             }else{

    //                 $treatment_auto_id = CustomerTreatment::where('treatment_auto_id','!=',null)->get();
    //                 $id = $request->customer_id;
    //                 $customer = Customer::where('customer_id',$id)->first();
    //                 $branch = Branch::where('branch_id',$customer?$customer->branch_id:'')->first();
    //                 $numbers = [];  
    //                 foreach($treatment_auto_id as $pays) {
    //                     $slice = explode("/", $pays->cus_treat_id);
    //                     $result = preg_replace('/[^0-9]/','', $slice[0]); 
    //                     $numbers[] = $result; 
    //                 } 
    //                 rsort($numbers);
    //                 if(count($treatment_auto_id) > 0) {
    //                     $year = substr(date("y"), -2);
    //                     $result = $numbers[0];

    //                     function invoice_num($input, $pad_len = 3, $prefix = null) {
    //                         if (is_string($prefix))
    //                             return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    //                         return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    //                     }

    //                     $response = invoice_num($result + 1, 3, "-TR-");
    //                     $invoice = $branch->branch_code . $response . '/' . $year;
    //                 } else {
    //                     $year = substr(date("y"), -2);
    //                     $invoice = $branch->branch_code . '-TR-001/' . $year;
    //                 }


    //                     // return $invoice;
    //                 $tc_id           = $request->tc_id;
    //                 $treatment_id    = $request->treatment_id;
    //                 $customer_id     = $request->customer_id;
    //                 $progress        = $request->progress;
    //                 $medicine        = $request->madicine;
    //                 $remarks         = $request->remarks;
    //                 $amount          = $request->amount;
    //               //  $discount        = $request->discount;

    //                 $add_cus_treatment   = new CustomerTreatment;

    //                 $add_cus_treatment->treatment_auto_id              = $invoice;
    //                 //dd(  $add_cus_treatment->treatment_auto_id );
    //                 $add_cus_treatment->tc_id              = $tc_id;
    //                 $add_cus_treatment->treatment_id       = $treatment_id;
    //                 $add_cus_treatment->customer_id        = $customer_id;
    //                 $add_cus_treatment->progress           = $progress;
    //                 $add_cus_treatment->medicine_prefered  = $medicine;
    //                 $add_cus_treatment->remarks            = $remarks;
    //                 $add_cus_treatment->amount             = $amount;
    //                 $add_cus_treatment->discount           = 0;
    //                 $add_cus_treatment->created_by         = $request->user()->id;
    //                 $add_cus_treatment->modified_by        = $request->user()->id;
    //                 //return $add_cus_treatment;
    //                 $add_cus_treatment->save();

    //                 if($add_cus_treatment){

    //                     $result =   response([
    //                                             'status'    => 200,
    //                                             'message'   => 'Customer Treatment has been created successfully',
    //                                             'error_msg' => null,
    //                                             'data'      => null ,
    //                                         ],200);

    //                 }else{

    //                     $result =   response([

    //                                             'status'    => 401,
    //                                             'message'   => 'Treatment can not be created',
    //                                             'error_msg' => 'Treatment information is worng please try again',
    //                                             'data'      => null ,
    //                                         ],401);
    //                 }
    //             }


    //         }

    //         return $result;
    //     }
    public function Add(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), []);


        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {

            $chk = CustomerTreatment::where('tc_id', $request->tc_id)->where('treatment_id', $request->treatment_id)->where('customer_id', $request->customer_name)->where('progress', '0')->first();

            if ($chk) {
                return  response([
                    'status'    => 400,
                    'message'   => 'Treatment Already assigned this customer',
                    'error_msg' => null,
                    'data'      => null,
                ], 200);
            } else {

                // $treatment_auto_id = CustomerTreatment::where('treatment_auto_id','!=',null)->get();
                // $id = $request->customer_id;
                // $customer = Customer::where('customer_id',$id)->first();
                // $branch = Branch::where('branch_id',$customer?$customer->branch_id:'')->first();
                // $numbers = [];  
                // foreach($treatment_auto_id as $pays) {
                //     $slice = explode("/", $pays->cus_treat_id);
                //     $result = preg_replace('/[^0-9]/','', $slice[0]); 
                //     $numbers[] = $result; 
                // } 
                // rsort($numbers);
                // if(count($treatment_auto_id) > 0) {
                //     $year = substr(date("y"), -2);
                //     $result = $numbers[0];

                //     function invoice_num($input, $pad_len = 3, $prefix = null) {
                //         if (is_string($prefix))
                //             return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
                //         return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
                //     }

                //     $response = invoice_num($result + 1, 3, "-TR-");
                //     $invoice = $branch->branch_code . $response . '/' . $year;
                // } else {
                //     $year = substr(date("y"), -2);
                //     $invoice = $branch->branch_code . '-TR-001/' . $year;
                // }
                $treatment_auto_id = CustomerTreatment::where('treatment_auto_id', '!=', null)
                    ->orderby('cus_treat_id', 'desc')
                    ->get();

                $id = $request->customer_name;
                $customer = Customer::where('customer_id', $id)->first();
                $branch = Branch::where('branch_id', $customer ? $customer->branch_id : '')->first();

                $numbers = [];
                $currentYear = date("y"); // Get the current year (last two digits)
                $currentMonth = date("m"); // Get the current month (two digits)

                // Loop through existing treatment_auto_id to find IDs for the current month and year
                foreach ($treatment_auto_id as $treatment) {
                    $slice = explode("/", $treatment->treatment_auto_id); // Split the treatment ID

                    // Check if the slices are in the correct order
                    if (isset($slice[1]) && isset($slice[2]) && $slice[1] == $currentMonth && $slice[2] == $currentYear) {
                        $result = preg_replace('/[^0-9]/', '', $slice[0]); // Extract the number part (e.g., "2003")
                        $numbers[] = (int)$result; // Collect numbers for the current month and year
                    }
                }

                // Sort the numbers in descending order to find the last one
                sort($numbers, SORT_NUMERIC);
                $numbers = array_reverse($numbers); // Highest to lowest

                // Determine the next invoice number
                if (count($numbers) > 0) {
                    // If there are invoice numbers for the current month, increment the highest number
                    $lastNumber = $numbers[0]; // Get the highest number
                    $nextNumber = $lastNumber + 1; // Increment it
                } else {
                    // If no invoice number exists for the current month, start at 001
                    $nextNumber = 1; // Start from 1 if no previous numbers exist
                }

                // Function to generate the invoice number
                function generateInvoiceNumber($input, $pad_len = 3, $prefix = null)
                {
                    return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
                }

                // Generate the next invoice number with increment
                $response = generateInvoiceNumber($nextNumber, 3, "-TR-");
                $invoice = $branch->branch_code . $response . '/' . $currentMonth . '/' . $currentYear;






                // return $invoice;

                // Save the generated invoice number back to the database
                // CustomerTreatment::create([
                //     'customer_id' => $id,
                //     'treatment_auto_id' => $invoice,
                //     // Other fields as needed
                // ]);

                // Return or save the $invoice variable as needed
                // return $invoice;


                // Return or save the $invoice variable as needed


                // Return or save the $invoice variable as needed




                // $treatment_auto_id = CustomerTreatment::where('treatment_auto_id', '!=', null)->get();
                // $id = $request->customer_id;
                // $customer = Customer::where('customer_id', $id)->first();
                // $branch = Branch::where('branch_id', $customer ? $customer->branch_id : '')->first();
                // $numbers = [];  

                // foreach ($treatment_auto_id as $pays) {
                //     $slice = explode("/", $pays->cus_treat_id);
                //     $result = preg_replace('/[^0-9]/', '', $slice[0]); 
                //     $numbers[] = $result; 
                // } 

                // rsort($numbers);

                // // Get the current year
                // $currentYear = date("y"); // Current year as two digits
                // $invoiceNumber = '001'; // Default invoice number

                // // Define a threshold year (e.g., 25 for 2025)
                // $thresholdYear = '24'; // Adjust this based on your needs

                // if ($currentYear > $thresholdYear) {
                //     // If the year is at or beyond the threshold, always start from 001
                //     if (count($treatment_auto_id) > 0) {
                //         $invoiceNumber = '001'; // Reset to 001 for years beyond threshold
                //     }
                // } else {
                //     // For years below the threshold, check if there are treatment records
                //     if (count($treatment_auto_id) > 0) {
                //         // Check if there are treatment records for the current year
                //         $yearRecords = array_filter($numbers, function($num) use ($currentYear) {
                //             return strpos($num, '/' . $currentYear) !== false; // Check if the number includes the current year
                //         });

                //         // If records exist for the current year, set the invoice number accordingly
                //         if (!empty($yearRecords)) {
                //             $result = max($yearRecords); // Get the highest number for that year
                //             $invoiceNumber = $result + 1; // Increment the highest number found
                //         }
                //     }
                // }

                // // Function to format the invoice number
                // function invoice_num($input, $pad_len = 3, $prefix = null) {
                //     if (is_string($prefix))
                //         return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
                //     return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
                // }

                // // Format the invoice number with prefix
                // $response = invoice_num($invoiceNumber, 3, "-TR-");
                // // Create the final invoice string
                // $invoice = $branch->branch_code . $response . '/' . $currentYear; // Only year included




                //return $invoice;
                $tc_id           = $request->tc_id;
                $treatment_id    = $request->treatment_id;
                $customer_id     = $request->customer_name;
                $progress        = $request->progress;
                $medicine        = $request->madicine;
                $remarks         = $request->remarks;
                $amount          = $request->amount;
                //  $discount        = $request->discount;

                $treatmentNewOld = Treatment::select('amount')
                                ->where('treatment_id',$request->treatment_id)->first();

                $add_cus_treatment   = new CustomerTreatment;

                $add_cus_treatment->treatment_auto_id              = $invoice;
                // return $add_cus_treatment->treatment_auto_id;
                $add_cus_treatment->tc_id              = $tc_id;
                $add_cus_treatment->treatment_id       = $treatment_id;
                $add_cus_treatment->customer_id        = $customer_id;
                $add_cus_treatment->progress           = $progress;
                $add_cus_treatment->medicine_prefered  = $medicine;
                $add_cus_treatment->remarks            = $remarks;
                $add_cus_treatment->amount             = $treatmentNewOld->amount;
                $add_cus_treatment->discount           = 0;
                $add_cus_treatment->created_by         = $request->user()->id;
                $add_cus_treatment->modified_by        = $request->user()->id;
                // return $add_cus_treatment;
                $add_cus_treatment->save();

                if ($add_cus_treatment) {

                    $result =   response([
                        'status'    => 200,
                        'message'   => 'Customer Treatment has been created successfully',
                        'error_msg' => null,
                        'data'      => null,
                    ], 200);
                } else {

                    $result =   response([

                        'status'    => 401,
                        'message'   => 'Treatment can not be created',
                        'error_msg' => 'Treatment information is worng please try again',
                        'data'      => null,
                    ], 401);
                }
            }
        }

        return $result;
    }

    public function Edit($id)
    {

        $treatment = CustomerTreatment::select(
                        'customer.branch_id', // <-- add this
                        'treatment.treatment_id', 
                        'treatment.treatment_name', 
                        'treatment_category.tcategory_id', 
                        'treatment_category.tc_name', 
                        'customer_treatment.status', 
                        'customer.customer_id', 
                        'customer.customer_first_name', 
                        'customer_treatment.cus_treat_id', 
                        'customer_treatment.progress', 
                        'customer_treatment.medicine_prefered', 
                        'customer_treatment.remarks', 
                        'customer_treatment.amount', 
                        'customer_treatment.discount', 
                        'customer.customer_last_name', 
                        'customer.customer_phone'
                    )
                    ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'customer_treatment.tc_id')
                    ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')
                    ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
                    ->where('customer_treatment.cus_treat_id', $id)
                    ->get();
        return response([
            'data' => $treatment,
            'status' => 200
        ], 200);
    }
    public function Update($id, Request $request)
    {

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {


            $tc_id            = $request->tc_id;
            $treatment_id     = $request->treatment_id;
            $customer_id      = $request->customer_name;
            $progress         = $request->progress;
            $medicine         = $request->medicine;
            $remarks          = $request->remarks;
            $amount           = $request->amount;
            $discount         = $request->discount;


            // $chk_cus = CustomerTreatment::where('treatment_id',$treatment_id)->where('customer_id',$customer_id)->where('progress','!=', 0)->first();
            $chk_cus = CustomerTreatment::where('cus_treat_id', $id)->where('progress', '!=', 0)->first();
            if ($chk_cus) {
                $chk = Appointment::where('customer_id', $customer_id)->where('treatment_id', $treatment_id)->where('app_status', 2)->first();

                if ($chk) {

                    $upd_cus_treatment = CustomerTreatment::where('cus_treat_id', $id)->first();
                    $treatment = Treatment::where('treatment_id', $treatment_id)->first();

                    $upd_cus_treatment->tc_id              = $tc_id;
                    $upd_cus_treatment->treatment_id       = $treatment_id;
                    $upd_cus_treatment->customer_id        = $customer_id;
                    $upd_cus_treatment->amount             = $treatment->amount;
                    $upd_cus_treatment->modified_by        = $request->user()->id;
                    $upd_cus_treatment->update();

                    return   response([
                        'status'    => 200,
                        'message'   => 'successfull updated',
                        'error_msg' => null,
                        'data'      => $upd_cus_treatment,
                    ], 200);
                } else {
                    return response([
                        'status'    => 401,
                        'message'   => 'Treatment Already Asigned',
                        'error_msg' => null,
                        'data'      => null,
                    ], 401);
                }
            } else {
                $upd_cus_treatment = CustomerTreatment::where('cus_treat_id', $id)->first();

                $treatment = Treatment::where('treatment_id', $treatment_id)->first();
                $upd_cus_treatment->tc_id              = $tc_id;
                $upd_cus_treatment->treatment_id       = $treatment_id;
                $upd_cus_treatment->customer_id        = $customer_id;
                $upd_cus_treatment->amount             = $treatment->amount;
                $upd_cus_treatment->modified_by        = $request->user()->id;
                $upd_cus_treatment->update();

                return   response([
                    'status'    => 200,
                    'message'   => 'successfull updated',
                    'error_msg' => null,
                    'data'      => $upd_cus_treatment,
                ], 200);
            }



            // if($chk){
            //     return response([
            //         'status'    => 200,
            //         'message'   => 'Appointment Already fixed',
            //         'error_msg' => null,
            //         'data'      => null,
            //     ],200);
            // }else{

            // }


            // $upd_cus_treatment = CustomerTreatment::where('cus_treat_id',$id)->first();

            // $upd_cus_treatment->tc_id              = $tc_id;
            // $upd_cus_treatment->treatment_id       = $treatment_id;
            // $upd_cus_treatment->customer_id        = $customer_id;
            // $upd_cus_treatment->progress           = $progress;
            // $upd_cus_treatment->medicine_prefered  = $medicine;
            // $upd_cus_treatment->remarks            = $remarks;
            // $upd_cus_treatment->amount             = $amount;
            // $upd_cus_treatment->discount           = $discount;
            // $upd_cus_treatment->modified_by        = $request->user()->id;
            // $upd_cus_treatment->update();

            // $result =   response([
            //                         'status'    => 200,
            //                         'message'   => 'successfull updated',
            //                         'error_msg' => null,
            //                         'data'      => $upd_cus_treatment,
            //                     ],200);
        }
    }
    public function Delete($id)
    {
        $status = CustomerTreatment::where('cus_treat_id', $id)->first();

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
    public function Completed($id)
{
    $status = CustomerTreatment::where('cus_treat_id', $id)->first();

    if ($status) {
        $status->complete_status = 1;
        $status->update();
    }

    return response([
        'data' => null,
        'message' => 'Successfully Completed',
        'status' => 200
    ], 200);
}
    // public function Completed($id)
    // {
    //     $status = CustomerTreatment::where('cus_treat_id', $id)->first();

    //     if ($status) {
    //         $status->complete_status = 1;
    //         $status->update();
    //     }
    //     return response([
    //         'data' => null,
    //         'message' => 'Successfully Completed',
    //         'status' => 200
    //     ], 200);
    // }
    public function Status(Request $request, $id)
    {

        $cus_treatement_status = CustomerTreatment::where('cus_treat_id', $id)->first();

        if ($cus_treatement_status) {
            $cus_treatement_status->status = $request->status;
            $cus_treatement_status->modified_by        = $request->user()->id;
            $cus_treatement_status->update();
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

    public function Invoice($id, Request $request)
    {


        // $result = [];
        // $customers =  Customer::all();
        // $cus_trt_cat = TreatmentCategory::all();

        // foreach($customers as $cus){



        //         foreach($cus_trt_cat as $tmt){

        //             $cus_treatment_fix = CustomerTreatment::select('customer_treatment.customer_id','customer_treatment.progress','customer_treatment.remarks','customer_treatment.amount','treatment.treatment_id','treatment.treatment_name','treatment_category.tcategory_id','treatment_category.tc_name','customer.customer_id','customer.customer_first_name','customer.customer_last_name')->where('customer_treatment.customer_id',$cus['customer_id'])->where('customer_treatment.tc_id',$tmt['tcategory_id'])
        //             ->join('treatment', 'treatment.treatment_id','=','customer_treatment.treatment_id')
        //             ->join('treatment_category', 'treatment_category.tcategory_id','=','customer_treatment.tc_id')
        //             ->join('customer', 'customer.customer_id','=','customer_treatment.customer_id')
        //             ->where('customer_treatment.status', '!=', 2)->where('customer_treatment.progress', '!=', 0)->get();

        //             if(count($cus_treatment_fix) != 0){

        //                 $total_amount = CustomerTreatment::where('customer_id',$cus['customer_id'])->where('tc_id',$tmt['tcategory_id']) ->where('status', '!=', 2)->where('progress', '!=', 0)->sum('amount');

        //                 //$total_amount = 0;



        //                 $result[] = [
        //                             'tc_id'   => $tmt['tcategory_id'],
        //                             'tc_name' => $tmt['tc_name'],
        //                             'customer_id' => $cus_treatment_fix[0]['customer_id'],
        //                             'customer_name' => $cus_treatment_fix[0]['customer_first_name'].$cus_treatment_fix[0]['customer_last_name'],
        //                             'treament'  =>$cus_treatment_fix,
        //                             'total_amount' => $total_amount,
        //                             'progress' =>$cus_treatment_fix[0]['progress'],
        //                             'data'    =>  $cus_treatment_fix,
        //                         ];

        //             }

        //         }


        // }




        $cus_treatment = CustomerTreatment::select('treatment.treatment_id', 'treatment.treatment_name', 'treatment_category.tcategory_id', 'treatment_category.tc_name', 'customer_treatment.status', 'customer.customer_id', 'customer.customer_first_name', 'customer_treatment.cus_treat_id', 'customer_treatment.progress', 'customer_treatment.medicine_prefered', 'customer_treatment.remarks', 'customer_treatment.amount', 'customer_treatment.discount', 'customer_treatment.generate_invoice')
            ->where('customer_treatment.customer_id', $id)
            ->join('treatment_category', 'treatment_category.tcategory_id', '=', 'customer_treatment.tc_id')
            ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')
            ->join('customer', 'customer.customer_id', '=', 'customer_treatment.customer_id')
            // ->join('branch', 'branch.branch_id','=','customer.branch_id')
            // ->where('customer_treatment.status', '!=', 2)
            // ->where('customer_treatment.generate_invoice', '!=', 1)
            // ->where('customer_treatment.progress', '!=', 0)
            ->where('customer_treatment.status', '<', '2')
            ->where('customer_treatment.generate_invoice', '=', 0)
            ->where('customer_treatment.progress', '!=', '0')
            ->get();

        // if(isset($request->branch_id)){
        //     if($request->branch_id > 0){
        //         $cus_treatment = $cus_treatment->where('staff.branch_id',$request->branch_id);
        //     } 
        //  }          
        //   return $cus_treatment;
        $result = [];

        foreach ($cus_treatment as $item) {

            $status = Payment::where('tcate_id', $item->tcategory_id)->where('treatment_id', $item->treatment_id)->where('customer_id', $item->customer_id)->where('balance', '=', '0')->first();
            $p_id = 0;
            if ($status) {
                $invoice = 0; //completed
                $p_id    = $status->p_id;
            } else {
                $invoice = 1; //pending
            }

            $result[] = [
                'p_id'               => $p_id,
                'treatment_id'       => $item->treatment_id,
                'treatment_name'     => $item->treatment_name,
                'tcategory_id'       => $item->tcategory_id,
                'tc_name'            => $item->tc_name,
                'status'             => $item->status,
                'customer_id'        => $item->customer_id,
                'customer_first_name' => $item->customer_first_name,
                'cus_treat_id'       => $item->cus_treat_id,
                'progress'           => $item->progress,
                'medicine_prefered'  => $item->medicine_prefered,
                'remarks'            => $item->remarks,
                'amount'             => $item->amount,
                'discount'           => $item->discount,
                'balance'            => $invoice,
            ];
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ], 200);
    }

    function Customer(Request $request)
    {

        // $cus_treatment = CustomerTreatment::select('treatment.treatment_id','treatment.treatment_name','treatment_category.tcategory_id','treatment_category.tc_name','customer_treatment.status','customer.customer_id','customer.customer_first_name','customer_treatment.cus_treat_id','customer_treatment.progress','customer_treatment.medicine_prefered','customer_treatment.remarks','customer_treatment.amount','customer_treatment.discount','customer.branch_id')
        //                         ->join('treatment_category', 'treatment_category.tcategory_id','=','customer_treatment.tc_id')
        //                         ->join('treatment', 'treatment.treatment_id','=','customer_treatment.treatment_id')
        //                         ->join('customer', 'customer.customer_id','=','customer_treatment.customer_id')
        //                         ->where('customer_treatment.status', '!=', 2)
        //                         ->where('customer_treatment.progress', '!=', 0);//->get();

        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->id)->first();

        // if($branch->role_id != 1){
        //     $cus_treatment = $cus_treatment->where('customer.branch_id',$branch->branch_id);
        // }

        // $cus_treatment = $cus_treatment->get();                     

        // $result = [];

        // foreach($cus_treatment as $item){

        //     $status = Payment::where('tcate_id',$item->tcategory_id)->where('treatment_id',$item->treatment_id)->where('customer_id',$item->customer_id)->where('balance','=','0')->first();
        //     $p_id = 0;
        //     if($status){
        //         $invoice = 0;//completed
        //         $p_id    = $status->p_id;
        //     }else{
        //         $invoice = 1;//pending
        //     }

        //     $result[] = [

        //                     'customer_id'        =>$item->customer_id,
        //                     'customer_first_name'=>$item->customer_first_name,
        //                 ];
        // }

        // function my_array_unique($array, $keep_key_assoc = false){
        //     $duplicate_keys = array();
        //     $tmp = array();       

        //     foreach ($array as $key => $val){
        //         // convert objects to arrays, in_array() does not support objects
        //         if (is_object($val))
        //             $val = (array)$val;

        //         if (!in_array($val, $tmp))
        //             $tmp[] = $val;
        //         else
        //             $duplicate_keys[] = $key;
        //     }

        //     foreach ($duplicate_keys as $key)
        //         unset($array[$key]);

        //     return $keep_key_assoc ? $array : array_values($array);
        // }

        // return response([
        //                     'status'    => 200,
        //                     'message'   => 'Success',
        //                     'error_msg' => null,
        //                     'data'      => my_array_unique($result),
        //                 ],200);




        $customers = Customer::where('status', 0);

        $staff = Staff::select('branch_id', 'role_id')->where('staff_id', $request->user()->staff_id)->first();

        // if($staff->role_id != 1){
        //     $customers = $customers->where('branch_id',$staff->branch_id);
        // }
        if ($request->branch_id > 0) {
            $idArray = explode(',', $request->branch_id); // Convert the comma-separated string to an array
            $customers = $customers->where('customer.branch_id', $request->branch_id);
        }
        $customers = $customers->get();

        $result = [];

        foreach ($customers as $item) {

            $branch = Branch::where('branch_id', $item->branch_id)->first();


            $result[] = [

                'customer_id'        => $item->customer_id,
                'customer_first_name' => $item->customer_first_name . " " . $item->customer_last_name,
                'branch_name'             => $branch ? $branch->branch_name : "",
                'branch_id'             => $item->branch_id
            ];
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ], 200);
    }

    function Treatment($id)
    {
        //   return $id;
        $cus_treatment = CustomerTreatment::select('customer_treatment.treatment_id', 'treatment.treatment_name')
            ->join('treatment', 'treatment.treatment_id', '=', 'customer_treatment.treatment_id')->where('customer_treatment.status', '!=', 2)->where('customer_treatment.progress', '!=', 1)->where('customer_treatment.customer_id', $id)->get();
        // select('treatment.treatment_id','treatment.treatment_name')
        //                        // ->where('customer_treatment.customer_id',$id)
        //                         ->join('treatment', 'treatment.treatment_id','=','customer_treatment.treatment_id')
        //                         ->where('customer_treatment.status', '!=', 2)
        //                         ->where('customer_treatment.progress', '!=', 0)
        //                         ->get();

        $cus = Customer::where('customer_id', $id)->first();

        if ($cus) {
            $mobile = $cus->customer_phone;
        } else {
            $lead = Lead::where('lead_id', $id)->first();
            if ($lead) {
                $mobile = $lead->lead_phone;
            } else {
                $mobile = null;
            }
        }

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $cus_treatment,
            'mobile'    => $mobile
        ], 200);
    }
}