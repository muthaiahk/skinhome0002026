<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Validator;

class LeadStatusController extends Controller
{
    // Show list
    public function index()
    {
        $lead_statuses = LeadStatus::where('status', '!=', 2)->get();
        return view('lead_status', compact('lead_statuses'));
    }

    // Add new
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_status_name' => 'required|unique:lead_status|max:255',
            'lead_status_description' => 'nullable|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = LeadStatus::create([
            'lead_status_name' => $request->lead_status_name,
            'lead_status_description' => $request->lead_status_description,
            'status' => 1,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        return response()->json(['success' => 'Lead Status created successfully', 'data' => $status]);
    }

    // Edit fetch
    public function edit($id)
    {
        $status = LeadStatus::findOrFail($id);
        return response()->json($status);
    }

    // Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lead_status_name' => 'required|unique:lead_status,lead_status_name,' . $id . ',lead_status_id|max:255',
            'lead_status_description' => 'nullable|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $status = LeadStatus::findOrFail($id);
        $status->update([
            'lead_status_name' => $request->lead_status_name,
            'lead_status_description' => $request->lead_status_description,
            'modified_by' => auth()->id(),
        ]);

        return response()->json(['success' => 'Lead Status updated successfully', 'data' => $status]);
    }

    // Delete
    public function destroy($id)
    {
        $status = LeadStatus::findOrFail($id);
        $status->status = 2; // soft delete
        $status->save();

        return response()->json(['success' => 'Lead Status deleted successfully']);
    }

    // Toggle status
    public function toggle($id)
    {
        $status = LeadStatus::findOrFail($id);
        $status->status = $status->status == 1 ? 0 : 1;
        $status->save();

        return response()->json(['success' => 'Status updated successfully', 'status' => $status->status]);
    }
}