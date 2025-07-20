<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'name.required' => 'Please enter your name',
                'email.required' => 'Please enter your email',
                'email.email' => 'Please enter a valid email address',
                'email.unique' => 'This email is already registered',
                'phone.required' => 'Please enter your phone number',
                'phone.unique' => 'This phone number is already registered',
                'password.required' => 'Please enter a password',
                'password.min' => 'Password must be at least 8 characters',
                'password.confirmed' => 'Password confirmation does not match',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'patient'
            ]);

            // Create patient record
            Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email
            ]);

            DB::commit();

            // Log the user in
            Auth::login($user);

            // Redirect to welcome page
            return redirect()->route('welcome')->with('success', 'Account created successfully! Welcome to our clinic.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating your account. Please try again.');
        }
    }
} 