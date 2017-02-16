<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WeightTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp()
    {
        parent::setUp();
        
        $this->setUpData();
    }

    public function test_it_should_return_a_401_when_not_authorized()
    {
        $this->get('/api/weights');

        $this->assertEquals(401, $this->response->status());
        $this->assertEquals('Unauthorized.', $this->response->getContent());
    }

    public function test_it_should_return_all_weights_for_user()
    {
        $headers = ['Authorization' => 'Bearer ' . $this->user->api_token];

        $this->get('/api/weights', $headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'weight' => 175,
                'weigh_in_date' => '1/30/2017'
             ]);
    }

    public function test_it_should_add_weight()
    {
        $data = [
            'weight' => 175,
            'weigh_in_date' => '04-30-2017',
            'user_id' => $this->user->id
        ];

        $this->post('/api/weight/add', $data)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'weight' => 175,
                'weigh_in_date' => '4/30/2017',
                'user_id' => $this->user->id
            ]);
    }

    protected function setUpData()
    {
        $this->user = factory(App\User::class)->make();

        $weight1 = factory(App\Weight::class)->make([
            'weight' => 175,
            'weigh_in_date' => '1/30/2017',
            'user_id' => $this->user->id
        ]);

        $weight2 = factory(App\Weight::class)->make([
            'weight' => 170,
            'weight_in_date' => '2/30/2017',
            'user_id' => $this->user->id
        ]);

        $weight3 = factory(App\Weight::class)->make([
            'weight' => 165,
            'weight_in_date' => '3/30/2017',
            'user_id' => $this->user->id
        ]);
    }
}
