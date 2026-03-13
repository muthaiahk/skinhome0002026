<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\AppointmentPayment;
use App\Models\Company;
use App\Models\Staff;
use App\Models\User;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Treatment;
use App\Models\Notification;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerTreatment;
use App\Models\Branch;

class AppointmentController extends Controller
{
    //
    public function All(Request $request)
    {
        $app = Appointment::select('appointment.appointment_id', 'appointment.company_id', 'company.company_name', 'appointment.problem', 'appointment.remark', 'appointment.status', 'appointment.staff_id', 'appointment.lead_id', 'appointment.customer_id', 'appointment.app_status', 'appointment.lead_status_id', 'staff.name as staff_name', 'appointment.tc_id', 'appointment.treatment_id', 'appointment.date', 'appointment.time')
            ->leftjoin('company', 'company.company_id', '=', 'appointment.company_id')
            ->leftjoin('staff', 'staff.staff_id', '=', 'appointment.staff_id')
            ->where('appointment.status', '!=', 2)
            ->orderBy('appointment.appointment_id', 'desc');

        if (isset($request->branch_id)) {
            if ($request->branch_id > 0) {
                $app = $app->where('appointment.branch_id', $request->branch_id);
            }
        }

        if (isset($request->from) && isset($request->to)) {
            $app = $app->whereBetween('date', [$request->from, $request->to]);
        }

        // $page = $request->input('page', 1); // Default to page 1
        // $limit = $request->input('limit', 10); // Default limit
        // // Get the total count for pagination
        // $total = $app->count();
        $app = $app->get();

        //   return $app;

        $data = [];

        foreach ($app as $key =>  $value) {

            if ($value->customer_id) {

                $user_id = $value->customer_id;
                $customer = Customer::where('customer_id', $user_id)->first();
                $username = $customer->customer_first_name . " " . $customer->customer_last_name;
                $phone = $customer ? $customer->customer_phone : '';
                $user_status = "Customer";
                $category = TreatmentCategory::where('tcategory_id', $value->tc_id)->first();
                $tc_name =  $category ? $category->tc_name : '';
                $treatment = Treatment::where('treatment_id', $value->treatment_id)->first();
                $treatment_name = $treatment ? $treatment->treatment_name : '';
                $problem = $treatment_name;
                $branch_id = $customer->branch_id;

            } else {

                $user_id = $value->lead_id;
                $lead = Lead::where('lead_id', $user_id)->first();
                $first = $lead ? $lead->lead_first_name : '';
                $last = $lead ? $lead->lead_last_name : '';
                $username = $first . " " . $last;
                $phone = $lead ? $lead->lead_phone : '';
                $user_status = "Lead";
                $tc_name = "";
                $treatment_name = "";
                $problem = $value->problem;
                $branch_id = $lead ? $lead->branch_id : 0;

            }

            $data[$key] = [

                'appointment_id' =>  $value->appointment_id,
                'date'           => $value->date,
                'time'           => $value->time,
                'user_id'        => $user_id,
                'user_name'      => $username,
                'phone'           => $phone,
                'company_id'     => $value->company_id,
                'company_name'   => $value->company_name,
                'staff_id'       => $value->staff_id,
                'staff_name'     => $value->staff_name,
                'tc_id'          => $value->tc_id,
                'tc_name'        => $tc_name ? $tc_name : '',
                'treatment_id' => $value->treatment_id,
                'treatment_name' => $treatment_name,
                // 'lead_status_id'=> $value->lead_status_id,
                // 'lead_status_name'=> $value->lead_status_name,
                'app_status' => $value->app_status,
                'problem' => $problem,
                'remark' => $value->remark == '' ? '' : $value->remark,
                'status' => $value->status,
                'user_status' => $user_status,
                'branch_id' => $branch_id

            ];
        }

        $branch_id = $request->branch_id;
        $data1 = [];

        foreach ($data as $k => $d) {
            if ($branch_id > 0) {
                if ($d['branch_id'] == $branch_id) {
                    $data1[] = [

                        'appointment_id' => $d['appointment_id'],
                        'date'           => $d['date'],
                        'time'           => $d['time'],
                        'user_id'        => $d['user_id'],
                        'user_name'      => $d['user_name'],
                        'phone'          => $d['phone'],
                        'company_id'     => $d['company_id'],
                        'company_name'   => $d['company_name'],
                        'staff_id'       => $d['staff_id'],
                        'staff_name'     => $d['staff_name'],
                        'tc_id'          => $d['tc_id'],
                        'tc_name'        => $d['tc_name'],
                        'treatment_id'   => $d['treatment_id'],
                        'treatment_name' => $d['treatment_name'],
                        // 'lead_status_id'=> $d['lead_status_id'],
                        // 'lead_status_name'=> $d['lead_status_name'],
                        'app_status'     => $d['app_status'],

                        'problem'        => $d['problem'],
                        'remark'   => $d['remark'],
                        'status' => $d['status'],
                        'user_status' => $d['user_status'],
                        'branch_id' => $d['branch_id']

                    ];
                }
            } else {
                $data1[] = [

                    'appointment_id' => $d['appointment_id'],
                    'date'           => $d['date'],
                    'time'           => $d['time'],
                    'user_id'        => $d['user_id'],
                    'user_name'      => $d['user_name'],
                    'phone'          => $d['phone'],
                    'company_id'     => $d['company_id'],
                    'company_name'   => $d['company_name'],
                    'staff_id'       => $d['staff_id'],
                    'staff_name'     => $d['staff_name'],
                    'tc_id'          => $d['tc_id'],
                    'tc_name'        => $d['tc_name'],
                    'treatment_id' => $d['treatment_id'],
                    'treatment_name' => $d['treatment_name'],
                    // 'lead_status_id'=> $d['lead_status_id'],
                    // 'lead_status_name'=> $d['lead_status_name'],
                    'app_status' => $d['app_status'],
                    'problem' => $d['problem'],
                    'remark' => $d['remark'],
                    'status' => $d['status'],
                    'user_status' => $d['user_status'],
                    'branch_id' => $d['branch_id']

                ];
            }
        }
        $Branchs = Branch::where('status','!=',2)->get();
        $Customers = Customer::where('status','!=',2)->get();
        $Treatments = Treatment::where('status','!=',2)->get();
        $Company = Company::first();

        return view('appointment',[
            'appointments'=>$data,
            'Branchs' => $Branchs,
            'Customers' => $Customers,
            'Treatments' => $Treatments,
            'Company' => $Company
        ]);
    }
    public function Add(Request $request)
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

