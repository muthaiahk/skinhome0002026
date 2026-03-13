<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Designation;
use App\Models\Company;

class DesignationController extends BaseController
{
    public function designationList()
    {
        $designations = Designation::select('job_designation.job_id', 'company.company_name', 'job_designation.designation', 'job_designation.description', 'job_designation.status')
            ->join('company', 'company.company_id', '=', 'job_designation.company_id')
            ->where('job_designation.status', '!=', 2)
            ->get();

        return view('designation_list', compact('designations'));
    }
    public function Index(){
        
       // $designation = Designation::where('status', '!=', 2)->get();

         $designations = Designation::select('job_designation.job_id', 'company.company_name', 'job_designation.designation', 'job_designation.description', 'job_designation.status')
            ->join('company', 'company.company_id', '=', 'job_designation.company_id')
            ->where('job_designation.status', '!=', 2)
            ->get();

        return view('designation', compact('designations'));

    }
    public function addindex(){
         $designations = Company::first();
        return view('add_designation', compact('designations'));
    }
    public function Save(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'designation' => 'required|unique:job_designation|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $company = Company::where('company_name', $request->company_name)->first();

            $company_id  = $company->company_id;
            $designation = $request->designation;
            $description = $request->description;
          
        
            $add_designation   = new Designation;

            $add_designation->company_id  = $company_id;
            $add_designation->designation = $designation;
            $add_designation->description = $description;
            $add_designation->created_by  = $request->user()->id;
            $add_designation->modified_by = $request->user()->id;
        
            $add_designation->save();

            if($add_designation){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Designation has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Designation can not be created',
                        'error_msg' => 'Designation information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){
       // $designation = Designation::where('job_id', $id)->get();

        $designation = Designation::select('job_designation.job_id as job_id','company.company_name as company_name','job_designation.designation as designation','job_designation.description as description','job_designation.status as status')->where('status', '!=', 2)
                        ->join('company', 'company.company_id','=','job_designation.company_id')
                        ->where('job_id', $id)->first();
          return view('edit_designation', compact('designation'));
    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                        'designation' => 'required|unique:job_designation,designation,'.$id.',job_id|max:255',
                                                        //'description' => 'required|unique:job_designation,designation,'.$id.',job_id',
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
            $company = Company::where('company_name', $request->company_name)->first();

            $company_id  = $company->company_id;
            $designation = $request->designation;
            $description = $request->description;
            
            $upd_designation = Designation::find($id);

            $upd_designation->company_id  = $company_id;
            $upd_designation->designation = $designation;
            $upd_designation->description = $description;
            $upd_designation->modified_by = $request->user()->id;
            $upd_designation->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_designation,
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = Designation::where('job_id', $id)->first();

        if($status){
            $status->status = 2;
            $status->update();
        }
        return response([
                            'data' => null,
                            'message' => 'Successfully Delete',
                            'status' => 200
                        ],200);
    }

    public function Status(Request $request, $id)
    {
        $designation = Designation::where('job_id', $id)->first();

        if ($designation) {
            $designation->status = $request->status;
            $designation->modified_by = $request->user()->id;  // <-- fix here
            $designation->update();

            return response([
                'data' => null,
                'message' => 'Successfully Updated',
                'status' => 200
            ], 200);
        } else {
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }
    }
}