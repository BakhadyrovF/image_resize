<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterFormRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"])
        ]);


        $token = $user->createToken("myToken")->plainTextToken;

        return response([
            "user" => $user,
            "token" => $token
        ], 201);




    }

    public function login(LoginFormRequest $request)
    {
        $data = $request->validated();

        if(auth()->attempt($data))
        {
            $user = auth()->user();
            $token = $user->createToken("loginToken")->plainTextToken;

            return response([
                "user" => $user,
                "token" => $token
            ]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response("", 204);
    }
}
