<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show()
    {
        if(!Auth::user()->isClient()) {
            return response()->json(['message' => 'You don\'t have permisson to access this server'], 403);
        }

        $user = User
            ::with('clientProfile')
            ->find(Auth::id());
        
        return response()->json(['user' => $user], 200);
    }
}