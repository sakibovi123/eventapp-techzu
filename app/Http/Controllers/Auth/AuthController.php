<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view("Auth.register");
    }

    public function registerUser(Request $request)
    {
        try{
            $validatedData = $request->validate([
                "name" => "required|string|min:5",
                "email" => "required|unique:users|max:255|string",
                "password" => "required|string|min:8"
            ]);
            // dd($validatedData["name"]);
            // creating users after validating
            $user = User::create([
                "name" => $validatedData["name"],
                "email" => $validatedData["email"],
                "password" => Hash::make($validatedData["password"])
            ]);
            // dd($user);
            if ( $user ) {
                auth()->login($user);
                return redirect()->route("events.index");
            }
            else{
                return redirect()->back()->withErrors(["error" => "Validation failed"]);
            }
        }
        catch( ValidationException $e ) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function showLoginForm()
    {
        return view("Auth.login");
    }

    public function userLogin( Request $request )
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                $request->session()->regenerate();
                return redirect()->route("events.index");
            }

            return redirect()->back()->withErrors(['email' => __('auth.failed')])->withInput();
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function userLogout( Request $request )
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
