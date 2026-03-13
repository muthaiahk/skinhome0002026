<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Lead;
use App\Models\Company;
use App\Models\Followup;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\State;
use App\Models\Notification;

class LeadController extends Controller
{

    public function create()
    {
        $branches    = Branch::where('status', '!=',2)->get();
        $staffs      = Staff::where('status', '!=',2)->get();
        $leadSources = LeadSource::where('status','!=',2)->get();
        $leadStatuses= LeadStatus::where('status','!=',2)->get();
        $states      = State::all();
        $Companys = Company::first();

        return view('add_lead', compact('branches', 'staffs','Companys', 'leadSources', 'leadStatuses', 'states'));
    }
   public function leadList()
    {
        $branches = Branch::all();

        $leads = Lead::select(
                    'lead.lead_id',
                    'lead.lead_first_name',
                    'lead.lead_last_name',
                    'lead.lead_phone',
                    'lead.lead_email',
                    'branch.branch_name',
                    'lead_source.lead_source_name',
                    'lead_status.lead_status_name',
                    'lead.lead_problem',
                    'lead.status',
                    DB::raw('(SELECT followup_count FROM followup_history WHERE followup_history.lead_id = lead.lead_id ORDER BY followup_id DESC LIMIT 1) as followup_count')
                )
                ->join('branch','branch.branch_id','=','lead.branch_id')
                ->leftJoin('lead_source','lead_source.lead_source_id','=','lead.lead_source_id')
                ->leftJoin('lead_status','lead_status.lead_status_id','=','lead.lead_status_id')
                ->where('lead.status','!=',2)
                ->orderBy('lead.lead_id','DESC')
                ->get();
        return view('lead',compact('leads','branches'));
    }
    // public function All($id, Request $request)
    // {

    //     $leads = Lead::select('lead.lead_id', 'lead.company_id', 'company.company_name', 'branch.branch_name', 'lead.branch_id', 'lead.staff_id', 'lead.lead_first_name', 'lead.lead_last_name', 'lead.lead_phone', 'lead.lead_email', 'lead_source.lead_source_id', 'lead_source.lead_source_name', 'lead_status.lead_status_id', 'lead_status.lead_status_name', 'lead.lead_problem', 'lead.lead_remark', 'lead.status', 'lead.state_id', 'states.name')
    //         ->leftjoin('company', 'company.company_id', '=', 'lead.company_id')
    //         ->join('branch', 'branch.branch_id', '=', 'lead.branch_id')
    //         ->leftjoin('lead_source', 'lead_source.lead_source_id', '=', 'lead.lead_source_id')
    //         ->leftjoin('lead_status', 'lead_status.lead_status_id', '=', 'lead.lead_status_id')
    //         ->leftjoin('states', 'states.state_id', '=', 'lead.state_id')
    //         ->where('lead.status', '!=', 2)
    //         ->where('convert_status', '!=', 1)
    //         ->orderBy('lead.lead_id', 'DESC');

    //     if (isset($id) && $id > 0) {
    //         $idArray = explode(',', $id); // Convert the comma-separated string to an array
    //         $leads = $leads->whereIn('lead.branch_id', $idArray);
    //     }

    //     $search_input = $request->input('search_input', '');
    //     if (isset($search_input)) {
    //         // return $search_input;
    //         $leads->where(function ($query) use ($search_input) {
    //             $query->where('lead.lead_first_name', 'LIKE', "%{$search_input}%")
    //                 ->orWhere('lead.lead_last_name', 'LIKE', "%{$search_input}%")
    //                 ->orWhere('branch.branch_name', 'LIKE', "%{$search_input}%")
    //                 ->orWhere('lead.lead_email', 'LIKE', "%{$search_input}%")
    //                 ->orWhere('lead.lead_phone', 'LIKE', "%{$search_input}%");
    //         });
    //     }


    //     // if ($id) {
    //     //     if (is_array($id)) {
    //     //         $branchIds = $id;
    //     //     } else {
    //     //         $branchIds = [$id];
    //     //     }
    //     //     $leads = $leads->whereIn('lead.branch_id', $branchIds);
    //     //     // $leads = $leads->where('lead.branch_id',$id);
    //     // }
    //     // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();

