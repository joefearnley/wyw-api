<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class SignupTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_signup_a_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/signup', $data)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Signup complete.'
            ]);

        $repsonse = json_decode($this->response->getContent(), true);

        $user = User::first();

        $this->assertEquals($user->api_token, $repsonse['token']);
    }
}