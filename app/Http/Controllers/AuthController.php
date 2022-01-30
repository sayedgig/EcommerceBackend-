<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout(Request $request){
      auth()->user()->tokens()->delete();
      return response()->json([
        'message' => "logged out successfully",
        'status' => '200',

    ]);
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => "User registered successfully",
            'access_token' => $token,
            'status' => '200',
            'userName' =>$user->name ,

        ]);
    }
    public function login(Request $request)
    {
        $validator = validator::make( $request->all(), [
            'email' => 'required|string|email|max:30',
            'password' => 'required|string|max:20',
        ]);
        if($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }else{
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid login details',
                    'status' => '401',
                ]);
            }
    
            $user = User::where('email', $request['email'])->firstOrFail();
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => "User logged in successfully",
                'status' => '200',
                'userName' =>$user->name ,
            ]);
        }
        

    }

    
}
