<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function show()
    {
        $user = User
            ::with('clientProfile')
            ->find(Auth::id());
        
        return response()->json(['user' => $user], 200);
    }
}