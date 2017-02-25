<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthenticateTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * User used for tests
     * 
     * @var App\User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create([
            'email' => 'john.doe@gmail.com',
            'password' => Hash::make('secret')
        ]);
    }

    /** @test */
    public function it_should_return_a_422_when_no_data_is_provided()
    {
        $this->post('/api/authenticate')
            ->seeStatusCode(422)
            ->seeJsonContains(['The email field is required.'])
            ->seeJsonContains(['The password field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_email_is_provided()
    {
        $data = [
            'email' => '',
            'password' => $this->user->password
        ];

        $this->post('/api/authenticate', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The email field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_password_is_provided()
    {
        $data = [
            'email' => $this->user->email,
            'password' => ''
        ];

        $this->post('/api/authenticate', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The password field is required.']);
    }

    /** @test */
    public function it_should_return_a_401_email_and_password_do_not_authenticate()
    {
        $data = [
            'email' => $this->user->email,
            'password' => '1234567'
        ];

        $this->post('/api/authenticate', $data)
            ->seeStatusCode(401)
            ->seeJsonContains(['Credentials do not match our records.']);
    }

    /** @test */
    public function it_should_login_a_user_and_return_a_token()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'secret'
        ];

        $this->post('/api/authenticate', $data)
            ->seeStatusCode(200);

        $response = $this->response->getData(true);

        $user = User::first();

        $this->assertEquals($user->api_token, $response['token']);
    }

}