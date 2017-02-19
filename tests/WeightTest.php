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

    public function test_it_should_return_all_weights_for_user()
    {
        $headers = ['Authorization' => 'Bearer ' . $this->user->api_token];
        $this->get('/api/weights', $headers)
            ->seeStatusCode(200)          
            ->seeJsonContains([
                'weight' => '175',
                'weigh_in_date' => '1/30/2017'
             ])
            ->seeJsonContains([
                'weight' => '170',
                'weigh_in_date' => '2/25/2017'
             ])
            ->seeJsonContains([
                'weight' => '165',
                'weigh_in_date' => '3/30/2017'
             ]);
    }

    public function test_it_should_return_a_422_when_no_data_is_provided()
    {
        $this->post('/api/weights', [])
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.'])
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    public function test_it_should_return_a_422_when_no_weight_is_provided()
    {
        $this->post('/api/weights', ['weigh_in_date' => '4/30/2017'])
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.']);
    }

    public function test_it_should_return_a_422_when_invalid_weight_is_provided()
    {
        $postData = [
            'weight' => 'safdasfds', 
            'weigh_in_date' => '4/30/2017'
        ];

        $this->post('/api/weights', $postData)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight must be a number.']);
    }

    public function test_it_should_return_a_422_when_no_weigh_in_date_is_provided()
    {
        $this->post('/api/weights', ['weight' => 160])
            ->seeStatusCode(422)
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    public function test_it_should_return_a_422_when_invalid_weigh_in_date_is_provided()
    {
        $postData = [
            'weight' => 160, 
            'weigh_in_date' => 'sadfljslkfj'
        ];

        $this->post('/api/weights', $postData)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weigh in date is not a valid date.']);
    }

    public function test_it_should_add_weight_for_user()
    {
        $data = [
            'weight' => 160,
            'weigh_in_date' => '4/30/2017'
        ];

        $this->post('/api/weights', $data)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'weight' => 160,
                'weigh_in_date' => '4/30/2017',
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Set up data for test. Add a user and 3 weight records for that user.
     */
    protected function setUpData()
    {
        $this->user = factory(App\User::class)->create();

        $weight1 = factory(App\Weight::class)->create([
            'weight' => 175,
            'weigh_in_date' => '1/30/2017',
            'user_id' => $this->user->id
        ]);

        $weight2 = factory(App\Weight::class)->create([
            'weight' => 170,
            'weigh_in_date' => '2/25/2017',
            'user_id' => $this->user->id
        ]);

        $weight3 = factory(App\Weight::class)->create([
            'weight' => 165,
            'weigh_in_date' => '3/30/2017',
            'user_id' => $this->user->id
        ]);
    }
}
