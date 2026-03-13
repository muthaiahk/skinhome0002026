<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\General;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    // Show all companies
    public function index() {
        $companies = Company::all();
        return view('company', compact('companies'));
    }

    // Get single company for editing
    // public function edit($id) {
    //     $company = Company::findOrFail($id);
    //     return response()->json([
    //         'status' => 200,
    //         'data' => $company
    //     ]);
    // }

    // Update company/general settings via AJAX
    // public function update(Request $request, $id) {
    //     $general = General::find($id);
    //     if (!$general) {
    //         return response()->json(['status'=>404,'message'=>'Record not found']);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'company_name' => 'required|string|max:255',
    //         'phone_no'     => 'required|string|max:20',
    //         'website'      => 'nullable|url',
    //         'established_date' => 'required|date',
    //         'logo'         => 'nullable|image|mimes:jpg,jpeg,png',
    //         'favicon'      => 'nullable|image|mimes:jpg,jpeg,png',
    //         'default_pic'  => 'nullable|image|mimes:jpg,jpeg,png',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 422,
    //             'message' => 'Validation error',
    //             'errors' => $validator->errors()
    //         ]);
    //     }

    //     // Update fields
    //     $general->company_name     = $request->company_name;
    //     $general->phone_no         = $request->phone_no;
    //     $general->website          = $request->website;
    //     $general->established_date = $request->established_date;

    //     // Handle file uploads
    //     if ($request->hasFile('logo')) {
    //         $file = $request->file('logo');
    //         $filename = 'logo_'.time().'.'.$file->getClientOriginalExtension();
    //         $file->move(public_path('assets/logo/'), $filename);
    //         $general->logo = asset('assets/logo/'.$filename);
    //     }

    //     if ($request->hasFile('favicon')) {
    //         $file = $request->file('favicon');
    //         $filename = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
    //         $file->move(public_path('assets/logo/'), $filename);
    //         $general->favicon = asset('assets/logo/'.$filename);
    //     }

    //     if ($request->hasFile('default_pic')) {
    //         $file = $request->file('default_pic');
    //         $filename = 'default_'.time().'.'.$file->getClientOriginalExtension();
    //         $file->move(public_path('assets/logo/'), $filename);
    //         $general->default_pic = asset('assets/logo/'.$filename);
    //     }

    //     $general->save();

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'General settings updated successfully!',
    //         'data' => $general
    //     ]);
    // }
     public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('edit_company', compact('company'));
    }

    // Update company
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'company_name' => 'required|string|max:255',
        ]);

        // Find and update company
        $company = Company::findOrFail($id);
        $company->company_name = $request->company_name;
        $company->save();

        // Return JSON for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Company updated successfully!',
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['status' => 404, 'message' => 'Company not found']);
        }

        $company->status = $request->status;
        $company->save();

        return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
    }
}