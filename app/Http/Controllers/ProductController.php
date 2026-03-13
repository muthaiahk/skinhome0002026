<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\TreatmentCategory;
class ProductController extends Controller
{
    /**
     * Show the product page with list, ProductBrands, categories
     */
    public function index()
    {
        // Get all active products with ProductBrand and category relationships
        $products = Product::with(['brand', 'category'])
            ->where('status', '!=', 2)
            ->get();

        // Get all brands and categories for modal dropdowns
        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        $treatmentCategories = TreatmentCategory::where('status','!=', 2)->get();

        return view('product', compact('products', 'treatmentCategories','brands', 'categories'));
    }

    /**
     * Store a new product via AJAX
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:product|max:255',
            'brand_id'     => 'required|exists:brand,brand_id',
            'prod_cat_id'  => 'required|exists:product_category,prod_cat_id',
            'amount'       => 'required|numeric',
            'gst'          => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->brand_id     = $request->brand_id;
        $product->prod_cat_id  = $request->prod_cat_id;
        $product->amount       = $request->amount;
        $product->gst          = $request->gst;
        $product->status       = 1;
        $product->created_by   = $request->user()->id ?? 1;
        $product->modified_by  = $request->user()->id ?? 1;

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $imageName = time() . '_' . rand(1, 50) . '.' . $request->file('product_image')->extension();
            $request->file('product_image')->move(public_path('product_image'), $imageName);
            $product->product_image = $imageName;
        }

        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }

    /**
     * Edit a product via AJAX
     */
    public function edit($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);

        return response()->json([
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'amount' => $product->amount,
            'gst' => $product->gst,
            'brand_id' => $product->brand_id,
            'prod_cat_id' => $product->prod_cat_id, // Make sure it's prod_cat_id
            'product_image' => $product->product_image // Only filename
        ]);
    }

    /**
     * Update a product via AJAX
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:product,product_name,' . $id . ',product_id|max:255',
            'brand_id'     => 'required|exists:brand,brand_id',
            'prod_cat_id'  => 'required|exists:product_category,prod_cat_id',
            'amount'       => 'required|numeric',
            'gst'          => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::findOrFail($id);
        $product->product_name = $request->product_name;
        $product->brand_id     = $request->brand_id;
        $product->prod_cat_id  = $request->prod_cat_id;
        $product->amount       = $request->amount;
        $product->gst          = $request->gst;
        $product->modified_by  = $request->user()->id ?? 1;

        // Update image if new file uploaded
        if ($request->hasFile('product_image')) {
            $imageName = time() . '_' . rand(1, 50) . '.' . $request->file('product_image')->extension();
            $request->file('product_image')->move(public_path('product_image'), $imageName);
            $product->product_image = $imageName;
        }

        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }
public function ProductList(Request $request)
    {
        // Retrieve the category_id parameter from the request
        $categoryId = $request->query('category_id');

        // Build the query
        $query = Product::select(
                        'product_id',
                        'product_name',
                        'brand.brand_id',
                        'brand.brand_name',
                        'product_category.prod_cat_id',
                        'product_category.prod_cat_name',
                        'product.status',
                        'product.amount',
                        'product.gst',
                        'product.product_image'
                    )
                    ->join('brand', 'brand.brand_id', '=', 'product.brand_id')
                    ->join('product_category', 'product_category.prod_cat_id', '=', 'product.prod_cat_id')
                    ->where('product.status', '!=', 2);

        // Apply category filter if category_id is provided
        if ($categoryId) {
            $query->where('product.prod_cat_id', $categoryId);
        }

        // Execute the query and get the products
        $products = $query->get();

        // Return the response
        return response([
            'status'    => 200,
            'message'   => 'Success',
            'error_msg' => null,
            'data'      => $products,
        ], 200);
    }
    /**
     * Soft delete a product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 2;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Toggle product status
     */
    public function status(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product status updated successfully'
        ]);
    }
}