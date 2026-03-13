<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductCategory;
use App\Models\ProductBrand;

class ProductCategoryController extends Controller
{
    // Show categories and brands in Blade
    public function index()
    {
        $product_categories = ProductCategory::where('status', '!=', 2)->with('brand')->get();
        $ProductBrands = ProductBrand::where('status', '!=', 2)->get();

        return view('product_category', compact('product_categories', 'ProductBrands'));
    }

    // Store new category
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prod_cat_name' => 'required|unique:product_category|max:255',
            'brand_id' => 'nullable|exists:brand,brand_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $category = new ProductCategory();
        $category->prod_cat_name = $request->prod_cat_name;
        $category->brand_id = $request->brand_id;
        $category->created_by = $request->user()->id ?? 0;
        $category->modified_by = $request->user()->id ?? 0;
        $category->status = 1;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product category created successfully',
            'data' => $category
        ]);
    }

    // Get single category for edit
    public function edit($id)
    {
        $category = ProductCategory::find($id);
        if (!$category) {
            return response()->json(['status' => 404, 'message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // Update category
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'prod_cat_name' => 'required|unique:product_category,prod_cat_name,' . $id . ',prod_cat_id|max:255',
            'brand_id' => 'nullable|exists:brand,brand_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $category = ProductCategory::find($id);
        if (!$category) {
            return response()->json(['status' => 404, 'message' => 'Category not found'], 404);
        }

        $category->prod_cat_name = $request->prod_cat_name;
        $category->brand_id = $request->brand_id ?? $category->brand_id;
        $category->modified_by = $request->user()->id ?? 0;
        $category->update();

        return response()->json([
            'status' => 200,
            'message' => 'Product category updated successfully',
            'data' => $category
        ]);
    }

    // Soft delete category
    public function destroy($id)
    {
        $category = ProductCategory::find($id);
        if (!$category) {
            return response()->json(['status' => 404, 'message' => 'Category not found'], 404);
        }

        $category->status = 2;
        $category->update();

        return response()->json([
            'status' => 200,
            'message' => 'Product category deleted successfully'
        ]);
    }

    // Toggle category status
    public function toggleStatus(Request $request, $id)
    {
        $category = ProductCategory::find($id);
        if (!$category) {
            return response()->json(['status' => 404, 'message' => 'Category not found'], 404);
        }

        $category->status = $request->status ?? ($category->status ? 0 : 1);
        $category->update();

        return response()->json([
            'status' => 200,
            'message' => 'Category status updated successfully'
        ]);
    }
}