            $company = Company::where('company_name', $request->company_name)->first();
            $staff = Staff::where('name', $request->app_staff_name)->first();
            $treatment = Treatment::where('treatment_id', $request->app_treatment_id)->first();



            $company_id         = $company->company_id;
            $user_id            = $request->user_id;

            $app_problem        = $request->app_problem;
            // $app_tc_id          = $treatment->tc_id;
            $app_treatment_id   = $request->app_treatment_id;
            $app_staff_id       = $request->user()->staff_id;
            $app_pn_status      = 0;
            $app_lead_status_id = 0;
            $app_remark         = $request->app_remark;
            $date               = $request->app_date;
            $time               = $request->app_time;





            $add_app   = new Appointment;

            if ($request->is_customer == 0) {

                $chk_app = Appointment::where('app_status', '!=', 2)->where('treatment_id', $app_treatment_id)->where('customer_id', $user_id)->where('date', $date)->first();

                if ($chk_app) {
                    return response([
                        'status'    => 401,
                        'message'   => 'Appointment already Fixed',
                        'error_msg' => 'Appointment already Fixed',
                        'data'      => null,
                    ], 401);
                }

                $tc = Treatment::where('treatment_id', $app_treatment_id)->first();
                $customer = Customer::where('customer_id', $user_id)->first();

                $add_app->customer_id           = $user_id;
                $add_app->tc_id                 = $tc->tc_id;
                $add_app->treatment_id          = $app_treatment_id;
                $add_app->branch_id              = $customer->branch_id;
            } else if ($request->is_customer == 1) {

                $chk_app = Appointment::where('lead_id', $user_id)->where('date', $date)->where('time')->first();

                if ($chk_app) {
                    return response([
                        'status'    => 401,
                        'message'   => 'Appointment already Fixed',
                        'error_msg' => 'Appointment already Fixed',
                        'data'      => null,
                    ], 401);
                }
                $lead = Lead::where('lead_id', $user_id)->first();
                $add_app->lead_id               = $user_id;
                $add_app->tc_id                 = null;
                $add_app->treatment_id          = null;
                $add_app->branch_id             = $lead->branch_id;
            }
            $add_app->company_id            = $company_id;
            $add_app->problem               = $app_problem;
            $add_app->staff_id              = $app_staff_id;
            $add_app->app_status            = $app_pn_status;
            $add_app->lead_status_id        = $app_lead_status_id;
            $add_app->remark                = $app_remark;
            $add_app->date                  = $date;
            $add_app->time                  = $time;
            $add_app->created_by            = $request->user()->id;
            $add_app->modified_by           = $request->user()->id;
            $add_app->save();
            if ($add_app) {
                $add_notify = new Notification();
                $add_notify->content      = " Schedule new appointment ";
                $add_notify->title        = "New Appointment";
                $add_notify->sender_id    = $request->user()->staff_id;
                $add_notify->receiver_id  = 1;
                $add_notify->alert_status = 2;
                $add_notify->created_by   = $request->user()->staff_id;
                $add_notify->updated_by   = $request->user()->staff_id;
                $add_notify->save();
            }
            $result =   response([
                'status'    => 200,
                'message'   => 'Appointment has been created successfully',
                'error_msg' => null,
                'data'      => $request->is_coustomer,
            ], 200);
        }
        return $result;
    }
   public function Edit($id)
    {
        $app = Appointment::select(
                'appointment.appointment_id',
                'appointment.company_id',
                'company.company_name',
                'appointment.problem',
                'appointment.remark',
                'appointment.status',
                'appointment.staff_id',
                'appointment.lead_id',
                'appointment.customer_id',
                'appointment.app_status',
                'appointment.lead_status_id',
                'appointment.tc_id',
                'appointment.treatment_id',
                'appointment.date',
                'appointment.time',
                'appointment.branch_id',
                'staff.name as staff_name'
            )
            ->join('company', 'company.company_id', '=', 'appointment.company_id')
            ->join('staff', 'staff.staff_id', '=', 'appointment.staff_id')
            ->where('appointment.status', '!=', 2)
            ->where('appointment.appointment_id', $id)
            ->first(); // Use first() instead of get() since it's one appointment

        if (!$app) {
            return response([
                'status' => 404,
                'message' => 'Appointment not found',
                'data' => null
            ], 404);
        }

        // Determine if it is a Customer or Lead
        if ($app->customer_id) {
            $user = Customer::find($app->customer_id);
            $user_status = "Customer";
            $username = $user->customer_first_name . ' ' . $user->customer_last_name;
            $phone = $user->customer_phone;

            $treatment = Treatment::find($app->treatment_id);
            $treatment_name = $treatment ? $treatment->treatment_name : '';
            $problem = $treatment_name;

        } else {
            $user = Lead::find($app->lead_id);
            $user_status = "Lead";
            $username = $user->lead_first_name . ' ' . $user->lead_last_name;
            $phone = $user->lead_phone;

            $treatment_name = '';
            $problem = $app->problem;
        }

        $data = [
            'appointment_id' => $app->appointment_id,
            'company_id'     => $app->company_id,
            'company_name'   => $app->company_name,
            'staff_id'       => $app->staff_id,
            'staff_name'     => $app->staff_name,
            'branch_id'      => $app->branch_id,
            'user_id'        => $app->customer_id ?? $app->lead_id,
            'user_name'      => $username,
            'phone'          => $phone,
            'user_status'    => $user_status,
            'date'           => $app->date,
            'time'           => $app->time,
            'treatment_id'   => $app->treatment_id,
            'treatment_name' => $treatment_name,
            'problem'        => $problem,
            'remark'         => $app->remark,
            'app_status'     => $app->app_status,
            'lead_status_id' => $app->lead_status_id
        ];

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $data,
        ], 200);
    }


    public function Update(Request $request, $id)
    {
        $company = Company::where('company_name', $request->company_name)->first();
        $staff = Staff::where('name', $request->staff_name)->first();

        if (!$company || !$staff) {
            return response([
                'status' => 400,
                'message' => 'Invalid company or staff',
                'error_msg' => null,
                'data' => null
            ], 400);
        }

        $upd_app = Appointment::where('appointment_id', $id)->first();
        if (!$upd_app) {
            return response([
                'status' => 404,
                'message' => 'Appointment not found',
                'error_msg' => null,
                'data' => null
            ], 404);
        }

        $upd_app->company_id = $company->company_id;
        $upd_app->staff_id = $staff->staff_id;
        $upd_app->date = $request->date;
        $upd_app->time = $request->time;
        $upd_app->remark = $request->remark;
        $upd_app->problem = $request->problem;
        $upd_app->modified_by = $request->user()->id;

        if ($request->is_customer == 1) {
            // Customer
            $upd_app->customer_id = $request->user_id;
            $upd_app->lead_id = null;
            $upd_app->treatment_id = $request->treatment_id;
            $upd_app->tc_id = null;
        } else {
            // Lead
            $upd_app->lead_id = $request->user_id;
            $upd_app->customer_id = null;
            $upd_app->treatment_id = null;
            $upd_app->tc_id = $request->tc_id ?? null;
        }

        $upd_app->update();

        return response([
            'status' => 200,
            'message' => 'Appointment has been updated successfully',
            'error_msg' => null,
            'data' => $request->is_customer
        ], 200);
    }
    public function Delete($id)
    {
        $status = Appointment::where('appointment_id', $id)->first();

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
        $appointment = Appointment::find($id);

            if(!$appointment){
                return response()->json([
                    'status'=>404,
                    'message'=>'Appointment not found'
                ]);
            }

            $appointment->app_status = $request->status;
            $appointment->save();

            return response()->json([
                'status'=>200,
                'message'=>'Status Updated Successfully'
            ]);
    }

    public function Payment(Request $request)
    {

        $app_id = $request->app_id;
        $paid_mode = $request->paid_mode;
        $amount = $request->amount;

        $payment = new AppointmentPayment;
        $payment->app_id        = $app_id;
        $payment->mode          = $paid_mode;
        $payment->amount        = $amount;
        $payment->created_by    = $request->user()->id;
        $payment->updated_by   = $request->user()->id;
        $payment->save();

        if ($payment) {

            $app_upd = Appointment::where('appointment_id', $app_id)->first();

            $app_upd->app_status = 2;
            $app_upd->update();

            return response([
                'data' => null,
                'message' => 'Successfully Added !',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'Payment not updated in database !',
                'status' => 400
            ], 400);
        }
    }

    public function Remark(Request $request, $id)
    {
         $appointment = Appointment::find($id);

    if(!$appointment){
        return response()->json([
            'status'=>404,
            'message'=>'Appointment not found'
        ]);
    }

    $appointment->remark = $request->remark;
    $appointment->save();

    return response()->json([
        'status'=>200,
        'message'=>'Remark saved'
    ]);
    }
}