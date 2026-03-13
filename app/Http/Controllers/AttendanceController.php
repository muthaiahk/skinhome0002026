<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use App\Models\Attendance;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\Designation;

class AttendanceController extends Controller
{


   public function index()
    {
        // Get current year & month
        $year  = date('Y');
        $month = date('m');

        // Get all dates of the month
        $daysInMonth = date('t'); // total days in current month
        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dates[] = sprintf('%04d-%02d-%02d', $year, $month, $i);
        }

        // Get all active staff
        $staffs = Staff::select('staff_id','name','job_designation.job_id','job_designation.designation')
                        ->join('job_designation', 'job_designation.job_id','=','staff.job_id')
                        ->where('staff.staff_id','!=',1)
                        ->where('staff.status',0)
                        ->get();

        $values = [];
        foreach ($staffs as $staff) {
            $date_data = [];
            foreach ($dates as $date) {
                $attendance = Attendance::where('staff_id', $staff->staff_id)
                                ->whereDate('from_date', $date)
                                ->first();
                
                $status = '';
                if ($attendance) {
                    if ($attendance->present == 1) {
                        $status = 'P';
                    } elseif ($attendance->permission == 1) {
                        $status = 'PR';
                    } elseif ($attendance->leave == 1) {
                        $status = 'L';
                    } elseif ($attendance->weekoff == 1) {
                        $status = 'W';
                    }
                }
                $date_data[] = ['date' => $date, 'status' => $status];
            }

            $values[] = [
                'staff_id' => $staff->staff_id,
                'staff_name' => $staff->name,
                'designation' => $staff->designation,
                'job_id' => $staff->job_id,
                'dates' => $date_data
            ];
        }

        $Branches = Branch::where('status','!=',2)->get();

        // Pass values and dates to the Blade view
        return view('attendance', compact('values', 'dates','Branches'));
    }

