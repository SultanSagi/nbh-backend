<?php

namespace tests\Client;

use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnauthorized()
    {
        $this->json('get', 'api/client/dashboard')
            ->assertResponseStatus(401);
    }

    public function testDashboard()
    {
        $user = factory('App\User')->state('client')->create();

        $this->actingAs($user);

        $this->json('get', 'api/client/dashboard')
            ->seeJson(['email' => $user->email])
            ->assertResponseStatus(200);

    }
}