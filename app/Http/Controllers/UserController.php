<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //show user registration form
    public function create()
    {
        # code...
        return view('users.register');
    }

    //create new user
    public function store(Request $request)
    {
        # code...
        $formFields = $request->validate([
            'name' => ['required',' min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        //hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user = User::create($formFields);

        //login 
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    //Logout 
    public function logout(Request $request)
    {
        # code...
        auth()->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('message', 'You have been logged out');
    }

    //show login form
    public function login()
    {
        # code...
        return view('users.login');

    }

    //authenticate user
    public function authenticate(Request $request)
    {
    //     # code...
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput(['email', 'password']);

    }
}
