<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_email' => 'required|email|exists:users,email',
            'login_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            $credentials = ['email' => $request->input('login_email'), 'password' => $request->input('login_password')];

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'msg' => 'Invalid credentials']);
            }
        }
    }

    public function logout_user()
    {
        Auth::logout();
        return redirect()->route('landing');
    }

    public function register_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            $full_name = ucwords($request->input('first_name')) . ' ' . ucwords($request->input('last_name'));
            $user = User::create([
                'name' => $full_name,
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);
            return response()->json(['success' => true]);
        }
    }
}
