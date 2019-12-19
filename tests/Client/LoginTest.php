<?php

namespace tests\Client;

use TestCase;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function testRequireEmail()
    {
        $this->json('post', 'api/user/login')
            ->assertResponseStatus(422);
    }

    public function testRequirePassword()
    {
        $this->json('post', 'api/user/login')
            ->assertResponseStatus(422);
    }

    public function testWrongCredentials()
    {
        $user = factory('App\User')->create();

        $attr = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        $this->json('post', 'api/user/login', $attr)
            ->assertResponseStatus(401);
    }

    public function testSuccessfulLogin()
    {
        $user = factory('App\User')->create();

        $attr = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $this->json('post', 'api/user/login', $attr)
            ->assertResponseStatus(200);
    }
}