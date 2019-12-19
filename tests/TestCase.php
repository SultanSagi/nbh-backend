<?php

use \Tymon\JWTAuth\Contracts\JWTSubject;
use \Illuminate\Support\Facades\Auth;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function jsonAs(JWTSubject $user, $method, $endpoint, $data = [], $headers = [])
    {
        $token = Auth::tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token,
        ]));
    }
}
