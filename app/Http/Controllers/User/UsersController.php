<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{   
    public function index()
    {
       if(!Auth::user()->isUser()) {
           return response()->json(['message' => 'You don\'t have permisson to access this server'], 403);
       }

        $clients = User::with('clientProfile')->client()->get();
        
        return response()->json(['clients' => $clients], 200);
    }

    public function show($id)
    {
        $client = User::findOrFail($id);
        
        if(!$client->isClient()) {
            return response()->json(['message' => 'You don\'t have permisson to access this server'], 403);
        }

        $client = User::with('clientProfile')->find($client->id);
        
        return response()->json(['client' => $client], 200);
    }

    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);

        $this->validate($request, [
            'email' => 'required|email|unique:users,id,' . $client->id,
            'name' => 'required|string',
            'surname' => 'required|string',
            'birthday' => 'required|date',
            'phone' => 'nullable',
            'address' => 'nullable',
            'country' => 'nullable',
        ]);
        
        if(!$client->isClient()) {
            return response()->json(['message' => 'You don\'t have permisson to access this server'], 403);
        }

        $client->update([
            'email' => $request['email'],
        ]);

        $client->clientProfile->update([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'birthday' => $request['birthday'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'country' => $request['country'],
        ]);

        $client = User::with('clientProfile')->find($client->id);

        return response()->json(['client' => $client], 200);
    }
}