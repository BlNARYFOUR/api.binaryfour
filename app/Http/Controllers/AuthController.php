<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'email'    => $request->email,
            'name'     => $request->name,
            'password' => $request->password,
            'verify_token' => bcrypt($request->email),
        ]);

        $data = array('verificationCode' => $user->verify_token);
        Mail::send('userVerifyMail', $data, function($message) {
            $message->to('lambertbrend@gmail.com', 'BinaryFour')->subject
            ('blog.binaryfour.be - verify user');
            $message->from('info@binaryfour.be','info@binaryfour.be');
        });

        return response()->json(['message' => 'Registration succeeded. When your account has been verified, you will receive an email.'], 201);
    }

    public function verify() {
        $user = User::where('verify_token', request('token'))->first();

        if(!is_null($user)) {
            $user->verified_at = now();
            $user->verify_token = null;
            $user->save();

            return response()->json(['message' => 'User successfully verified.'], 202);
        }

        return response()->json(['message' => 'User could not be verified.']);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $verifiedAt = User::where('email', request('email'))->pluck('verified_at')->first();

        if(is_null($verifiedAt)) {
            return response()->json(['error' => 'User has not yet been verified.'], 401);
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email and password do not match.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
