<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LeadSource;

class LeadSourceController extends Controller
{
    // View Index page
    public function IndexView()
    {
        $lead_sources = LeadSource::where('status','!=',2)->get();
        return view('lead_source', compact('lead_sources'));
    }

    // AJAX JSON data for listing (optional)
    public function Index()
    {
        $lead_sources = LeadSource::where('status','!=',2)->get();
        return response()->json(['status'=>200,'data'=>$lead_sources]);
    }

    // View Add page
    public function AddView()
    {
        return view('add_lead_source');
    }

    // Add Lead Source
    public function Add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_source_name' => 'required|unique:lead_source|max:255',
        ]);

        if($validator->fails()){
            return response([
                'status'=>401,
                'message'=>'Validation Error',
                'error_msg'=>$validator->messages()->get('*')
            ],401);
        }

        $lead_source = new LeadSource;
        $lead_source->lead_source_name = $request->lead_source_name;
        $lead_source->created_by = $request->user()->id;
        $lead_source->modified_by = $request->user()->id;
        $lead_source->status = 1;
        $lead_source->save();

        return response([
            'status'=>200,
            'message'=>'Lead Source created successfully'
        ],200);
    }

    // View Edit page
    public function EditView($id)
    {
        $lead_source = LeadSource::findOrFail($id);
        return view('edit_lead_source', compact('lead_source'));
    }

    // Update Lead Source
    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lead_source_name' => 'required|unique:lead_source,lead_source_name,'.$id.',lead_source_id|max:255',
        ]);

        if($validator->fails()){
            return response([
                'status'=>401,
                'message'=>'Validation Error',
                'error_msg'=>$validator->messages()->get('*')
            ],401);
        }

        $lead_source = LeadSource::findOrFail($id);
        $lead_source->lead_source_name = $request->lead_source_name;
        $lead_source->modified_by = $request->user()->id;
        $lead_source->update();

        return response([
            'status'=>200,
            'message'=>'Lead Source updated successfully'
        ],200);
    }

    // View Lead Source readonly
    public function View($id) 
    {
        $lead_source = LeadSource::findOrFail($id);
        return view('view_lead_source', compact('lead_source'));
    }
    public function Delete($id)
    {
        $brand = LeadSource::findOrFail($id);
        $brand->status = 2;
        $brand->save();

        return response([
            'status'=>200,
            'message'=>'Brand deleted successfully'
        ]);
    }

    public function Status(Request $request, $id)
    {
        $brand = LeadSource::findOrFail($id);
        $brand->status = $request->status;
        $brand->modified_by = auth()->id();
        $brand->save();

        return response([
            'status'=>200,
            'message'=>'Status updated successfully',
            'brand' => $brand,
        ]);
    }
}