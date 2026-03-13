<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\Staff;
use App\Models\Designation;

class NotificationController extends Controller
{
    public function List(Request $request){
        $staff_id = $request->user()->staff_id;
        $notify = Notification::where('sender_id',$staff_id)->where('notify',0)->orderBy('notify_id', 'desc')->get();
        return  response([
                            'status'    => 200,
                             'message'   => null,
                            'error_msg' => null,
                            'data'      => $notify,
                            'count'     => count($notify)
                        ],200);


    }
    public function View($id,Request $request){

        $notify = Notification::where('notify_id',$id)->first();
        $notify->notify = 1;
        $notify->update();
        return  response([
            'status'    => 200,
            'message'   => 'viwed',
            'error_msg' => null,
            'data'      => null,
        
        ],200);

    } 
    public function All(Request $request){
        $staff_id = $request->user()->staff_id;

 	    $notify = Notification::orderBy('notify_id', 'desc')->where('receiver_id',$staff_id)->get();
      
       
        $data = [];
        foreach($notify as $val){

            $staff = Staff::where('staff_id',$val->sender_id)->first();
            
            $data[]=[
                'alert_status'       => $val->alert_status,
                'content'            => $val->content,
                'staff_name'         => $staff->name,
                // 'staff_name'         => $staff?$staff?->name:'',
                'created_at'         => $val->created_at,
                'created_by'         => $val->created_by,
                'dashboard'          => $val->dashboard,
                'notify'             => $val->notify,
                'notify_id'          => $val->notify_id,
                'receiver_id'        => $val->receiver_id,
                'sender_id'          => $val->sender_id,
                'title'              => $val->title,
                'updated_at'         => $val->updated_at,
                'updated_by'         => $val->updated_by,
               
            ];
        }
        return  response([
                            'status'    => 200,
                            'message'   => null,
                            'error_msg' => null,
                            'data'      => $data,
                        ],200);


    }
    public function Clear(Request $request)
    {
        $user_id    = $request->user()->staff_id;

      
        // $notifications = Notification::where('receiver_id', $user_id)->where('alert_status',$id)->get();
        $notifications = Notification::where('receiver_id', $user_id)->get();
        foreach($notifications as $notify){
            $notify = Notification::where('notify_id', $notify->notify_id)->first();
            $notify->notify=1;
            
            $notify ->update();

        }
        return   response([
                            'status'      => 200,
                            'data'        => null,

                        ],200);
    }
}
