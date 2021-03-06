<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\User;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_return_a_422_when_no_data_is_provided()
    {
        $this->post('/api/register')
            ->seeStatusCode(422)
            ->seeJsonContains(['The name field is required.'])
            ->seeJsonContains(['The email field is required.'])
            ->seeJsonContains(['The password field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_name_is_provided()
    {
        $data = [
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/register', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The name field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_invalid_email_is_provided()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doesafdasfd',
            'password' => str_random(10)
        ];

        $this->post('/api/register', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email must be a valid email address.']);
    }

    /** @test */
    public function it_should_return_a_422_when_non_unique_email_is_provided()
    {
        factory(App\User::class)->create([
            'email' => 'john.doe@gmail.com'
        ]);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/register', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email has already been taken.']);
    }

    /** @test */
    public function it_should_return_a_422_when_password_less_than_six_characters_is_provided()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => str_random(3)
        ];

        $this->post('/api/register', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The password must be at least 6 characters.']);
    }

    /** @test */
    public function it_should_register_a_user_and_return_a_token()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/register', $data)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Signup complete.'
            ]);

        $response = $this->response->getData(true);

        $user = User::first();

        $this->assertEquals($user->api_token, $response['token']);
    }
}
