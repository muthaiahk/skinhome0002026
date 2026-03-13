<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Customer;

class DashboardController extends Controller
{

    public function index()
    {
        $Branches = Branch::orderBy('branch_name')->get();

        $leadCount = Lead::count();
        $appointmentCount = Appointment::count();
        $paymentTotal = Payment::sum('amount');

        return view('dashboard',compact(
            'Branches',
            'leadCount',
            'appointmentCount',
            'paymentTotal'
        ));
    }


    /* DASHBOARD COUNTS */

    public function dashboardCount(Request $request)
    {

        $branch_id = $request->branch_id;

        $leadQuery = Lead::query();
        $appointmentQuery = Appointment::query();
        $paymentQuery = Payment::query();

        if($branch_id){
            $leadQuery->where('branch_id',$branch_id);
            $appointmentQuery->where('branch_id',$branch_id);
            $paymentQuery->whereHas('customer', function($q) use ($branch_id) {
                $q->where('branch_id', $branch_id);
            });
        }

        $leadCount = $leadQuery->count();
        $appointmentCount = $appointmentQuery->count();
        $paymentTotal = $paymentQuery->sum('amount');


        $branchPaymentsQuery = DB::table('branch')
        ->leftJoin('customer','branch.branch_id','=','customer.branch_id')
        ->leftJoin('payment','customer.customer_id','=','payment.customer_id');

        if($branch_id) {
            $branchPaymentsQuery->where('branch.branch_id', $branch_id);
        }

        $branchPayments = $branchPaymentsQuery->select(
            'branch.branch_name',
            DB::raw('COALESCE(SUM(payment.amount),0) as total'),
            DB::raw('COALESCE(SUM(CASE WHEN payment.status=1 THEN payment.amount END),0) as paid'),
            DB::raw('COALESCE(SUM(CASE WHEN payment.status=0 THEN payment.amount END),0) as pending')
        )
        ->groupBy('branch.branch_name')
        ->get();

        return response()->json([
            "leadCount"=>$leadCount,
            "appointmentCount"=>$appointmentCount,
            "paymentTotal"=>$paymentTotal,
            "branchPayments"=>$branchPayments
        ]);
    }



    /* OLD VS NEW CUSTOMER CHART */

    public function customerChart(Request $request)
    {

        $branch_id = $request->branch_id;
        $year = $request->year;

        $query = DB::table('customer_treatment')
            ->join('customer', 'customer_treatment.customer_id', '=', 'customer.customer_id');

        if($branch_id){
            $query->where('customer.branch_id',$branch_id);
        }

        if($year){
            $query->whereYear('customer_treatment.created_on', $year);
        }

        $data = $query
        ->select(
            DB::raw("MONTH(customer_treatment.created_on) as month"),
            DB::raw("SUM(CASE WHEN DATE_FORMAT(customer.created_on, '%Y-%m') < DATE_FORMAT(customer_treatment.created_on, '%Y-%m') THEN 1 ELSE 0 END) as old_count"),
            DB::raw("SUM(CASE WHEN DATE_FORMAT(customer.created_on, '%Y-%m') >= DATE_FORMAT(customer_treatment.created_on, '%Y-%m') THEN 1 ELSE 0 END) as new_count")
        )
        ->groupBy('month')
        ->get();

        $categories=[];
        $old=[];
        $new=[];

        foreach($data as $d){
            $categories[] = Carbon::create()->month($d->month)->format('M');
            $old[]=$d->old_count;
            $new[]=$d->new_count;
        }

        return response()->json([
            "categories"=>$categories,
            "old"=>$old,
            "new"=>$new
        ]);
    }



    /* MALE FEMALE CHART */

    public function customerGenderChart(Request $request)
    {

        $branch_id = $request->branch_id;
        $year = $request->year;

        $query = Customer::query();

        if($branch_id){
            $query->where('branch_id',$branch_id);
        }

        if($year){
            $query->whereYear('created_on', $year);
        }

        $data = $query
        ->select(
            DB::raw("MONTH(created_on) as month"),
            DB::raw("SUM(CASE WHEN customer_gender='Female' THEN 1 ELSE 0 END) as female"),
            DB::raw("SUM(CASE WHEN customer_gender='Male' THEN 1 ELSE 0 END) as male")
        )
        ->groupBy('month')
        ->get();

        $categories=[];
        $female=[];
        $male=[];

        foreach($data as $d){
            $categories[] = Carbon::create()->month($d->month)->format('M');
            $female[]=$d->female;
            $male[]=$d->male;
        }

        return response()->json([
            "categories"=>$categories,
            "female"=>$female,
            "male"=>$male
        ]);
    }



    /* APPOINTMENT CHART */

    public function appointmentChart(Request $request)
    {

        $branch_id = $request->branch_id;
        $year = $request->year ?? date('Y');

        $query = Appointment::query()->whereYear('created_on',$year);

        if($branch_id){
            $query->where('branch_id',$branch_id);
        }

        $data = $query
        ->select(
            DB::raw("MONTH(created_on) as month"),
            DB::raw("COUNT(*) as count")
        )
        ->groupBy('month')
        ->get();

        $result=[];

        foreach($data as $d){

            $result[]=[
                "month"=>Carbon::create()->month($d->month)->format('M'),
                "count"=>$d->count
            ];
        }

        return response()->json([
            "data"=>$result
        ]);
    }



    /* TREATMENT CHART */

    public function treatmentChart(Request $request)
    {

        $branch_id = $request->branch_id;
        $year = date('Y'); // The UI says "This Year"

        $query = DB::table('customer_treatment')
            ->join('treatment', 'customer_treatment.treatment_id', '=', 'treatment.treatment_id')
            ->join('customer', 'customer_treatment.customer_id', '=', 'customer.customer_id')
            ->whereYear('customer_treatment.created_on', $year);

        if($branch_id){
            $query->where('customer.branch_id', $branch_id);
        }

        $data = $query
        ->select(
            'treatment.treatment_name',
            DB::raw("COUNT(*) as total_count")
        )
        ->groupBy('treatment.treatment_name')
        ->get();

        return response()->json([
            "data"=>$data
        ]);
    }



    /* SALES TABLE */

    public function paymentSalesReport(Request $request)
    {

        $branch_id = $request->branch_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $query = DB::table('payment')
        ->leftJoin('customer','payment.customer_id','=','customer.customer_id')
        ->leftJoin('branch','customer.branch_id','=','branch.branch_id')
        ->select(
            'payment.*',
            'branch.branch_name',
            'customer.customer_first_name',
            'customer.customer_phone'
        );

        if($branch_id){
            $query->where('branch.branch_id',$branch_id);
        }

        if($from_date){
            $query->whereDate('payment.payment_date','>=',$from_date);
        }

        if($to_date){
            $query->whereDate('payment.payment_date','<=',$to_date);
        }

        return response()->json($query->orderBy('payment.payment_date','desc')->get());

    }


}