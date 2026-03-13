<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductBrand;

class BrandController extends Controller
{
    // List
    public function IndexView()
    {
        $brands = ProductBrand::where('status','!=',2)->get();
        return view('brand', compact('brands'));
    }

    // Add view
    public function AddView()
    {
        return view('add_brand');
    }

    // Edit view
    public function EditView($id)
    {
        $brand = ProductBrand::findOrFail($id);
        return view('edit_brand', compact('brand'));
    }

    // Add
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brand,brand_name|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $brand = ProductBrand::create([
            'brand_name' => $request->brand_name,
            'status' => 1,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id()
        ]);

        return response()->json(['success'=>'Brand Added']);
    }

    // Update
    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brand,brand_name,'.$id.',brand_id|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $brand = ProductBrand::findOrFail($id);
        $brand->update([
            'brand_name'=>$request->brand_name,
            'modified_by'=>auth()->id()
        ]);

        return response()->json(['success'=>'Brand Updated']);
    }

    // Delete (Soft)
    public function Delete($id)
    {
        $brand = ProductBrand::findOrFail($id);
        $brand->update(['status'=>2]);

        return response()->json(['success'=>'Brand Deleted']);
    }

    // Status toggle
    public function Status(Request $request, $id)
    {
        $brand = ProductBrand::findOrFail($id);
        $brand->update([
            'status'=>$request->status,
            'modified_by'=>auth()->id()
        ]);

        return response()->json(['success'=>'Status Updated']);
    }
}