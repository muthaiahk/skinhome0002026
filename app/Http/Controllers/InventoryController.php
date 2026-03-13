<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Inventory;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Stock;
use App\Models\Staff;

class InventoryController extends Controller
{
    public function All(Request $request)
    {
        $inventory = Inventory::select(
            'inventory.inventory_id',
            'inventory.inventory_date',
            'inventory.stock_in_hand',
            'company.company_name',
            'branch.branch_name',
            'brand.brand_name',
            'product_category.prod_cat_name',
            'product.product_name'
        )
        ->join('company','company.company_id','=','inventory.company_id')
        ->join('brand','brand.brand_id','=','inventory.brand_id')
        ->join('product_category','product_category.prod_cat_id','=','inventory.prod_cat_id')
        ->join('product','product.product_id','=','inventory.product_id')
        ->join('branch','branch.branch_id','=','inventory.branch_id')
        ->where('inventory.status','!=',2)
        ->get();

        $branches = Branch::where('status','!=',2)->get();
        $brands = Brand::where('status','!=',2)->get();
        $categories = ProductCategory::where('status','!=',2)->get();
        $products = Product::where('status','!=',2)->get();

        $Company = Company::first();

        return view('inventory',compact(
            'inventory',
            'branches',
            'brands',
            'categories',
            'products',
            'Company'
        ));
    }
    // public function All(Request $request)
    // {

    //     $branch_id = $request->branch_id;
    //     $brand_id = $request->brand_id;
    //     $pc_id = $request->pc_id;
    //     $p_id = $request->p_id;

    //     $inventory = Inventory::select('inventory_id', 'stock_in_hand', 'stock_alert_count', 'description', 'inventory_date', 'company.company_id', 'company.company_name', 'product_category.prod_cat_id', 'product_category.prod_cat_name', 'product.product_id', 'product.product_name', 'brand.brand_id', 'brand.brand_name', 'branch.branch_id', 'branch.branch_name', 'inventory.status')
    //         ->join('company', 'company.company_id', '=', 'inventory.company_id')
    //         ->join('brand', 'brand.brand_id', '=', 'inventory.brand_id')
    //         ->join('product_category', 'product_category.prod_cat_id', '=', 'inventory.prod_cat_id')
    //         ->join('product', 'product.product_id', '=', 'inventory.product_id')
    //         ->join('branch', 'branch.branch_id', '=', 'inventory.branch_id')
    //         ->where('inventory.status', '!=', 2);

    //     if ($branch_id > 0) {
    //         $idArray = explode(',', $branch_id); // Convert the comma-separated string to an array
    //         $inventory = $inventory->whereIn('inventory.branch_id', $idArray);
    //     }

    //     if ($brand_id > 0) {
    //         $inventory = $inventory->where('inventory.brand_id', $brand_id);
    //     }

    //     if ($pc_id > 0) {
    //         $inventory = $inventory->where('inventory.prod_cat_id', $pc_id);
    //     }

    //     if ($p_id > 0) {
    //         $inventory = $inventory->where('inventory.product_id', $p_id);
    //     }

    //     $page = $request->input('page', 1); // Default to page 1
    //     $limit = $request->input('limit', 10); // Default limit
    //     // Get the total count for pagination
    //     $total = $inventory->count();
    //     $inventory = $inventory->skip(($page - 1) * $limit)->take($limit)->get();
    //     return response([
    //         'status'    => 200,
    //         'message'   => 'Success',
    //         'error_msg' => null,
    //         'data'      => $inventory,
    //         'total' => $total,
    //         'page' => $page,
    //         'limit' => $limit
    //     ], 200);
    // }
    public function Add(Request $request)
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

            $inventory_date        = $request->inventory_date;
            $company_id            = $company->company_id;
            $branch_id             = $request->branch_id;
            $prod_cat_id           = $request->prod_cat_id;
            $product_id            = $request->product_id;
            $brand_id              = $request->brand_id;
            $stock_in_hand         = $request->stock_in_hand;
            $stock_alert_count     = $request->stock_alert_count;
            $description           = $request->description;

            $inventory   = new inventory;

            $inventory->inventory_date  = $inventory_date;
            $inventory->company_id      = $company_id;
            $inventory->branch_id       = $branch_id;
            $inventory->prod_cat_id     = $prod_cat_id;
            $inventory->product_id      = $product_id;
            $inventory->brand_id       = $brand_id;
            $inventory->stock_in_hand   = $stock_in_hand;
            $inventory->stock_alert_count   = $stock_alert_count;
            $inventory->description     = $description;
            $inventory->created_by      = 1;
            $inventory->modified_by     = 1;

            $inventory->save();

