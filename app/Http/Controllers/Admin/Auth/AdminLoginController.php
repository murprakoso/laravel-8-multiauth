<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Login Form
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Submit login
     */
    public function login(Request $request)
    {
        // validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if succesfull then redirect to dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // if unsuccesfull redirect to the login with form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
