<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Models\Specialization;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $userType = $request->input('user_type');
        
        if ($userType === 'admin') {
            if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
        } elseif ($userType === 'doctor') {
            if (Auth::guard('doctor')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/doctor/dashboard');
            }
        } else {
            // تسجيل دخول المريض
            if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect('/');
            }
        }

        // إذا فشل تسجيل الدخول
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
