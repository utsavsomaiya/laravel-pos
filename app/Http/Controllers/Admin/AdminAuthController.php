<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','exists:admins,name','max:255'],
            'password' => ['required','min:7','max:16'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('/admin/dashboard')->with(['success'=>'Welcome back!!']);
        }
        return back()->with([
            'error' => 'Incorrect credentials.'
        ]);
    }
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','unique:admins,name','max:255'],
            'email' => ['required','email','unique:admins,email'],
            'password' => ['required','min:7','max:16','confirmed'],
        ]);

        $user = Admin::create($credentials);

        Auth::login($user);

        return redirect('/admin/dashboard')->with(['success' => 'Welcome to retail store!!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin')->with([
            'success' => 'Good Bye!!'
        ]);
    }
}
