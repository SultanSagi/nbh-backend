<?php

namespace tests\User;

use Testcase;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    public function testRequireEmail()
    {
        $this->json('post', 'api/user/register')
            ->assertResponseStatus(422);
    }

    public function testRequireValidEmail()
    {
        $this->json('post', 'api/user/register', [
            'email' => 'nope'
        ])
            ->assertResponseStatus(422);
    }

    public function testRequireUniqueEmail()
    {
        $user = factory('App\User')->create();

        $this->json('post', 'api/user/register', [
            'email' => $user->email,
            'password' => 'pass'
        ])
            ->assertResponseStatus(422);
    }

    public function testRequirePassword()
    {
        $this->json('post', 'api/user/register')
            ->assertResponseStatus(422);
    }

    public function testRegisterUser()
    {
        $attr = [
            'email' => 'some-email@go.co',
            'password' => 'password',
        ];

        $this->json('post', 'api/user/register', $attr)
            ->assertResponseStatus(201);

        $user = User::first();

        $this->assertCount(1, User::get());

        $this->assertEquals($attr['email'], $user->email);
        $this->assertTrue($user->isUser());
    }
}