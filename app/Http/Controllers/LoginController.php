<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }
    public function profile()
    {
        $user = Auth::user();
        $staff = $user->staff; // get related staff record

        // For debugging
        // echo "<pre>"; print_r($staff); exit;

        return view('user_profile', compact('user', 'staff'));
    }
     public function update(Request $request)
    {
        $user = Auth::user();
        $staff = $user->staff;

        // Validation
        $request->validate([
            'staff_name' => 'required|string|max:255',
            'staff_phone' => 'nullable|string|max:20',
            'staff_email' => 'nullable|email|max:255',
            'staff_address' => 'nullable|string|max:500',
            'profile_avatar_default' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update staff info
        $staff->name = $request->staff_name;
        $staff->phone_no = $request->staff_phone;
        $staff->email = $request->staff_email;
        $staff->address = $request->staff_address;

        // Profile image upload
        if ($request->hasFile('profile_avatar_default')) {
            $file = $request->file('profile_avatar_default');
            $path = $file->store('profile_images', 'public');
            $staff->profile_avatar = $path;
        }

        $staff->save();

        return response()->json(['success' => 'Profile updated successfully.']);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful!',
            'redirect' => route('dashboard')
        ]);
    }

    // public function logout() {
    //     Auth::logout();
    //     return redirect('/');
    // }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function State() {
        $states = State::all();
        return response()->json([
            'data' => $states,
            'status' => 200,
        ], 200);
    }
}