            if ($inventory) {


                $chk_stock = Stock::where('branch_id', $branch_id)->where('prod_cat_id', $prod_cat_id)->where('product_id', $product_id)->where('brand_id', $brand_id)->first();

                if ($chk_stock) {

                    $chk_stock->stock_in_hand       = $chk_stock->stock_in_hand + $stock_in_hand;

                    $chk_stock->update();
                } else {

                    $stock   = new Stock;

                    $stock->company_id      = $company_id;
                    $stock->branch_id       = $branch_id;
                    $stock->prod_cat_id     = $prod_cat_id;
                    $stock->product_id      = $product_id;
                    $stock->brand_id        = $brand_id;
                    $stock->stock_in_hand   = $stock_in_hand;
                    $stock->stock_out       = 0;
                    $stock->created_by      = $request->user()->id;
                    $stock->modified_by     = $request->user()->id;

                    $stock->save();
                    // $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                    // $stock->stock_in_hand = $stock->stock_in_hand+$stock_in_hand;

                    // $stock->add();
                }




                $result =   response([
                    'status'    => 200,
                    'message'   => 'inventory has been created successfully',
                    'error_msg' => null,
                    'data'      => null,
                ], 200);
            } else {

                $result =   response([
                    'status'    => 401,
                    'message'   => 'inventory can not be created',
                    'error_msg' => 'inventory information is worng please try again',
                    'data'      => null,
                ], 401);
            }
        }

        return $result;
    }
    public function Edit($id)
    {

        $inventory = Inventory::select('inventory_id', 'stock_in_hand', 'stock_alert_count', 'description', 'inventory_date', 'company.company_id', 'company.company_name', 'product_category.prod_cat_id', 'product_category.prod_cat_name', 'product.product_id', 'product.product_name', 'brand.brand_id', 'brand.brand_name', 'branch.branch_id', 'branch.branch_name')
            ->join('company', 'company.company_id', '=', 'inventory.company_id')
            ->join('brand', 'brand.brand_id', '=', 'inventory.brand_id')
            ->join('product_category', 'product_category.prod_cat_id', '=', 'inventory.prod_cat_id')
            ->join('product', 'product.product_id', '=', 'inventory.product_id')
            ->join('branch', 'branch.branch_id', '=', 'inventory.branch_id')
            ->where('inventory.inventory_id', $id)
            ->get();

        return response([
            'data' => $inventory,
            'status' => 200
        ], 200);
    }
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

            $inventory_date        = $request->inventory_date;
            $company_id            = $company->company_id;
            $branch_id             = $request->branch_id;
            $prod_cat_id           = $request->prod_cat_id;
            $product_id            = $request->product_id;
            $brand_id              = $request->brand_id;
            $stock_in_hand         = $request->stock_in_hand;
            $stock_alert_count     = $request->stock_alert_count;
            $description           = $request->description;


            $inventory = Inventory::find($id);

            $inventory->inventory_date  = $inventory_date;
            $inventory->company_id      = $company_id;
            $inventory->branch_id       = $branch_id;
            $inventory->prod_cat_id     = $prod_cat_id;
            $inventory->product_id      = $product_id;
            $inventory->brand_id        = $brand_id;
            $inventory->stock_in_hand   = $stock_in_hand;
            $inventory->stock_alert_count   = $stock_alert_count;
            $inventory->description     = $description;
            $inventory->created_by      = $request->user()->id;
            $inventory->modified_by     = $request->user()->id;

            $inventory->update();

            $result =   response([
                'status'    => 200,
                'message'   => 'inventory has been Updated successfully',
                'error_msg' => null,
                'data'      => $inventory,
            ], 200);
        }

        return $result;
    }
    public function Delete($id)
    {
        $status = Inventory::where('inventory_id', $id)->first();

        if ($status) {
            $status->status = 2;
            $status->update();
        }
        return response([
            'data' => null,
            'message' => 'Successfully Delete',
            'status' => 200
        ], 200);
    }
    public function Status(Request $request, $id)
    {

        $inventory_status = Inventory::where('inventory_id', $id)->first();

        if ($inventory_status) {
            $inventory_status->status = $request->status;
            $inventory_status->modified_by =  $request->user()->id;
            $inventory_status->update();
        } else {
            return response([
                'data' => null,
                'message' => 'No data found',
                'status' => 404
            ], 404);
        }

        return response([
            'data' => null,
            'message' => 'Successfully Updated',
            'status' => 200
        ], 200);
    }

    public function CategoryList($id)
    {
        $category = ProductCategory::where('brand_id', $id)->get();
        return response([
            'data' => $category,
            'message' => 'Successfully Updated',
            'status' => 200
        ], 200);
    }
    public function ProductList($id)
    {
        $product = Product::where('prod_cat_id', $id)->get();
        return response([
            'data' => $product,
            'message' => 'Successfully',
            'status' => 200
        ], 200);
    }

    public function Count(Request $request)
    {
        $stock = Stock::where('branch_id', $request->branch_id)->where('brand_id', $request->brand_id)->where('prod_cat_id', $request->cat_id)
            ->where('product_id', $request->product_id)->first();

        if ($stock) {
            $count = $stock->stock_in_hand;
        } else {
            $count = 0;
        }

        return response([
            'count' => $count,
            'message' => 'Successfully',
            'status' => 200
        ], 200);
    }
}