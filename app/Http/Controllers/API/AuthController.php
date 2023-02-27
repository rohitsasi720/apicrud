<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $data['email'])->first();
        
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }
        else {
            $token = $user->createToken('authTokenLogin')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'User logged in successfully.'], 200);
        }
    }
    
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]); 
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $token = $user->createToken('authTokenRegister')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User created successfully.'], 201);
    }
    
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }
    
}