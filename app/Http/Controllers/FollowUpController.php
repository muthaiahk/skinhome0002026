<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Followup;
use App\Models\Role;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\Notification;

class FollowUpController extends Controller
{
    //

    public function All(Request $request)
    {
        $branch_id = $request->branch_id;
        $followup = Followup::select('lead.*', 'followup_history.*', 'branch.branch_name')
            ->where('followup_history.status', '!=', 2)
            ->join('lead', 'lead.lead_id', '=', 'followup_history.lead_id')
            ->join('branch', 'branch.branch_id', '=', 'lead.branch_id')
            ->orderBy('followup_id', 'desc');

        if (isset($branch_id) && $branch_id > 0) {
            $idArray = explode(',', $branch_id); 
            $followup = $followup->whereIn('lead.branch_id', $idArray);
        }


        if (isset($request->from) && isset($request->to)) {
            $followup = $followup->whereBetween('followup_date', [$request->from, $request->to]);
        }

        $search_input = $request->input('search_input', '');
        if (isset($search_input)) {
            // return $search_input;
            $followup->where(function ($query) use ($search_input) {
                $query->where('lead.lead_first_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('lead.lead_last_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('branch.branch_name', 'LIKE', "%{$search_input}%")
                    ->orWhere('lead.lead_email', 'LIKE', "%{$search_input}%")
                    ->orWhere('lead.lead_phone', 'LIKE', "%{$search_input}%");
            });
        }

        $page = $request->input('page', 1); // Default to page 1
        $limit = $request->input('limit', 10); // Default limit
        // Get the total count for pagination
        $total = $followup->count();
        $followup = $followup->skip(($page - 1) * $limit)->take($limit)->get();

        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $followup,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ], 200);
    }
    public function showFollowups(Request $request)
{
    // Get all followups for example
   $followups = Followup::select('lead.*', 'followup_history.*', 'branch.branch_name', 'branch.branch_id')
    ->where('followup_history.status', '!=', 2)
    ->join('lead', 'lead.lead_id', '=', 'followup_history.lead_id')
    ->join('branch', 'branch.branch_id', '=', 'lead.branch_id')
    ->orderBy('followup_id', 'desc')
    ->get();

    $Branchs = Branch::where('status','!=',2)->get();
     return view('followup', compact('followups', 'Branchs'));
}
    public function Add(Request $request)
    {


        $lead_id                  = $request->lead_id;
        $followup_date            = $request->followup_date;
        $next_followup_date       = $request->next_followup_date;
        $app_status               = $request->app_status;
        $remark                   = $request->remark;

        $flw = Followup::where('lead_id', $lead_id)->orderBy('followup_count', 'desc')->first();

        if ($flw) {

            $flw_chk = Followup::where('lead_id', $lead_id)->whereBetween('followup_date', [$next_followup_date, $next_followup_date])->first();

            if ($flw_chk) {
                return response([
                    'status'    => 200,
                    'message'   => 'Followup halready Assigned',
                    'error_msg' => null,
                    'data'      => null,
                ], 200);
            } else {

                $flw->app_status = 1;
                $flw->update();

                $followup   = new Followup;

                $followup->lead_id                  = $lead_id;
                $followup->followup_count           = $request->followup_count + 1;
                $followup->followup_date            = $next_followup_date;
                $followup->next_followup_date       = $next_followup_date;
                $followup->app_status               = $app_status;
                $followup->remark                   = $remark;
                $followup->created_by               = 1;
                $followup->created_on               = date('Y-m-d H:i:s');
                $followup->modified_by              = 1;
                $followup->modified_on              = date('Y-m-d H:i:s');
                $followup->status                   = 0;

                $followup->save();

                if ($followup) {

                    $add_notify = new Notification();

                    $add_notify->content      = " New Lead Follow-up On" . ($followup_date);

                    $add_notify->title        = "New Follow-up";

                    $add_notify->sender_id    = $request->user()->staff_id;

                    $add_notify->receiver_id  = 1;

                    $add_notify->alert_status = 2;

                    $add_notify->created_by   = $request->user()->staff_id;

                    $add_notify->updated_by   = $request->user()->staff_id;



                    $add_notify->save();
                }


                return response([
                    'status'    => 200,
                    'message'   => 'Followup has been created successfully',
                    'error_msg' => null,
                    'data'      => null,
                ], 200);
            }
        } else {

            $followup   = new Followup;

            $followup->lead_id                  = $lead_id;
            $followup->followup_count           = $request->followup_count + 1;
            $followup->followup_date            = $next_followup_date;
            $followup->next_followup_date       = $next_followup_date;
            $followup->app_status               = $app_status;
            $followup->remark                   = $remark;
            $followup->created_by               = 1;
            $followup->created_on               = date('Y-m-d H:i:s');
            $followup->modified_by              = 1;
            $followup->modified_on              = date('Y-m-d H:i:s');
            $followup->status                   = 0;

            $followup->save();


            if ($followup) {

                $add_notify = new Notification();

                $add_notify->content      = " New Lead Follow-up On " . ($followup_date);

                $add_notify->title        = "New Follow-up";

                $add_notify->sender_id    = $request->user()->staff_id;

                $add_notify->receiver_id  = 1;

                $add_notify->alert_status = 2;

                $add_notify->created_by   = $request->user()->staff_id;

                $add_notify->updated_by   = $request->user()->staff_id;



                $add_notify->save();
            }
            return response([
                'status'    => 200,
                'message'   => 'Followup has been created successfully',
                'error_msg' => null,
                'data'      => null,
            ], 200);
        }






        // if($flw){

        //     $followup   = new Followup;

        //     $followup->lead_id                  = $lead_id;
        //     $followup->followup_count           = $request->followup_count;
        //     $followup->followup_date            = $flw->next_followup_date;
        //     $followup->next_followup_date       = $next_followup_date;
        //     $followup->app_status               = 0;
        //     $followup->remark                   = $remark;
        //     $followup->created_by               = 1;
        //     $followup->created_on               = date('Y-m-d H:i:s');
        //     $followup->modified_by              = 1;
        //     $followup->modified_on              = date('Y-m-d H:i:s');
        //     $followup->status                   = 0;

        //     $followup->save();

        //     $flw->app_status = 1;
        //     $flw->update();


        // }else{

        //     $followup   = new Followup;

        //     $followup->lead_id                  = $lead_id;
        //     $followup->followup_count           = $request->followup_count;;
        //     $followup->followup_date            = $followup_date;
        //     $followup->next_followup_date       = $next_followup_date;
        //     $followup->app_status               = 0;
        //     $followup->remark                   = $remark;
        //     $followup->created_by               = 1;
        //     $followup->created_on               = date('Y-m-d H:i:s');
        //     $followup->modified_by              = 1;
        //     $followup->modified_on              = date('Y-m-d H:i:s');
        //     $followup->status                   = 0;

        //     $followup->save();

        //     return response([
        //                         'status'    => 200,
        //                         'message'   => 'Followup has been created successfully',
        //                         'error_msg' => null,
        //                         'data'      => null ,
        //                     ],200);

        // }




        // if($followup){

        //     // $flw = Followup::where('followup_id',$request->followup_id)->first();
        //     // if($flw){
        //     //     $flw->app_status = 1;
        //     //     $flw->update();
        //     // }
        //     $result =   response([
        //                             'status'    => 200,
        //                             'message'   => 'Followup has been created successfully',
        //                             'error_msg' => null,
        //                             'data'      => null ,
        //                         ],200);

        // }else{

        //     $result =   response([
        //             'status'    => 401,
        //             'message'   => 'Followup can not be created',
        //             'error_msg' => 'Followup information is worng please try again',
        //             'data'      => null ,
        //         ],401);
        // }


        // }

        //return $result;

    }

    public function Edit(Request $request, $id)
    {

        $followup = Followup::where('lead_id', $id);

        if (isset($request->from_date) && isset($request->to_date)) {
            $followup->whereBetween('followup_date', [$request->from_date, $request->to_date]);
        }
        if (isset($request->pn_status)) {
            $followup->where('app_status', $request->pn_status);
        }

        $followup_data = $followup->get();

        return response([
            'data' => $followup_data,
            'status' => 200
        ], 200);
    }

    public function Update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'role_name' => 'required|unique:role,role_name,' . $id . ',role_id',

        ]);


        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {

            $che_status = Role::first();

            $status = Role::where('role_id', $id)->first();

            if ($che_status->role_id != $status->role_id) {
                if ($status) {
                    $role_name        = $request->role_name;
                    $role_description = $request->role_description;

                    $role = Role::find($id);

                    $role->role_name        = $role_name;
                    $role->role_description = $role_description;

                    $role->update();

                    $result =   response([
                        'status'    => 200,
                        'message'   => 'success',
                        'error_msg' => null,
                        'data'      => $role,
                    ], 200);
                }
            } else {
                return response([
                    'data' => null,
                    'message' => 'Not to Permission to update this record',
                    'status' => 401
                ], 200);
            }
        }

        return $result;
    }
    public function Delete($id)
    {

        $che_status = Role::first();

        $status = Role::where('role_id', $id)->first();

        if ($che_status->role_id != $status->role_id) {
            if ($status) {
                $status->status = 2;
                $status->update();
            }
            return response([
                'data' => null,
                'message' => 'Successfully Delete',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'Not to Permission to delete this record',
                'status' => 401
            ], 200);
        }
    }
    public function Status(Request $request, $id)
    {

        $che_status = Role::first();

        $status = Role::where('role_id', $id)->first();

        if ($che_status->role_id != $status->role_id) {

            if ($status) {
                $status->status = $request->status;
                $status->update();
            }
            return response([
                'data' => null,
                'message' => 'Successfully Updated',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'Not to Permission to Update this record',
                'status' => 401
            ], 200);
        }
    }

    public function Completed($id)
    {
        $upd_exp = Followup::where('lead_id', $id)->first();
        $upd_exp->app_status     = 2;
        $upd_exp->update();

        return response([
            'data' => null,
            'message' => 'Successfully Completed',
            'status' => 200
        ], 200);
    }
}