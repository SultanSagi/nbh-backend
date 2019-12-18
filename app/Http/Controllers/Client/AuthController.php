<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Client;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'surname' => 'required|string',
            'birthday' => 'required|date',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
            'country' => 'nullable',
        ]);

        try {
            $client = Client::create([
                'name' => $request['name'],
                'surname' => $request['surname'],
                'birthday' => $request['birthday'],
                'email' => $request['email'],
                'password' => app('hash')->make($request['password']),
                'phone' => $request['phone'],
                'address' => $request['address'],
                'country' => $request['country'],
            ]);

            return response()->json(compact('client'), 201);
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Client registration Failed!' . $e->getMessage()], 409);
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
}