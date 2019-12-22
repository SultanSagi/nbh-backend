<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'sometimes|required|string',
            'surname' => 'sometimes|required|string',
            'birthday' => 'sometimes|required|date',
            'phone' => 'sometimes|nullable',
            'address' => 'sometimes|nullable',
            'country' => 'sometimes|nullable',
        ]);

        try {

            if($request['name']) {
                $user = User::create([
                    'email' => $request['email'],
                    'password' => app('hash')->make($request['password']),
                    'role' => User::ROLE_CLIENT,
                ]);

                $user->clientProfile()->create([
                    'name' => $request['name'],
                    'surname' => $request['surname'],
                    'birthday' => $request['birthday'],
                    'phone' => $request['phone'],
                    'address' => $request['address'],
                    'country' => $request['country'],
                ]);
            } else {
                $user = User::create([
                    'email' => $request['email'],
                    'password' => app('hash')->make($request['password']),
                    'role' => User::ROLE_USER,
                ]);
            }

            return response()->json(compact('user'), 201);
        }
        catch(\Exception $e) {
            $userRole = $request['name'] ? 'Client' : 'User';

            return response()->json(['message' => $userRole . ' registration Failed!' . $e->getMessage()], 409);
        }
    }

    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
    }
}