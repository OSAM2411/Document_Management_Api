<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{

    
    public function register(RegisterUserRequest $request)
    {
        $validation=$request->validated();

        $user=User::create([
            'name'=>$validation['name'],
            'phone' => $validation['phone'],
            'password' => Hash::make($validation['password']),
            'role' => 'user',
        ]);
        $token=$user->createToken('auth:sanctum')->plainTextToken;

        return (new UserResource($user))
        ->additional([
            'message'=>'بەسەرکەوتوی تۆمارکرا',
            'token'=>$token,
        ])
        ->response()
        ->setStatusCode(201);
    }

   
    public function login(LoginUserRequest $request)
    {
        $validation=$request->validated();

        $user=User::where('phone',$validation['phone'])->first();

        if(!$user || ! Hash::check($validation['password'],$user->password)){
            return response()->json([
                'message'=>'بەداخەوە ژمارەی مۆبایل یان نهێنی هەڵەیە'
            ],401);
        }
        $token = $user->createToken('auth:sanctum')->plainTextToken;


        return (new UserResource($user))
            ->additional([
                'token' => $token,
            ])
            ->response()
            ->setStatusCode(200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
