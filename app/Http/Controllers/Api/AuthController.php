<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $sendData['token'] = $user->createToken('Register Api')->plainTextToken;
        $sendData['name'] = $request->name;
        $sendData['email'] = $request->email;
        if ($sendData) {
            return SendResponse(201, __('keywords.User Account Created Successfully'), $sendData);
        }
    }
    

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // $user = Auth::user();
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $sendData['token'] =  $user->createToken('login Token')->plainTextToken;
                $sendData['name'] =  $user->name;
                $sendData['email'] =  $user->email;
            }

            return SendResponse(201, __('keywords.Login Successfully'), $sendData);
        } else {
            return SendResponse(401, __('keywords.These credentials doesn\'t exist'), null);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return sendResponse(200, __('keywords.Logged out successfully'), []);
    }
}
