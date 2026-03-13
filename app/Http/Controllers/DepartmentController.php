<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Department;
use App\Models\Company;
use App\Models\Branch;
class DepartmentController extends BaseController
{
    public function Index()
    {
        $departments = Department::select(
                'department.department_id',
                'department.department_name',
                'department.status',
                'company.company_name',
                'branch.branch_name'
            )
            ->join('company', 'company.company_id','=','department.company_id')
            ->join('branch', 'branch.branch_id','=','department.branch_id')
            ->where('department.status', '!=', 2)
            ->get();

        return view('department', compact('departments'));
    }
    public function Create()
    {
        $companies = Company::all();
        $brandchs = Branch::all();
        // You might also want to load branches or other related data here, if needed
        return view('add_dpt', compact('companies','brandchs'));
    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                        'department_name' => 'required|unique:department|max:255',
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

            $company_id      = $company->company_id;
            $branch_id       = $request->branch_id;
            $department_name = $request->department_name;
            $dept_incharge   = $request->dept_incharge;          
        
            $department   = new Department;

            $department->company_id      = $company_id;
            $department->branch_id       = $branch_id;
            $department->department_name = $department_name;
            $department->dept_incharge   = $dept_incharge;
            $department->created_by      =  $request->user()->id;
            $department->modified_by     =  $request->user()->id;
            $department->status     =  1;
        
            $department->save();

            if($department){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Department has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Department can not be created',
                        'error_msg' => 'Department information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
   public function Edit($id) {
        $department = Department::select(
                            'department.department_id',
                            'department.department_name',
                            'department.dept_incharge',
                            'department.branch_id',
                            'company.company_id',
                            'company.company_name',
                            'branch.branch_name',
                            'department.status'
                        )
                        ->join('company', 'company.company_id', '=', 'department.company_id')
                        ->join('branch', 'branch.branch_id', '=', 'department.branch_id')
                        ->where('department.department_id', $id)
                        ->first(); // <-- get single model

        $branches = Branch::all();

        return view('edit_dpt', compact('department', 'branches'));
    }
    public function Update(Request $request,$id){
        $validator = Validator::make($request->all(), [ 
                                                        'department_name' => 'required|unique:department,department_name,'.$id.',department_id|max:255',
                                                     
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

            $company_id      = $company->company_id;
            $branch_id       = $request->branch_id;
            $department_name = $request->department_name;
            $dept_incharge   = $request->dept_incharge;      
            
            $department = Department::find($id);

            $department->company_id      = $company_id;
            $department->branch_id       = $branch_id;
            $department->department_name = $department_name;
            $department->dept_incharge   = $dept_incharge;
            $department->created_by      =  $request->user()->id;
            $department->modified_by     =  $request->user()->id;

            $department->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'success',
                                    'error_msg' => null,
                                    'data'      => $department,
                                ],200);
        }

        return $result;
    }
    public function Delete($id)
    {
        $department = Department::find($id);

        if($department){
            $department->status = 2;
            $department->save();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Deleted'
        ]);
    }
    public function Status(Request $request, $id){

        $department_status = Department::where('department_id', $id)->first();

        if($department_status){
            $department_status->status = $request->status;
            $department_status->modified_by     =  $request->user()->id;
            $department_status->update();
        }else{
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ],404); 
        }

        return response([
                            'data' => null,
                            'message' => 'Successfully Updated',
                            'status' => 200
                        ],200);
    }
}