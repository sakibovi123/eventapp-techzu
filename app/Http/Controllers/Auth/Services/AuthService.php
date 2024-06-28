<?php

use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService{

    public function createUser(Request $request) 
    {
        try{
            // validating data first before procesing
            $validatedData = $request->validate([
                "name" => "required|string|min:8",
                "email" => "required|unique:users|max:255|string",
                "password" => "required|string|min:8"
            ]);

            // creating users after validating
            $user = User::create([
                "name" => $validatedData["name"],
                "email" => $validatedData["email"],
                "password" => Hash::make($validatedData["password"])
            ]);

            return redirect();
        }
        catch( ValidationException $e ) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
       
    }


    public function loginUser(Request $request) {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}