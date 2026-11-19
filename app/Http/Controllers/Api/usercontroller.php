<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validation = $request->validated();
        $user=User::create([
            'name' => $validation['name'],
            'phone' => $validation['phone'],
            'password' => Hash::make($validation['password']),
            'role' => $validation['role'],
            ]);

        return (new UserResource($user))
            ->additional([
                'message' => 'successfull'
            ])
            ->response()
            ->setStatusCode(200);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user=User::findOrFail($id);
        $validation=$request->validated();

        $user->update( $validation);

        return (new UserResource($user))
            ->additional([
                'message' => 'successfull'
            ])
            ->response()
            ->setStatusCode(200);

    }

    public function profile(UpdateProfileRequest $request){
        $user = $request->user();
        $validation = $request->validated();
        
        $user->update($validation);

        return (new UserResource($user))
            ->additional([
                'message' => 'successfullprofile updated',
            ])
            ->response()
            ->setStatusCode(200);

    }

    public function changepassword(UpdateProfilePasswordRequest $request){
        $user = $request->user();
        $validation = $request->validated();

        $user->update($validation);

        return (new UserResource($user))
            ->additional([
                'message' => 'successfullpassword updated',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function delete( $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return (new UserResource($user))
            ->additional([
                'message' => 'successfullprofile deleted',
            ])
            ->response()
            ->setStatusCode(200);
    }

}
