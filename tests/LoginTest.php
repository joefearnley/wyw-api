<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\User;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create([
            'email' => 'john.doe@gmail.com'
        ]);
    }

    /** @test */
    public function it_should_return_a_422_when_no_data_is_provided()
    {
        $this->post('/api/login')
            ->seeStatusCode(422)
            ->seeJsonContains(['The email field is required.'])
            ->seeJsonContains(['The password field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_email_is_provided()
    {
        $data = [
            'email' => '',
            'password' => str_random(10)
        ];

        $this->post('/api/login', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_password_is_provided()
    {
        $data = [
            'email' => 'john.doesafdasfd',
            'password' => ''
        ];

        $this->post('/api/login', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email must be a valid email address.']);
    }

    /** @test */
    public function it_should_return_a_422_email_and_password_do_not_authenticate()
    {
        $data = [
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/signup', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email has already been taken.']);
    }

    /** @test */
    public function it_should_login_a_user_and_return_a_token()
    {
        $data = [
            'email' => 'john.doe@gmail.com',
            'password' => str_random(10)
        ];

        $this->post('/api/signup', $data)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Signup complete.'
            ]);

        $response = $this->response->getData(true);

        $user = User::first();

        $this->assertEquals($user->api_token, $response['token']);
    }

}