<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:16',
            'username' => 'required|string|max:16|unique:User',
            'password' => 'required|min:8|confirmed',
            'birth_date' => 'required|date|before:today|before:2008-01-01|date_format:Y-m-d',
            'email' => 'required|email|max:250|unique:User'
        ]);

        User::create([
            'nickname' => $request->nickname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'email' => $request->email
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