    //     // if($id){
    //     //     $leads = $leads->where('lead.branch_id', $id);
    //     // }


    //     $page = $request->input('page', 1); // Default to page 1
    //     $limit = $request->input('limit', 10); // Default limit
    //     // Get the total count for pagination
    //     $total = $leads->count();
    //     $leads = $leads->skip(($page - 1) * $limit)->take($limit)->get();
    //     // return  $leads;
    //     $result = [];

    //     foreach ($leads as $lead) {

    //         $flw = Followup::where('lead_id', $lead['lead_id'])->orderby('followup_id', 'desc')->first();

    //         if ($flw) {
    //             $count =  $flw->followup_count;
    //             $next_date = $flw->next_followup_date;
    //         } else {
    //             $count =  0;
    //             $next_date = null;
    //         }

    //         $result[] = [
    //             'branch_id' => $lead['branch_id'],
    //             'company_id' => $lead['company_id'],
    //             'company_name' => $lead['company_name'],
    //             'lead_email' => $lead['lead_email'],
    //             'lead_first_name' => $lead['lead_first_name'],
    //             'lead_id' => $lead['lead_id'],
    //             'lead_last_name' => $lead['lead_last_name'],
    //             'lead_phone' => $lead['lead_phone'],
    //             'lead_problem' => $lead['lead_problem'],
    //             'lead_remark' => $lead['lead_remark'],
    //             'lead_source_id' => $lead['lead_source_id'],
    //             'lead_source_name' => $lead['lead_source_name'],
    //             'lead_status_id' => $lead['lead_status_id'],
    //             'lead_status_name' => $lead['lead_status_name'],
    //             'staff_id' => $lead['staff_id'],
    //             'state_id' => $lead['state_id'],
    //             'branch_name' => $lead['branch_name'],
    //             'status' => $lead['status'],
    //             'sitting_count' => $count,
    //             'next_flw_date' => date('d-m-Y', strtotime($next_date))
    //         ];
    //     }





    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'data'      => $result,
    //         'total' => $total,
    //         'page' => $page,
    //         'limit' => $limit
    //     ], 200);
    // }
    public function Add(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'lead_phone' => 'required|unique:lead|numeric',
            'lead_email' => 'required|unique:lead|email|max:255',
        ]);


        if ($validator->fails()) {
            $result =   response([
                'status'    => 401,
                'message'   => 'Incorrect format input feilds',
                'error_msg'     => $validator->messages()->get('*'),
                'data'      => null,
            ], 401);
        } else {


            $company = Company::where('company_name', $request->company_name)->first();

            $company_id       = $company->company_id;
            $branch_id        = $request->branch_id;
            $staff_id         = $request->staff_id;
            $lead_first_name  = $request->lead_first_name;
            $lead_last_name   = $request->lead_last_name;
            $lead_dob         = $request->lead_dob;
            $lead_gender      = $request->lead_gender;
            $lead_age         = $request->lead_age;
            $lead_phone       = $request->lead_phone;
            $lead_email       = $request->lead_email;
            $lead_address     = $request->lead_address;
            $treatment_id     = $request->treatment_id;
            $enquiry_date     = $request->enquiry_date;
            $lead_status_id   = $request->lead_status_id;
            $lead_source_id   = $request->lead_source_id;
            $lead_problem     = $request->lead_problem;
            $lead_remark      = $request->lead_remark;
            $state_id         = $request->state_id;





            $add_lead   = new Lead;

            $add_lead->company_id       = $company_id;
            $add_lead->branch_id        = $branch_id;
            $add_lead->staff_id         = $staff_id;
            $add_lead->lead_first_name  = $lead_first_name;
            $add_lead->lead_last_name   = $lead_last_name;
            $add_lead->lead_dob         = $lead_dob;
            $add_lead->lead_gender      = $lead_gender;
            $add_lead->lead_age         = $lead_age;
            $add_lead->lead_phone       = $lead_phone;
            $add_lead->lead_email       = $lead_email;
            $add_lead->lead_address     = $lead_address;
            $add_lead->treatment_id     = $treatment_id;
            $add_lead->enquiry_date     = $enquiry_date;
            $add_lead->lead_status_id   = $lead_status_id;
            $add_lead->lead_source_id   = $lead_source_id;
            $add_lead->lead_problem     = $lead_problem;
            $add_lead->lead_remark      = $lead_remark;
            $add_lead->state_id         = $state_id;

            $add_lead->created_by       = $request->user()->id;
            $add_lead->modified_by      = $request->user()->id;

            $add_lead->save();

            if ($add_lead) {

                $add_notify = new Notification();

                $add_notify->content      = " New Lead Created ";

                $add_notify->title        = "New Lead";

                $add_notify->sender_id    = $request->user()->staff_id;

                $add_notify->receiver_id  = 1;

                $add_notify->alert_status = 2;

                $add_notify->created_by   = $request->user()->staff_id;

                $add_notify->updated_by   = $request->user()->staff_id;



                $add_notify->save();
            }

            if ($add_lead) {

                $result =   response([
                    'status'    => 200,
                    'message'   => 'Lead has been created successfully',
                    'error_msg' => null,
                    'data'      => null,
                ], 200);
            } else {

                $result =   response([
                    'status'    => 401,
                    'message'   => 'Lead can not be created',
                    'error_msg' => 'lead information is worng please try again',
                    'data'      => null,
                ], 401);
            }
        }

        return $result;
    }
    public function Edit($id)
    {

        $branches    = Branch::where('status', '!=',2)->get();
        $staffs      = Staff::where('status', '!=',2)->get();
        $leadSources = LeadSource::where('status','!=',2)->get();
        $leadStatuses= LeadStatus::where('status','!=',2)->get();
        $states      = State::all();
        $Companys = Company::first();

        $lead = Lead::select(
            'lead.*',
            'company.company_name',
            'branch.branch_name',
            'staff.name as staff_name',
            'lead_source.lead_source_name',
            'lead_status.lead_status_name',
            'states.name as state_name'
        )
        ->join('company', 'company.company_id', '=', 'lead.company_id')
        ->join('lead_source', 'lead_source.lead_source_id', '=', 'lead.lead_source_id')
        ->join('lead_status', 'lead_status.lead_status_id', '=', 'lead.lead_status_id')
        ->join('branch', 'branch.branch_id', '=', 'lead.branch_id')
        ->join('states', 'states.state_id', '=', 'lead.state_id')
        ->join('staff', 'staff.staff_id', '=', 'lead.staff_id')
        ->where('lead.lead_id', $id)
        ->first();

        return view('edit_lead', compact('lead','branches', 'staffs','Companys', 'leadSources', 'leadStatuses', 'states'));
    }
    // public function Edit($id)
    // {
    //     $lead = Lead::select('lead.lead_id', 'lead.company_id', 'company.company_name', 'lead.branch_id', 'lead.staff_id', 'lead.lead_first_name', 'lead.lead_last_name', 'lead.lead_phone', 'lead.lead_email', 'lead_source.lead_source_id', 'lead_source.lead_source_name', 'lead_status.lead_status_id', 'lead_status.lead_status_name', 'lead.lead_problem', 'lead.lead_remark', 'lead.status', 'branch.branch_name', 'staff.name as staff_name', 'lead.lead_dob', 'lead.lead_gender', 'lead.lead_age', 'lead.enquiry_date', 'lead.lead_address', 'lead.state_id', 'states.name')
    //         ->join('company', 'company.company_id', '=', 'lead.company_id')
    //         // ->join('treatment', 'treatment.treatment_id','=','lead.treatment_id')
    //         ->join('lead_source', 'lead_source.lead_source_id', '=', 'lead.lead_source_id')
    //         ->join('lead_status', 'lead_status.lead_status_id', '=', 'lead.lead_status_id')
    //         ->join('branch', 'branch.branch_id', '=', 'lead.branch_id')
    //         ->join('states', 'states.state_id', '=', 'lead.state_id')
    //         ->join('staff', 'staff.staff_id', '=', 'lead.staff_id')
    //         ->where('lead.lead_id', $id)
    //         ->get();
    //     return response([
    //         'data' => $lead,
    //         'status' => 200
    //     ], 200);
    // }

    public function Update(Request $request, $id)
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
            $company_id       = $company->company_id;
            $branch_id        = $request->branch_id;
            $staff_id         = $request->staff_id;
            $lead_first_name  = $request->lead_first_name;
            $lead_last_name   = $request->lead_last_name;
            $lead_dob         = $request->lead_dob;
            $lead_gender      = $request->lead_gender;
            $lead_age         = $request->lead_age;
            $lead_phone       = $request->lead_phone;
            $lead_email       = $request->lead_email;
            $lead_address     = $request->lead_address;
            $treatment_id     = $request->treatment_id;
            $enquiry_date     = $request->enquiry_date;
            $lead_status_id   = $request->lead_status_id;
            $lead_source_id   = $request->lead_source_id;
            $lead_problem     = $request->lead_problem;
            $lead_remark      = $request->lead_remark;
            $state_id         = $request->state_id;
            $upd_lead = Lead::find($id);

            $upd_lead->company_id       = $company_id;
            $upd_lead->branch_id        = $branch_id;
            $upd_lead->staff_id         = $staff_id;
            $upd_lead->lead_first_name  = $lead_first_name;
            $upd_lead->lead_last_name   = $lead_last_name;
            $upd_lead->lead_dob         = $lead_dob;
            $upd_lead->lead_gender      = $lead_gender;
            $upd_lead->lead_age         = $lead_age;
            $upd_lead->lead_phone       = $lead_phone;
            $upd_lead->lead_email       = $lead_email;
            $upd_lead->lead_address     = $lead_address;
            $upd_lead->treatment_id     = $treatment_id;
            $upd_lead->enquiry_date     = $enquiry_date;
            $upd_lead->lead_status_id   = $lead_status_id;
            $upd_lead->lead_source_id   = $lead_source_id;
            $upd_lead->lead_problem     = $lead_problem;
            $upd_lead->lead_remark      = $lead_remark;
            $upd_lead->state_id         = $state_id;

            $upd_lead->modified_by      = $request->user()->id;
            $upd_lead->update();

            if ($upd_lead) {

                $add_notify = new Notification();

                $add_notify->content      = " Updated Lead Created ";

                $add_notify->title        = "New Lead";

                $add_notify->sender_id    = $request->user()->staff_id;

                $add_notify->receiver_id  = 1;

                $add_notify->alert_status = 2;

                $add_notify->created_by   = $request->user()->staff_id;

                $add_notify->updated_by   = $request->user()->staff_id;



                $add_notify->save();
            }

            $result =   response([
                'status'    => 200,
                'message'   => 'successfull updated',
                'error_msg' => null,
                'data'      => $upd_lead,
            ], 200);
        }

        return $result;
    }

    public function Delete($id)
    {
        $status = Lead::where('lead_id', $id)->first();

        if ($status) {
            $status->status = 2; // soft delete
            $status->update();
        }

        return response([
            'data' => null,
            'message' => 'Successfully Deleted',
            'status' => 200
        ], 200);
    }

    public function Status(Request $request, $id)
{
    $lead = Lead::find($id);

    if (!$lead) {
        return response([
            'data' => null,
            'message' => 'No data found',
            'status' => 404
        ], 404);
    }

    $lead->status = $request->status; // 1 or 0
    $lead->modified_by = $request->user()->id;
    $lead->save();

    return response([
        'data' => null,
        'message' => 'Successfully Updated',
        'status' => 200
    ], 200);
}
    // public function LeadList(Request $request)
    // {
    //     // Fetch leads with necessary joins and conditions
    //     $leads = Lead::select(
    //         'lead.lead_id',
    //         'lead.lead_first_name',
    //         'lead.lead_last_name',
    //         'lead.lead_phone',
    //         'lead.status',
    //         'lead.convert_status',
    //         'lead.state_id',
    //         'states.name'
    //     )
    //         ->leftJoin('states', 'states.state_id', '=', 'lead.state_id')
    //         ->where('lead.status', '!=', 2)
    //         ->where('convert_status', '!=', 1)
    //         ->orderBy('lead.lead_id', 'DESC')
    //         ->get(); // Fetch leads directly

    //     // Return the response
    //     return response()->json([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'data'      => $leads,
    //     ]);
    // }
    public function LeadListView()
    {
        $leads = Lead::select(
            'lead.lead_id',
            'lead.lead_first_name',
            'lead.lead_last_name',
            'lead.lead_phone',
            'lead.status',
            'lead.convert_status',
            'lead.state_id',
            'states.name'
        )
            ->leftJoin('states', 'states.state_id', '=', 'lead.state_id')
            ->where('lead.status', '!=', 2)
            ->where('convert_status', '!=', 1)
            ->orderBy('lead.lead_id', 'DESC')
            ->get(); 

        return view('lead', compact('leads'));
    }
    public function Search($id)
    {

        $leads = Lead::select('lead.lead_id', 'lead.company_id', 'company.company_name', 'lead.branch_id', 'lead.staff_id', 'lead.lead_first_name', 'lead.lead_last_name', 'lead.lead_phone', 'lead.lead_email', 'lead_source.lead_source_id', 'lead_source.lead_source_name', 'lead_status.lead_status_id', 'lead_status.lead_status_name', 'lead.lead_problem', 'lead.lead_remark', 'lead.status', 'lead.state_id', 'states.name')
            ->join('company', 'company.company_id', '=', 'lead.company_id')
            ->join('treatment', 'treatment.treatment_id', '=', 'lead.treatment_id')
            ->join('lead_source', 'lead_source.lead_source_id', '=', 'lead.lead_source_id')
            ->join('lead_status', 'lead_status.lead_status_id', '=', 'lead.lead_status_id')
            ->join('states', 'states.state_id', '=', 'lead.state_id')
            ->where('lead.status', '!=', 2)->where('convert_status', '!=', 1)
            ->where('lead.lead_phone', $id)
            ->get();

        $result = [];

        foreach ($leads as $lead) {

            $flw = Followup::where('lead_id', $lead['lead_id'])->orderby('followup_id', 'desc')->first();

            if ($flw) {
                $count =  $flw->followup_count;
                $next_date = $flw->next_followup_date;
            } else {
                $count =  0;
                $next_date = null;
            }

            $result[] = [
                'branch_id' => $lead['branch_id'],
                'company_id' => $lead['company_id'],
                'company_name' => $lead['company_name'],
                'lead_email' => $lead['lead_email'],
                'lead_first_name' => $lead['lead_first_name'],
                'lead_id' => $lead['lead_id'],
                'lead_last_name' => $lead['lead_last_name'],
                'lead_phone' => $lead['lead_phone'],
                'lead_problem' => $lead['lead_problem'],
                'lead_remark' => $lead['lead_remark'],
                'lead_source_id' => $lead['lead_source_id'],
                'lead_source_name' => $lead['lead_source_name'],
                'lead_status_id' => $lead['lead_status_id'],
                'lead_status_name' => $lead['lead_status_name'],
                'staff_id' => $lead['staff_id'],
                'state_id' => $lead['state_id'],
                'status' => $lead['status'],
                'sitting_count' => $count,
                'next_flw_date' => date('d-m-Y', strtotime($next_date))
            ];
        }
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $result,
        ], 200);
    }
    public function ViewLead($id)
    {

        $lead = Lead::select(
            'lead.*',
            'company.company_name',
            'branch.branch_name as BranchNames',
            'staff.name as staff_name',
            'lead_source.lead_source_name',
            'lead_status.lead_status_name',
            'states.name as state_name'
        )
        ->leftJoin('company','company.company_id','=','lead.company_id')
        ->leftJoin('branch','branch.branch_id','=','lead.branch_id')
        ->leftJoin('staff','staff.staff_id','=','lead.staff_id')
        ->leftJoin('lead_source','lead_source.lead_source_id','=','lead.lead_source_id')
        ->leftJoin('lead_status','lead_status.lead_status_id','=','lead.lead_status_id')
        ->leftJoin('states','states.state_id','=','lead.state_id')
        ->where('lead.lead_id',$id)
        ->first();

        return view('view_lead',compact('lead'));
    }
}