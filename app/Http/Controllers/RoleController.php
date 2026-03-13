<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Role;

class RoleController extends BaseController
{
    public function Index()
    {
        // Fetch roles with status != 2
        $roles = Role::where('status', '!=', 2)->get();

        // Pass data to Blade view
        return view('role_permission', compact('roles'));
    }
    public function Add(Request $request){
        $validator = Validator::make($request->all(), [ 
                                                        'role_name' => 'required|unique:role|max:255',
                                                        //'role_description'     => 'required|unique:role',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{

            $role_name        = $request->role_name;
            $role_description = "";
        
            $role   = new Role;

            $role->role_name        = $role_name;
            $role->role_description = $role_description;
            $role->created_by       =  $request->user()->id;
            $role->created_on       = date('Y-m-d H:i:s');
            $role->modified_by      =  $request->user()->id;
            $role->modified_on      = date('Y-m-d H:i:s');
            $role->status           = 1;
        
            $role->save();

            if($role){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Role has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'Role can not be created',
                        'error_msg' => 'Role information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
        
    }
   public function Edit($id){
        $role = Role::where('role_id', $id)->first(); // fetch single record

        return response([
            'data' => $role,
            'status' => 200
        ], 200);
    }

   public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 401,
                'message' => 'Incorrect input fields',
                'error_msg' => $validator->messages()->get('*'),
                'data' => null,
            ], 401);
        }

        $role = Role::find($id);

        if (!$role) {
            return response([
                'status' => 404,
                'message' => 'Role not found',
                'data' => null,
            ], 404);
        }

        // Optional: prevent updating first role (admin)
        $firstRole = Role::first();
        if ($firstRole->role_id == $role->role_id) {
            return response([
                'status' => 401,
                'message' => 'Not allowed to update this role',
                'data' => null,
            ], 200);
        }

        $role->role_name = $request->role_name;
        $role->role_description = $request->role_description ?? '';
        $role->modified_by = $request->user()->id;
        $role->modified_on = now();

        $role->update();

        return response([
            'status' => 200,
            'message' => 'Role updated successfully',
            'data' => $role
        ], 200);
    }
    public function Delete($id)
    {
        $che_status = Role::first();
        $role = Role::where('role_id', $id)->first();

        if(!$role) {
            return response([
                'status' => 404,
                'message' => 'Role not found',
                'data' => null
            ], 404);
        }

        if ($che_status->role_id != $role->role_id) {
            $role->status = 2; // soft delete
            $role->update();

            return response([
                'status' => 200,
                'message' => 'Successfully deleted',
                'data' => null
            ], 200);
        } else {
            return response([
                'status' => 401,
                'message' => 'Not allowed to delete this role',
                'data' => null
            ], 200);
        }
    }
   public function Status(Request $request, $id)
    {
        $status = Role::where('role_id', $id)->first();
        
        if ($status) {
                $status->status = $request->status;
                $status->modified_by = $request->user()->id;
                $status->update();
                return response([
                'data' => null,
                'message' => 'Successfully Updated',
                'status' => 200
            ], 200);
            }
    }
   
}