<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Staff;
use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Role;
use App\Models\Designation;

class StaffController extends BaseController
{
     public function index(Request $request)
    {
        // Get all active departments and branches
        $Departments = Department::where('status','!=',2)->get();
        $Branchs = Branch::where('status','!=',2)->get();

        // Get staff with joins
        $staff = Staff::select(
            'staff.*',
            'company.company_name',
            'department.department_name',
            'job_designation.designation',
            'role.role_name'
        )
        ->join('company','company.company_id','=','staff.company_id')
        ->join('department','department.department_id','=','staff.dept_id')
        ->leftJoin('job_designation','job_designation.job_id','=','staff.job_id')
        ->join('role','role.role_id','=','staff.role_id')
        ->where('staff.status','!=',2)
        ->where('staff.staff_id','!=',1)
        ->get();

        // Fetch all branches as id => name for fast lookup
        $allBranches = Branch::pluck('branch_name', 'branch_id')->toArray();

        foreach ($staff as $s) {
            $branchIds = $s->branch_id;

            // Remove extra quotes and decode JSON
            $branchIds = trim($branchIds, '"');
            $branchIds = json_decode($branchIds, true);

            // Ensure array
            if (!is_array($branchIds)) {
                $branchIds = [];
            }

            // Map IDs to names
            $branchNames = [];
            foreach ($branchIds as $id) {
                if (isset($allBranches[$id])) {
                    $branchNames[] = $allBranches[$id];
                }
            }

            $s->branch_names = implode(', ', $branchNames);
        }

        $roles  = Role::where('role_id','!=',2)
                        ->where('role_id','!=',1)->where('status','!=',2)->get();

        $designations = Designation::where('status','!=',2)->get();

        $Company = Company::first();
        return view('staff', compact('staff','Departments','Company','Branchs','roles','designations'));
    }
    public function All(Request $request){
        
        $department_id = $request->department_id;
        $branch_id = $request->branch_id;
       // echo $department_id;
        $staff = Staff::select('staff.*','company.company_id','company.company_name','staff.name','staff.phone_no','staff.email','staff.status','department.department_id','department.department_name','job_designation.job_id','job_designation.designation','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')
        ->join('company', 'company.company_id','=','staff.company_id')
        // ->join('branch', 'branch.branch_id','=','staff.branch_id')
        ->join('department', 'department.department_id','=','staff.dept_id')
        ->leftJoin('job_designation', 'job_designation.job_id','=','staff.job_id')
        ->join('role', 'role.role_id','=','staff.role_id')
        ->where('staff.status', '!=', 2)
        ->where('staff.staff_id', '!=', 1);
        //  ->where('staff.branch_id', 'like', '%' . $branch_id . '%');

        if($department_id >= 1){
            $staff = $staff->where('staff.dept_id', $department_id);
        }
         if($branch_id !== 'all'){
            $staff = $staff->where('staff.branch_id', 'like', '%' . $branch_id . '%');
        }
        $staff= $staff->get();
        //  return $staff
        $data= [];
        foreach($staff as $val){
            $branches = json_decode($val->branch_id);
            if(in_array($branch_id, json_decode($branches)))
            {
             
  
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->designation_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation_name,
                    'branch_id'                => $branch_id
                ];
            }else{
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->designation_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation_name,
                    'branch_id'                => json_decode($val->branch_id)
                ];
            }
        
        }


        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $data ,
                        ],200);

    }
    public function Add(Request $request) {
        $validator = Validator::make($request->all(), [
            'staff_name'      => 'required|string|max:255',
            'staff_dob'       => 'required|date',
            'staff_gender'    => 'required|in:male,female',
            'staff_email'     => 'required|email|unique:staff,email',
            'staff_phone'     => 'required|min:10',
            'staff_emg_phone' => 'nullable|min:10',
            'staff_address'   => 'required|string',
            'role_id'         => 'required',
            'staff_doj'       => 'required|date',
            'branch_id'       => 'required|array',
            'department_id'   => 'required',
            'designation_id'  => 'required',
            'username'        => 'required|unique:users,username',
            'password'        => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $company = Company::where('company_name', $request->company_name)->first();
        if(!$company) {
            return response()->json([
                'status' => 401,
                'message' => 'Company not found'
            ], 401);
        }

        $staff = new Staff();
        $staff->company_id        = $company->company_id;
        $staff->branch_id         = json_encode($request->branch_id);
        $staff->name              = $request->staff_name;
        $staff->address           = $request->staff_address;
        $staff->phone_no          = $request->staff_phone;
        $staff->emergency_contact = $request->staff_emg_phone;
        $staff->email             = $request->staff_email;
        $staff->date_of_birth     = $request->staff_dob;
        $staff->date_of_joining   = $request->staff_doj;
        $staff->gender            = $request->staff_gender;
        $staff->dept_id           = $request->department_id;
        $staff->role_id           = $request->role_id;
        $staff->job_id            = $request->designation_id;
        $staff->username          = $request->username;
        $staff->password          = Hash::make($request->password);
        $staff->created_by        = $request->user()->id;
        $staff->modified_by       = $request->user()->id;
        $staff->save();

        // Create user for login
        $user = new User();
        $user->username   = $request->username;
        $user->password   = Hash::make($request->password);
        $user->role_id    = $request->role_id;
        $user->company_id = $company->company_id;
        $user->staff_id   = $staff->staff_id;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Staff has been created successfully'
        ]);
    }
    
    public function edit($id)
    {
        $staff = Staff::with(['department','role','designation'])->find($id);
        if(!$staff) {
            return response(['status'=>404,'message'=>'Staff not found']);
        }

        $branches = Branch::whereIn('branch_id', $staff->branch_ids)
                          ->pluck('branch_name')
                          ->toArray();

        return response([
            'status' => 200,
            'data' => [
                'staff_id'          => $staff->staff_id,
                'name'              => $staff->name,
                'phone_no'          => $staff->phone_no,
                'email'             => $staff->email,
                'gender'            => $staff->gender,
                'date_of_birth'     => $staff->date_of_birth,
                'date_of_joining'   => $staff->date_of_joining,
                'emergency_contact' => $staff->emergency_contact,
                'department_id'     => $staff->dept_id,
                'department_name'   => $staff->department->department_name ?? '',
                'role_id'           => $staff->role_id,
                'role_name'         => $staff->role->role_name ?? '',
                'designation_id'    => $staff->job_id,
                'designation_name'  => $staff->designation->designation ?? '',
                'branch_id'         => $staff->branch_ids,
                'branch_name'       => $branches,
                'address'           => $staff->address,
                'username'          => $staff->username,
                'password'          => $staff->password,
                'status'            => $staff->status
            ]
        ]);
    }

    // View staff
    public function view($id)
    {
        $staff = Staff::with(['department','role','designation'])->find($id);
        if(!$staff) {
            return response(['status'=>404,'message'=>'Staff not found']);
        }

        $branches = Branch::whereIn('branch_id', $staff->branch_ids)
                          ->pluck('branch_name')
                          ->toArray();

        $data = [
            'staff_id'          => $staff->staff_id,
            'name'              => $staff->name,
            'phone_no'          => $staff->phone_no,
            'email'             => $staff->email,
            'gender'            => $staff->gender,
            'date_of_birth'     => $staff->date_of_birth,
            'date_of_joining'   => $staff->date_of_joining,
            'emergency_contact' => $staff->emergency_contact,
            'department_name'   => $staff->department->department_name ?? '',
            'role_name'         => $staff->role->role_name ?? '',
            'designation_name'  => $staff->designation->designation ?? '',
            'branch_name'       => $branches,
            'address'           => $staff->address,
            'username'          => $staff->username,
            'status'            => $staff->status
        ];

        return response(['status'=>200,'data'=>[$data]]);
    }

    // Update staff
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'staff_email' => 'required|email',
            'staff_phone' => 'required|min:10',
            'username'    => 'required',
            'password'    => 'required|min:8',
        ]);

        if($validator->fails()){
            return response([
                'status'=>401,
                'message'=>'Validation failed',
                'error_msg'=>$validator->errors()
            ],401);
        }

        $staff = Staff::find($id);
        if(!$staff){
            return response(['status'=>404,'message'=>'Staff not found'],404);
        }

        $staff->name            = $request->staff_name;
        $staff->phone_no        = $request->staff_phone;
        $staff->email           = $request->staff_email;
        $staff->date_of_birth   = $request->staff_dob;
        $staff->date_of_joining = $request->staff_doj;
        $staff->gender          = $request->staff_gender;
        $staff->role_id         = $request->role_id;
        $staff->dept_id         = $request->department_id;
        $staff->job_id          = $request->designation_id;
        $staff->branch_id       = json_encode($request->branch_id);
        $staff->address         = $request->staff_address;
        $staff->username        = $request->username;
        $staff->password        = Hash::make($request->password);

        $staff->save();

        return response(['status'=>200,'message'=>'Staff updated successfully']);
    }
    public function Delete($id){

        $status = Staff::where('staff_id', $id)->first();

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
    public function Status(Request $request, $id){
        $staff = Staff::find($id);

        if($staff){
            $staff->status = $request->status;
            $staff->modified_by = $request->user()->id;
            $staff->save();

            return response()->json([
                'status' => 200,
                'message' => 'Status updated successfully'
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Staff not found'
        ], 404);
    }
    public function UserEdit($id){

       
        $staff = Staff::select('staff.*','staff.name','staff.phone_no','staff.email','staff.status','role.role_id','role.role_name','staff.emergency_contact','staff.address','staff.gender')

       
        ->join('role', 'role.role_id','=','staff.role_id')
        ->where('staff_id', $id);
        
        $staff= $staff->get();

        //  return $staff;

        $data= [];
        foreach($staff as $val){
         
            $cleanedBranchId = stripslashes($val->branch_id); 
            $jsonString = trim($cleanedBranchId, '""'); 

            $branchIdsArray = explode(',', $jsonString);

            $branches = Branch::whereIn('branch_id', $branchIdsArray)->get();

            $branchNames = $branches->pluck('branch_name')->toArray();
        
                $data[] = [
                    'staff_id'                 => $val->staff_id,
                    'staff_name'                 => $val->name,
                    'status'                   => $val->status,
                    'phone_no'                 => $val->phone_no,
                    'email'                    => $val->email,
                    'gender'                   => $val->gender,
                    'date_of_joining'          => $val->date_of_joining,
                    'emergency_contact'        => $val->emergency_contact,
                    'date_of_birth'            => $val->date_of_birth,
                    'department_id'            => $val->department_id,
                    'role_id'                  => $val->role_id,
                    'role_name'                => $val->role_name,
                    'name'                     => $val->name,
                    'address'                  => $val->address,
                    'designation_id'           => $val->job_id,
                    'department_name'          => $val->department_name,
                    'designation_name'         => $val->designation,
                    'username'                 => $val->username,
                    'password'                 => $val->password,
                    'profile_pic'              => $val->profile_pic,
                    'branch_id'                => json_decode($val->branch_id),
                     'branch_name'             => $branchNames, 
                ];
                    
        }

        

        return response([
            'data' => $data,
            'status' => 200
        ],200);

    }

    public function UserUpdate(Request $request,$id){

       

        $validator = Validator::make($request->all(), [ 
            // 'phone_no' => 'required|min:10|unique:staff,phone_no,'.$id.',staff_id|regex:/^[0-9]*-?[0-9]*$/',
            // 'email'     => 'required|unique:staff,email,'.$id.',staff_id|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            // 'password'  => 'required|min:8', 
           
        ]);

        if($validator->fails()) {

            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg' => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{


            $name              = $request->name;
            $address           = $request->address;
            $phone_no          = $request->phone_no;
            $email             = $request->email;
            $date_of_birth     = $request->date_of_birth;

           
           
        
            $staff_user   = Staff::where('staff_id',$id)->first();
            
            if($request->profile_pic) { 
                $imageName = idate("B").rand(1,50).'.'.$request->profile_pic->extension(); 
                // //Storage::disk('public')->putFileAs('/awards', $request->logo,$imageName,'public');  

                $destinationPath = 'profile_pic';
                // // $myimage = $request->image->getClientOriginalName();
                //$logo = $request->logo->move(public_path($destinationPath), $imageName);
                 $request->profile_pic->move(public_path($destinationPath), $imageName);
                $profile_pic = "https://crm.renewhairandskincare.com/new/renew_api/public/".$destinationPath ."/".$imageName;
            
            }else{
                $profile_pic        =  $staff_user->profile_pic;
            }
            $staff_user->name              = $name;
            $staff_user->address           = $address;
            $staff_user->phone_no          = $phone_no;
            $staff_user->email             = $email;
            $staff_user->profile_pic       = $profile_pic;
            $staff_user->modified_by       = $request->user()->id;


            $staff_user->update();

            if($staff_user){

            
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'User Profile has been updated successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'User Profile can not be created',
                        'error_msg' => 'User Profile information is worng please try again',
                        'data'      => null ,
                    ],401);
            }

            return $result;
        }
        
    }
}