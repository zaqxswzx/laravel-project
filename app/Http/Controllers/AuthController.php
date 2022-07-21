<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function indexSignup()
    {
        return view('web.signup');
    }
    public function indexLogin()
    {
        return view('web.login');
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if(!Auth::attempt($validatedData)){
            return response('授權失敗', 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Token');
        $tokenResult->token->save();
        return response(['token' => $tokenResult->accessToken]);
    }
    public function signup(CreateUser $request)
    {
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        $user->save();
        return view('web.registered', [
            'signup' => true
        ]);
    }
    public function user(Request $request)
    {
        return response(
            $request->user()
        );
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(
            ['message' => '成功登出']
        );
    }
}
