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
        'status' => 200,

    ]);
    }

    public function isApiAdmin(){
        if(Auth::check()){
            if(Auth::user()->role_as==1){
                return response()->json([
                    'message' => 'you are in',
                    'status' => 200
                ],200);
            }else{
                return response()->json([
                    'status' =>403,
                    'message' =>'you are not system admin'
                ]);
            }

        }else{
            return response()->json([
                'status' =>401,
                'message' =>'you are not loggin'
            ]);
        }
    }
    public function register(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);

        $validator = validator::make( $request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // $user = User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'password' => Hash::make($validatedData['password']),
        // ]);

        if($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        }else{


                    $user = User::create([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                    ]);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'message' => "User registered successfully",
                        'access_token' => $token,
                        'status' => 200,
                        'userName' =>$user->name ,

                    ]);

                }




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
                    'status' => 401,
                ]);
            }
      
            $user = User::where('email', $request['email'])->firstOrFail();
            if ($user->role_as ==1){
                $role ='admin';
                $token = $user->createToken('admin_token',['server:admin'])->plainTextToken;

            }else{
                $role ='';
                $token = $user->createToken('auth_token',[''])->plainTextToken;
            }
           

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => "User logged in successfully",
                'status' => 200,
                'userName' =>$user->name ,
                'adminRole'=>$role,
            ]);
        }


    }


}
