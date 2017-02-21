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

    /** @test */
    public function it_should_return_all_weights_for_user()
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

    /** @test */
    public function it_should_return_a_422_when_no_data_is_provided()
    {
        $data = [];
        $this->post('/api/weights', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.'])
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weight_is_provided()
    {
        $data = ['weigh_in_date' => '4/30/2017'];
        $this->post('/api/weights', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_invalid_weight_is_provided()
    {
        $data = [
            'weight' => 'safdasfds', 
            'weigh_in_date' => '4/30/2017'
        ];

        $this->post('/api/weights', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight must be a number.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weigh_in_date_is_provided()
    {
        $data = ['weight' => 160];
        $this->post('/api/weights', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_invalid_weigh_in_date_is_provided()
    {
        $data = [
            'weight' => 160, 
            'weigh_in_date' => 'sadfljslkfj'
        ];

        $this->post('/api/weights', $data)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weigh in date is not a valid date.']);
    }

    /** @test */
    public function it_should_add_weight_for_user()
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

    /** @test */
    public function it_should_return_a_405_when_no_id_is_provided_for_delete($value='')
    {
        $this->delete('/api/weights')
            ->seeStatusCode(405);
    }

    /** @test */
    public function it_should_delete_a_weight_record_for_user()
    {
        $initalWeightCount = $this->user->weights->count();

        $weight = $this->user->weights()->create([
            'weight' => 175,
            'weigh_in_date' => '1/30/2017',
            'user_id' => $this->user->id
        ]);

        $this->user = $this->user->fresh();

        $this->assertEquals($initalWeightCount + 1, $this->user->weights->count());

        $this->delete('api/weights/' . $weight->id)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'Weight deleted.'
            ]);

        $this->assertEquals($this->user->fresh()->weights->count(), $initalWeightCount);
    }

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
