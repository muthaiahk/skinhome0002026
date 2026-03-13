<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Validator;

class TreatmentCategoryController extends Controller
{
    public function index(){
        $categories = TreatmentCategory::where('status', '!=', 2)->get();
        return view('t_category', compact('categories'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'tc_name' => 'required|unique:treatment_category|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>401,'errors'=>$validator->errors()]);
        }

        $cat = new TreatmentCategory();
        $cat->tc_name = $request->tc_name;
        $cat->tc_description = $request->tc_description;
        $cat->status = 1;
        $cat->created_by = $request->user()->id ?? 1;
        $cat->modified_by = $request->user()->id ?? 1;
        $cat->save();

        return response()->json(['status'=>200, 'message'=>'Treatment Category created successfully']);
    }

    public function edit($id){
        $cat = TreatmentCategory::findOrFail($id);
        return response()->json($cat);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'tc_name' => 'required|unique:treatment_category,tc_name,'.$id.',tcategory_id|max:255',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>401,'errors'=>$validator->errors()]);
        }

        $cat = TreatmentCategory::findOrFail($id);
        $cat->tc_name = $request->tc_name;
        $cat->tc_description = $request->tc_description;
        $cat->modified_by = $request->user()->id ?? 1;
        $cat->save();

        return response()->json(['status'=>200, 'message'=>'Treatment Category updated successfully']);
    }

    public function destroy($id){
        $cat = TreatmentCategory::findOrFail($id);
        $cat->status = 2;
        $cat->save();

        return response()->json(['status'=>200,'message'=>'Deleted successfully']);
    }

    public function status(Request $request, $id){
        $cat = TreatmentCategory::findOrFail($id);
        $cat->status = $request->status;
        $cat->save();
        return response()->json(['status'=>200,'message'=>'Status updated successfully']);
    }
}