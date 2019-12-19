<?php

namespace tests\User;

use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnauthorized()
    {
        $this->json('get', 'api/user/dashboard')
            ->assertResponseStatus(401);
    }

    /**
     * User can see the list of all clients
     *
     * @return void
     */
    public function testClientList()
    {
        $user = factory('App\User')->state('user')->create();

        $client = factory('App\User')->state('client')->create();

        $this->actingAs($user);

        $this->json('get', 'api/user/dashboard')
            ->seeJson(['email' => $client->email])
            ->assertResponseStatus(200);

    }

    /**
     * User can see only the list of clients
     *
     * @return void
     */
    public function testClientOnlyList()
    {
        $user = factory('App\User')->state('user')->create();

        $anotherUser = factory('App\User')->state('user')->create();

        $this->actingAs($user);

        $this->json('get', 'api/user/dashboard')
            ->dontSeeJson(['email' => $anotherUser->email])
            ->assertResponseStatus(200);

        $this->json('get', 'api/user/clients/' . $anotherUser->id)
            ->assertResponseStatus(403);
    }

    /**
     * User can see all the detail about the client
     *
     * @return void
     */
    public function testClientDetail()
    {
        $user = factory('App\User')->state('user')->create();

        $client = factory('App\User')->state('client')->create();

        factory('App\ClientProfile')->create(['user_id' => $client]);

        $this->actingAs($user);

        $this->json('get', 'api/user/clients/' . $client->id)
            ->seeJson([
                'email' => $client->email,
                'birthday' => $client->clientProfile->birthday
            ])
            ->assertResponseStatus(200);

    }

    /**
     * User can edit data of client
     *
     * @return void
     */
    public function testClientEdit()
    {
        $user = factory('App\User')->state('user')->create();

        $client = factory('App\User')->state('client')->create();

        factory('App\ClientProfile')->create(['user_id' => $client]);

        $this->actingAs($user);

        $attr = [
            'email' => 'changed@gmail.com',
            'name' => 'Changed name',
            'surname' => 'Changed surname',
            'birthday' => '1983-05-02',
            'phone' => '1234231900',
            'address' => 'Changed address',
            'country' => 'Changed',
        ];

        $this->json('patch', 'api/user/clients/' . $client->id . '/edit', $attr);

        tap($client->fresh(), function ($client) use ($attr) {
            $this->assertEquals($attr['email'], $client->email);
            $this->assertEquals($attr['name'], $client->clientProfile->name);
            $this->assertEquals($attr['surname'], $client->clientProfile->surname);
            $this->assertEquals($attr['birthday'], $client->clientProfile->birthday);
            $this->assertEquals($attr['phone'], $client->clientProfile->phone);
            $this->assertEquals($attr['address'], $client->clientProfile->address);
            $this->assertEquals($attr['country'], $client->clientProfile->country);
        });
    }
}