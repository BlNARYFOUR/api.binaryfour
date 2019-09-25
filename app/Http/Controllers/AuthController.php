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
            $message->to('brendlambert@hotmail.com', 'BinaryFour')->subject
            ('blog.binaryfour.be - verify user');
            $message->from('info@binaryfour.be','Virat Gandhi');
        });

        return response()->json(['message' => 'Registration succeeded. When your account has been verified, you will receive an email.']);
    }

    public function verify($verifyToken) {
        //User::where
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $verifiedAt = User::where('email', request('email'))->pluck('verified_at')->first();

        return response()->json($verifiedAt);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