public function get_branch_staff(Request $request)
{

    $branch_id = $request->branch_id;

    $staff = Staff::all()->filter(function ($staff) use ($branch_id) {

        return in_array($branch_id, $staff->branch_ids);

    })->values()->map(function ($staff) {

        return [
            'staff_id' => $staff->staff_id,
            'name' => $staff->name
        ];

    });

    return response()->json([
        'staff' => $staff
    ]);

}

 public function attendanceFilter(Request $request)
{

    $branch_id  = $request->branch_id;
    $monthInput = $request->month;

    $year  = date('Y', strtotime($monthInput));
    $month = date('m', strtotime($monthInput));

    $daysInMonth = date('t', strtotime($monthInput));

    $dates = [];

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $dates[] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
    }

    $staffs = Staff::select(
            'staff.staff_id',
            'staff.name',
            'job_designation.designation',
            'staff.branch_id'
        )
        ->join('job_designation', 'job_designation.job_id', '=', 'staff.job_id')
        ->where('staff.status', 0)
        ->where('staff.staff_id', '!=', 1)
        ->get();

    $values = [];

    foreach ($staffs as $staff) {

        // Branch filter
        if (!empty($branch_id) && $branch_id != 0) {

            if (!in_array((int)$branch_id, $staff->branch_ids)) {
                continue;
            }

        }

        $date_data = [];

        foreach ($dates as $date) {

            $attendance = Attendance::where('staff_id', $staff->staff_id)
                ->whereDate('from_date', $date)
                ->first();

            $status = '';

            if ($attendance) {

                if ($attendance->present == 1) {
                    $status = 'P';
                } elseif ($attendance->permission == 1) {
                    $status = 'PR';
                } elseif ($attendance->leave == 1) {
                    $status = 'L';
                } elseif ($attendance->weekoff == 1) {
                    $status = 'W';
                }

            }

            $date_data[] = [
                'date'   => $date,
                'status' => $status
            ];
        }

        $values[] = [
            'staff_name'  => $staff->name,
            'designation' => $staff->designation,
            'dates'       => $date_data
        ];
    }

    return response()->json([
        'dates'  => $dates,
        'values' => $values
    ]);

}
    public function All(Request $request){

        // for($i = 1; $i <=  date('t'); $i++)
        // {
        //     $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT); 
        // }
        $branch_id = $request->branch_id;
        if($request->date){

            
           
            // $month_no = Carbon::now()->$select_date->month;
            // $m_days   = Carbon::now()->$select_date->month($month_no)->daysInMonth; 

            for($i = 1; $i <=  date('t', strtotime($request->date)); $i++)
            {
                $dates[] = date('Y', strtotime($request->date)) . "-" . date('m', strtotime($request->date)) . "-" . str_pad($i, 2, '0', STR_PAD_LEFT); 
            }

        }else{

            for($i = 1; $i <=  date('t'); $i++)
            {
                $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT); 
            }
    
        }
        $staffs = Staff::select('staff_id','name','job_designation.job_id','job_designation.designation','branch_id')                      
                        ->join('job_designation', 'job_designation.job_id','=','staff.job_id')
                        ->where('staff.staff_id','!=',1)
                        ->where('staff.status',0);
                        //->get();

        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id != 1){
        //     $staffs = $staffs->where('staff.branch_id',$branch->branch_id);
        // }
        // if(isset($request->branch_id)){
        //     if($request->branch_id > 0){
        //         $staffs = $staffs->whereIn('staff.branch_id',$request->branch_id);
        //     } 
        //  }
        $staffs= $staffs->get();
        $values =[];
        foreach($staffs as $s=>$staff){
            $date_data =[];
            foreach($dates as $key => $date){
                $attendance = Attendance::where('staff_id',$staff->staff_id)->whereDate("from_date","=",$date)->first();
                $status = '';

                if($attendance){

                    if($attendance->present == 1){
                        $status = 'P';
                    }else if($attendance->permission == 1){
                        $status = 'PR';
                    }elseif($attendance->leave == 1){
                        $status = 'L';
                    }elseif($attendance->weekoff == 1){
                        $status = 'W';
                    }else{
                        $status = '';
                    }
                }

                $date_data[] = ['date'=>$date,'status'=>$status ];
            }
            $branches = json_decode($staff->branch_id);

            if(in_array($branch_id, json_decode($branches)))
            {
                $values[] = [
                            'staff_id'=>$staff->staff_id,
                            'staff_name'=>$staff->name,
                            'designation'=>$staff->designation,
                            'job_id'   => $staff->job_id,
                            'branch_id'   => json_decode($staff->branch_id),
                            'dates' => $date_data,
                            

                ];
            }

        }




      
        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                          //  'data'      => $staffs ,
                            'data' => $values
                        ],200);

    }

    public function markAttendance()
    {
        $staffs = Staff::select('staff.staff_id', 'staff.name', 'job_designation.designation', 'job_designation.job_id')
            ->join('job_designation', 'job_designation.job_id', '=', 'staff.job_id')
            ->where('staff.staff_id', '!=', 1)
            ->where('staff.status', 0)
            ->get();

        $attendanceData = [];

        foreach ($staffs as $staff) {
            $attendance = Attendance::where('staff_id', $staff->staff_id)
                ->whereDate('from_date', date('Y-m-d'))
                ->first();

            $status = $attendance ? 1 : 0;

            $attendanceData[] = [
                'staff_id' => $staff->staff_id,
                'name' => $staff->name,
                'designation' => $staff->designation,
                'job_id' => $staff->job_id,
                'status' => $status,
            ];
        }

        // Pass the data to the blade directly
        return view('mark_atd', compact('attendanceData'));
    }


    public function Add(Request $request){	
        
       $validator = Validator::make($request->all(), [ 
                                                        
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{
      
       
        $staffs_list = $request->att_list;

        foreach ($staffs_list as $val) {
            $attendance = new Attendance;
            $attendance->staff_id       = $val['staff_id']; // Use square brackets instead of arrow notation
            // $attendance->staff_name     = $val['name']; // Use square brackets instead of arrow notation
            // $attendance->job_id         = $val['job_id']; // Use square brackets instead of arrow notation
            $attendance->present        = $val['present']; // Use square brackets instead of arrow notation
            $attendance->permission     = $val['permission']; // Use square brackets instead of arrow notation
            $attendance->leave          = $val['leave']; // Use square brackets instead of arrow notation
            $attendance->leave_remarks  = $val['remarks']; // Use square brackets instead of arrow notation
            $attendance->weekoff        = $val['weekoff']; // Use square brackets instead of arrow notation
            $attendance->from_date      = $val['current_date'];
            $attendance->to_date        = $val['current_date']; 
            $attendance->created_by     = $request->user()->id;
            $attendance->modified_by    = $request->user()->id;
            $attendance->attendance_status = 1;

            $attendance->save();
        }
            
            if($attendance){
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'attendance has been created successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([
                        'status'    => 401,
                        'message'   => 'attendance can not be created',
                        'error_msg' => 'attendance information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
  public function Update(Request $request)
{

    $staff_id  = $request->staff_id;
    $from_date = $request->from_date;
    $to_date   = $request->to_date;
    $status    = $request->status;

    $staff = Staff::where('staff_id',$staff_id)->first();

    if(!$staff){
        return response()->json([
            'status'=>400,
            'message'=>'Staff not found'
        ]);
    }

    $start = Carbon::parse($from_date);
    $end   = Carbon::parse($to_date);

    while ($start <= $end) {

        $attendance = Attendance::where('staff_id',$staff_id)
                        ->whereDate('from_date',$start->format('Y-m-d'))
                        ->first();

        if(!$attendance){
            $attendance = new Attendance();
            $attendance->staff_id   = $staff->staff_id;
            $attendance->staff_name = $staff->name;
            $attendance->job_id     = $staff->job_id;
        }

        // reset status
        $attendance->present    = 0;
        $attendance->permission = 0;
        $attendance->leave      = 0;
        $attendance->weekoff    = 0;

        if($status == "present") $attendance->present = 1;
        if($status == "permission") $attendance->permission = 1;
        if($status == "leave") $attendance->leave = 1;
        if($status == "weekoff") $attendance->weekoff = 1;

        $attendance->from_date   = $start->format('Y-m-d');
        $attendance->to_date     = $start->format('Y-m-d');
        $attendance->created_by  = auth()->id();
        $attendance->modified_by = auth()->id();
        $attendance->attendance_status = 1;

        $attendance->save();

        $start->addDay();
    }

    return response()->json([
        'status'=>200,
        'message'=>'Attendance Updated Successfully'
    ]);
}  
    // public function Update($id,Request $request){
    //     $validator = Validator::make($request->all(), [ 
                                                        
                                                     
    //                                                 ]);

    //     if($validator->fails()) {
    //         $result =   response([
    //                                 'status'    => 401,
    //                                 'message'   => 'Incorrect format input feilds',
    //                                 'error_msg'     => $validator->messages()->get('*'),
    //                                 'data'      => null ,
    //                             ],401);

    //     }else{

            

    //         $staff_id              = $request->staff_id;
    //         $from_date             = $request->from_date;
    //         $to_date               = $request->to_date;
    //         $present               = $request->present;
    //         $permission            = $request->permission;
    //         $leave                 = $request->leave;
    //         $weekoff               = $request->weekoff;

    //          $toDate = Carbon::parse($to_date);
    //          $fromDate = Carbon::parse($from_date );
      
    //          $days = $toDate->diffInDays($fromDate);
    //        // $months = $toDate->diffInMonths($fromDate);
    //        // $years = $toDate->diffInYears($fromDate);
    //         // $gen_date = $fromDate;
    //         $generate_date = [];


    //         $staff = Staff::where('staff_id',$staff_id)->first();

    //         // $attendance = Attendance::where('staff_id',$staff_id)->whereDate("from_date","=",date('Y-m-d'))->whereDate("to_date","=",date('Y-m-d'))->where('leave',1)->first();
            
    //         $attendance = Attendance::where('staff_id',$staff_id)->whereDate("from_date",">=",$request->from_date)->whereDate("from_date","<=",$request->to_date)->first();
    //          return $attendance;
    //         // $attendance = Attendance::where('staff_id',$staff_id)->first();

    //         if($attendance){
                    

    //              for($i=0;$i<$days;$i++){
                    
    //             //     $next_date = date('Y-m-d', strtotime($gen_date .' +1 day'));                                              
    //             //     // $attendance = Attendance::where('staff_id',$staff_id)->whereDate("from_date","=",$gen_date)->where('leave',1)->first();
    //             //     $attendance = Attendance::where('staff_id',$staff_id)->first();
    
    //                 if($attendance){

    //                     $status = 1;
                        
    
    //                     $attendance->staff_id        = $staff_id;
    //                     $attendance->from_date       = $from_date;
    //                     $attendance->to_date         = $to_date;  
    //                     $attendance->present         = $present; 
    //                     $attendance->permission      = $permission;
    //                     $attendance->leave           = $leave;  
    //                     $attendance->leave_remarks   = ''; 
    //                     $attendance->weekoff         = $weekoff;            
    //                     $attendance->created_by      = $request->user()->id;
    //                     $attendance->modified_by     = $request->user()->id;
    //                     // return $attendance;
    //                      $attendance->update();
    //                     // $gen_date = $next_date;


    //                     // $attendance->staff_id        = $staff_id;
    //                     // $attendance->from_date       = $gen_date;
    //                     // $attendance->to_date         = $next_date;  
    //                     // $attendance->present         = $present; 
    //                     // $attendance->permission      = $permission;
    //                     // $attendance->leave           = $leave;  
    //                     // $attendance->leave_remarks   = ''; 
    //                     // $attendance->weekoff         = $weekoff;            
    //                     // $attendance->created_by      = $request->user()->id;
    //                     // $attendance->modified_by     = $request->user()->id;
            
    //                     // $attendance->update();
    //                     // $gen_date = $next_date;

                        
    //                 }else{

                        
    
    //                     $add_att = new Attendance();
    
    //                     $add_att->staff_id        = $staff->staff_id; 
    //                     $add_att->staff_name      = $staff->name;
    //                     $add_att->job_id          = $staff->job_id;
    //                     $add_att->present         = $present; 
    //                     $add_att->permission      = $permission;
    //                     $add_att->leave           = $leave; 
    //                     $add_att->leave_remarks   = ''; 
    //                     $add_att->weekoff         = $weekoff;  
    //                      $add_att->from_date       = Carbon::now()->isoFormat('YYYY-MM-DD H:mm:ss');
    //                     $add_att->to_date         = Carbon::now()->isoFormat('YYYY-MM-DD H:mm:ss');    
    //                     $add_att->created_by      = $request->user()->id;
    //                     $add_att->modified_by     = $request->user()->id;
    //                     $add_att->attendance_status  = 1;
    //                     return $add_att;
    //                     $add_att->save();

    //                     // $gen_date = $next_date;
    //                 }
    //              }

    //                 $result =   response([
    //                                         'status'    => 200,
    //                                         'message'   => 'success',
    //                                         'error_msg' => null,
    //                                         // 'data'      => $days,
    //                                         // 'days'=>$generate_date,
    //                                         'data'=>$generate_date,
    //                                     ],200);
    
                


    //         }else{
    //             $result =   response([
    //                 'status'    => 400,
    //                 'message'   => 'Attendance  cant modified',
    //                 'error_msg' => 'Attendance  cant modified',
    //                 'data'      => null,
    //             ],400);
    //         }
            
            
    //         // if($attendance){
                    

    //             //     for($i=0;$i<$days;$i++){
                        
    //             //         $next_date = date('Y-m-d', strtotime($gen_date .' +1 day'));                                              
    //             //         // $attendance = Attendance::where('staff_id',$staff_id)->whereDate("from_date","=",$gen_date)->where('leave',1)->first();
    //             //         $attendance = Attendance::where('staff_id',$staff_id)->first();
        
    //             //         if($attendance){

    //             //             $status = 1;
                            
        
    //             //             $attendance->staff_id        = $staff_id;
    //             //             $attendance->from_date       = $gen_date;
    //             //             $attendance->to_date         = $next_date;  
    //             //             $attendance->present         = $present; 
    //             //             $attendance->permission      = $permission;
    //             //             $attendance->leave           = $leave;  
    //             //             $attendance->leave_remarks   = ''; 
    //             //             $attendance->weekoff         = $weekoff;            
    //             //             $attendance->created_by      = $request->user()->id;
    //             //             $attendance->modified_by     = $request->user()->id;
    //             //              return $attendance;
    //             //             // $attendance->update();
    //             //             $gen_date = $next_date;


    //             //             // $attendance->staff_id        = $staff_id;
    //             //             // $attendance->from_date       = $gen_date;
    //             //             // $attendance->to_date         = $next_date;  
    //             //             // $attendance->present         = $present; 
    //             //             // $attendance->permission      = $permission;
    //             //             // $attendance->leave           = $leave;  
    //             //             // $attendance->leave_remarks   = ''; 
    //             //             // $attendance->weekoff         = $weekoff;            
    //             //             // $attendance->created_by      = $request->user()->id;
    //             //             // $attendance->modified_by     = $request->user()->id;
                
    //             //             // $attendance->update();
    //             //             // $gen_date = $next_date;

                            
    //             //         }else{

                            
        
    //             //             $add_att = new Attendance();
        
    //             //             $add_att->staff_id        = $staff->staff_id; 
    //             //             $add_att->staff_name      = $staff->name;
    //             //             $add_att->job_id          = $staff->job_id;
    //             //             $add_att->present         = 0; 
    //             //             $add_att->permission      = 0;
    //             //             $add_att->leave           = 1;  
    //             //             $add_att->leave_remarks   = ''; 
    //             //             $add_att->weekoff         = 0;  
    //             //             $add_att->from_date       = $gen_date;
    //             //             $add_att->to_date         = $next_date;      
    //             //             $add_att->created_by      = $request->user()->id;
    //             //             $add_att->modified_by     = $request->user()->id;
    //             //             $add_att->attendance_status  = 1;
    //             //             return $add_att;
    //             //             $add_att->save();

    //             //             $gen_date = $next_date;
    //             //         }
    //             //     }
   
    //             //         $result =   response([
    //             //                                 'status'    => 200,
    //             //                                 'message'   => 'success',
    //             //                                 'error_msg' => null,
    //             //                                 'data'      => $days,
    //             //                                 'days'=>$generate_date,
    //             //                             ],200);
        
                    


    //             // }else{
    //             //     $result =   response([
    //             //         'status'    => 400,
    //             //         'message'   => 'Attendance  cant modified',
    //             //         'error_msg' => 'Attendance  cant modified',
    //             //         'data'      => null,
    //             //     ],400);
    //             // }

            
    //         // $attendance = Attendance::where('staff_id',$staff_id)->whereDate("from_date","=",date('Y-m-d'))->where('leave',1)->first();

    //         // if($attendance){

    //         //     $attendance->staff_id        = $staff_id;
    //         //     $attendance->from_date       = $from_date;
    //         //     $attendance->to_date         = $to_date;            
    //         //     $attendance->created_by      = 1;
    //         //     $attendance->modified_by     = 1;
    
    //         //     $attendance->update();
    
           
    //         // }else{

    //             // $result =   response([
    //             //     'status'    => 400,
    //             //     'message'   => 'only leave Staffs can modified',
    //             //     'error_msg' => null,
    //             //     'data'      => null,
    //             // ],400);
    //         // }

            
    //     }

    //     return $result;
    // }

    // public function Update(Request $request,$id){
    //     $validator = Validator::make($request->all(), [ 
                                                        
                                                     
    //                                                 ]);

    //     if($validator->fails()) {
    //         $result =   response([
    //                                 'status'    => 401,
    //                                 'message'   => 'Incorrect format input feilds',
    //                                 'error_msg'     => $validator->messages()->get('*'),
    //                                 'data'      => null ,
    //                             ],401);

    //     }else{

            

    //         $staff_id                  = $request->staff_id;
    //         $name                      = $request->name;
    //         $job_id                    = $request->job_id;
    //         $attendance_status         = $request->attendance_status;
 
    //         $attendance = Attendance::find($id);

    //         $attendance->staff_id        = $staff_id;
    //         $attendance->name            = $name;
    //         $attendance->job_id          = $job_id;  
    //         $attendance->attendance_status          = $attendance_status;           
    //         $attendance->created_by      = 1;
    //         $attendance->modified_by     = 1;

    //         $attendance->update();

    //         $result =   response([
    //                                 'status'    => 200,
    //                                 'message'   => 'success',
    //                                 'error_msg' => null,
    //                                 'data'      => $attendance,
    //                             ],200);
    //     }

    //     return $result;
    // }
    
    
}