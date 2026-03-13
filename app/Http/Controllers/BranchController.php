<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Staff;
// use App\Models\Company;



class BranchController extends BaseController
{ public function index()
    {
        $branches = Branch::select(
            'branch.branch_id',
            'company.company_name',
            'branch.branch_name',
            'branch.branch_authority',
            'branch.branch_opening_date',
            'branch.branch_phone',
            'branch.branch_location',
            'branch.branch_email',
            'branch.is_franchise',
            'branch.status',
            'staff.name as authority_name'
        )
        ->where('branch.status', '!=', 2)
        ->where('staff.status', '!=', 2)
        ->join('company', 'company.company_id', '=', 'branch.company_id')
        ->join('staff', 'staff.staff_id', '=', 'branch.branch_authority')
        ->get();

        return view('branch', compact('branches'));
    }

    // Show add branch form
    public function create()
    {
        $companies = Company::all();
        $staffs = Staff::get();
        return view('add_branch', compact('companies', 'staffs'));
    }

    // Store new branch
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'branch_name' => 'required|unique:branch|max:255',
            'branch_phone' => 'required|unique:branch|max:10',
            'branch_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }

        Branch::create([
            'company_id' => $request->company_id,
            'branch_name' => $request->branch_name,
            'branch_email' => $request->branch_email,
            'branch_location' => $request->branch_location,
            'branch_phone' => $request->branch_phone,
            'branch_code' => $request->branch_code,
            'branch_authority' => $request->branch_authority,
            'branch_opening_date' => $request->branch_opening_date,
            'is_franchise' => $request->has('is_franchise') ? 1 : 0,
            'status' => 0,
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Branch created successfully!'
        ]);
    }

    // Show edit branch form
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $companies = Company::all();
        $staffs = Staff::get();
        return view('edit_branch', compact('branch', 'companies', 'staffs'));
    }

    // Update branch
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'branch_name' => 'required|unique:branch,branch_name,' . $id . ',branch_id|max:255',
            'branch_phone' => 'required|max:10',
            'branch_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }

        $branch->update([
            'company_id' => $request->company_id,
            'branch_name' => $request->branch_name,
            'branch_email' => $request->branch_email,
            'branch_location' => $request->branch_location,
            'branch_phone' => $request->branch_phone,
            'branch_code' => $request->branch_code,
            'branch_authority' => $request->branch_authority,
            'branch_opening_date' => $request->branch_opening_date,
            'is_franchise' => $request->has('is_franchise') ? 1 : 0,
            'modified_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Branch updated successfully!'
        ]);
    }

    // View branch details
    public function show($id)
    {
        $branch = Branch::with(['company', 'authority'])->findOrFail($id);
        return view('view_branch', compact('branch'));
    }

    // Delete branch
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update(['status' => 2]);

        return response()->json([
            'status' => 1,
            'message' => 'Branch deleted successfully!'
        ]);
    }

    // Toggle branch status
    public function toggleStatus($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->status = $branch->status == 0 ? 1 : 0;
        $branch->save();
        return redirect()->route('branch.index')->with('success', 'Branch status updated!');
    }
}