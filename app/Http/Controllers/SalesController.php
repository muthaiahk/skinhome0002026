<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductCategory;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\Staff;
class SalesController extends Controller
{
    //
     public function All(Request $request){
        
        $branch_id = $request->branch_id;

        $sales = Sales::select('sales_id','product.product_id','product.product_name','brand.brand_id', 'brand.brand_name','product_category.prod_cat_id','product_category.prod_cat_name','customer.customer_id','customer.customer_first_name','customer.customer_last_name','customer.customer_phone','sales.amount','sales.date','sales.status','sales.branch_id','branch.branch_name')
                       ->join('brand', 'brand.brand_id','=','sales.brand_id')
                       ->join('product', 'product.product_id','=','sales.product_id')
                       ->leftjoin('branch', 'branch.branch_id','=','sales.branch_id')
                       ->join('product_category', 'product_category.prod_cat_id','=','sales.prod_cat_id')
                       ->join('customer', 'customer.customer_id','=','sales.customer_id');
                        // ->where('product.status', '!=', 2)
                        // ->get();
                        
                        
        // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->staff_id)->first();
        
        // if($branch->role_id > 0){
        //     $sales = $sales->where('sales.branch_id',$branch->branch_id);
        // }

        if(isset($branch_id)){
            if($branch_id > 0){
                $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
                // $app_payment = $app_payment->where('lead.branch_id',$id);
                $sales = $sales->whereIn('sales.branch_id',$idArray);
            } 
         } 
        if(isset($request->from) && isset($request->to)){
            $sales = $sales->whereBetween('date', [$request->from,$request->to]);
            
        }
        $sales = $sales->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $sales ,
                        ],200);

    }
    public function Add(Request $request){
        
        $validator = Validator::make($request->all(), [ 
                                                       // 'amount' => 'required|unique:sales|max:255',
                                                    ]);


        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

          
        }else{
          

            $customer_id    = $request->customer_id;
            $brand_id       = $request->brand_id;
            $cat_id         = $request->prod_cat_id;
            $product_id     = $request->product_id;
            $amount         = $request->amount;
            $quantity       = $request->quantity;
            $date           = date('Y-m-d H:i:s');


            $branch = Customer::where('customer_id',$customer_id)->first();

            $stock = Stock::where('branch_id',$branch->branch_id)->where('product_id',$product_id)->first();

            if(!$stock){

                return response([
                    'status'    => 401,
                    'message'   => 'Product Not in stock',
                    'error_msg' => null,
                    'data'      => null ,
                ],401);

            }else{
                if($stock->stock_in_hand == 0){
                    return response([
                        'status'    => 401,
                        'message'   => 'Product Not in stock',
                        'error_msg' => null,
                        'data'      => null ,
                    ],401);
                }
        
            }
            
            
           // $branch = Staff::select('branch_id','role_id')->where('staff_id',$request->user()->id)->first();

            
            $add_sales   = new Sales;

            $add_sales->customer_id   = $customer_id;
            $add_sales->brand_id      = $brand_id;
            $add_sales->prod_cat_id   = $cat_id;
            $add_sales->product_id    = $product_id;
            $add_sales->amount        = $amount;
            $add_sales->quantity      = $quantity;
            $add_sales->date          = $date;
            $add_sales->branch_id    = $branch->branch_id;
            $add_sales->created_by    = $request->user()->id;
            $add_sales->updated_by    = $request->user()->id;
        
            $add_sales->save();

            if($add_sales){

                $branch = Customer::where('customer_id',$customer_id)->first();

                $stock = Stock::where('branch_id',$branch->branch_id)->where('product_id',$product_id)->first();

                $stock->stock_in_hand = $stock->stock_in_hand - $quantity;

                $stock->update();
                
                $result =   response([
                                        'status'    => 200,
                                        'message'   => 'Product has been sale successfully',
                                        'error_msg' => null,
                                        'data'      => null ,
                                    ],200);

            }else{

                $result =   response([

                        'status'    => 401,
                        'message'   => 'Sales can not be created',
                        'error_msg' => 'sales information is worng please try again',
                        'data'      => null ,
                    ],401);
            }
            
            
        }

        return $result;
    }
    public function Edit($id){

        $sales = Sales::select('sales_id','product.product_id','product.product_name','product.gst','brand.brand_id', 'brand.brand_name','product_category.prod_cat_id','product_category.prod_cat_name','customer.customer_id','customer.customer_first_name','customer.customer_last_name','sales.amount','sales.date','sales.status','customer.customer_address','customer.customer_phone','customer.customer_email')
                        ->join('brand', 'brand.brand_id','=','sales.brand_id')
                        ->join('product', 'product.product_id','=','sales.product_id')
                    
                        ->join('product_category', 'product_category.prod_cat_id','=','sales.prod_cat_id')
                        ->join('customer', 'customer.customer_id','=','sales.customer_id')
                        ->where('sales.sales_id', $id)
                        ->get();

        return response([
                            'status'    => 200,
                            'message'   => 'Success',
                            'error_msg' => null,
                            'data'      => $sales ,
                        ],200);

    }
    public function Update(Request $request,$id){

        $validator = Validator::make($request->all(), [ 
                                                       // 'product_name' => 'required|unique:product,product_name,'.$id.',product_id|max:255',
                                                       
                                                    ]);

        if($validator->fails()) {
            $result =   response([
                                    'status'    => 401,
                                    'message'   => 'Incorrect format input feilds',
                                    'error_msg'     => $validator->messages()->get('*'),
                                    'data'      => null ,
                                ],401);

        }else{
            $customer_id    = $request->customer_id;
            $brand_id       = $request->brand_id;
            $cat_id         = $request->prod_cat_id;
            $product_id     = $request->product_id;
            $amount         = $request->amount;
            $quantity       = $request->quantity;
            
            
            $upd_sales = Sales::where('sales_id',$id)->first();

            $upd_sales->customer_id   = $customer_id;
            $upd_sales->brand_id      = $brand_id;
            $upd_sales->prod_cat_id   = $cat_id;
            $upd_sales->product_id    = $product_id;
            $upd_sales->amount        = $amount;
            $upd_sales->quantity      = $quantity;
            $upd_sales->date          =  $upd_sales->date;
            $upd_sales->updated_by  =  $request->user()->id;

            $upd_sales->update();

            $result =   response([
                                    'status'    => 200,
                                    'message'   => 'successfull updated',
                                    'error_msg' => null,
                                    'data'      => $upd_sales,
                                     
                                ],200);
        }

        return $result;
    }
    public function Delete($id){
        $status = Sales::where('sales_id', $id)->first();

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

        $status = Sales::where('sales_id', $id)->first();

        if($status){
            $status->status = $request->status;
            $status->updated_by  =  $request->user()->id;
            $status->update();
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


    public function GetCategory($id){
        if($id == 0){
            $category = ProductCategory::all();
        }else{
           
            $category = ProductCategory::where('brand_id',$id)->get();
        }

        return response([
            'data' => $category,
            'message' => 'Success',
            'status' => 200
        ],200);
       
    }
    public function GetProduct($id){
        if($id == 0){
            $product = Product::all();
        }else{
            
            $product = Product::where('prod_cat_id',$id)->get();
        }

        return response([
            'data' => $product,
            'message' => 'Success',
            'status' => 200
        ],200);
    }
}
