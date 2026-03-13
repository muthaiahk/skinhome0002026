<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use App\Models\General;
use App\Models\Company;

class GeneralController extends Controller
{
    public function index()
    {
        // Assuming you only have one general settings record
        $general = General::first(); // Get the first record

        // echo "<pre>";
        // print_r($general);
        // exit;
        
        return view('general', compact('general')); // return Blade view
    }

    // Update general settings
    public function update(Request $request, $id)
    {
        $general = General::findOrFail($id);

        // Validate input (you can adjust rules as needed)
        $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile'       => 'required|string|max:20',
            'website'      => 'nullable|url',
            'date_format'  => 'required|string',
            'opening_date' => 'required|date',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png',
            'favicon'      => 'nullable|image|mimes:jpg,jpeg,png',
            'default_pic'  => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $general->company_name = $request->company_name;
        $general->phone_no = $request->mobile;
        $general->website = $request->website;
        $general->date_format = $request->date_format;
        $general->established_date = $request->opening_date;

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/logo/'), $filename);
            $general->logo = asset('assets/logo/'.$filename);
        }

        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/logo/'), $filename);
            $general->favicon = asset('assets/logo/'.$filename);
        }

        if ($request->hasFile('default_pic')) {
            $file = $request->file('default_pic');
            $filename = 'default_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/logo/'), $filename);
            $general->default_pic = asset('assets/logo/'.$filename);
        }

        $general->save();

        return response()->json([
            'status' => 200,
            'message' => 'General settings updated successfully!',
            'data' => $general
        ]);
    }
}