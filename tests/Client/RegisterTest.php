<?php

namespace tests\Client;

use TestCase;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    public function testRequireName()
    {
        $this->json('post', 'api/user/register')
            ->assertResponseStatus(422);
    }

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

    public function testRegisterClient()
    {
        $attr = [
            'name' => 'John',
            'surname' => 'Doe',
            'birthday' => '1992-07-22',
            'email' => 'some-email@go.co',
            'phone' => '14055003015',
            'address' => 'Random address',
            'country' => 'Random country',
            'password' => 'password',
        ];

        $this->json('post', 'api/user/register', $attr)
            ->assertResponseStatus(201);

        $client = User::first();

        $this->assertCount(1, User::get());

        $this->assertTrue($client->isClient());
        $this->assertEquals($attr['name'], $client->clientProfile->name);
        $this->assertEquals($attr['surname'], $client->clientProfile->surname);
        $this->assertEquals($attr['birthday'], $client->clientProfile->birthday);
        $this->assertEquals($attr['email'], $client->email);
        $this->assertEquals($attr['phone'], $client->clientProfile->phone);
        $this->assertEquals($attr['address'], $client->clientProfile->address);
        $this->assertEquals($attr['country'], $client->clientProfile->country);
    }
}