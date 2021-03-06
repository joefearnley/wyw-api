<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class WeightTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * User used for tests
     * 
     * @var App\User
     */
    private $user;

    /**
     * Headers sent to api for authorization.
     * 
     * @var array
     */
    private $headers = [];

    /**
     * Set up the data for the tests.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->setUpData();

        $this->headers = ['Authorization' => 'Bearer ' . $this->user->api_token];
    }

    /** @test */
    public function it_should_return_all_weights_for_user()
    {
        $this->get('/api/weights', $this->headers)
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
    public function it_should_return_a_401_for_all_weights_with_incorrect_auth_header()
    {
        $this->get('/api/weights', ['Authorization' => 'Bearer 1234566'])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_401_for_all_weights_with_no_auth_header()
    {
        $this->get('/api/weights')
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_find_a_weight()
    {
        $weight = $this->user->weights->first();

        $this->get('/api/weights/' . $weight->id, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'weight' => '175',
                'weigh_in_date' => '1/30/2017'
             ]);
    }

    /** @test */
    public function it_should_return_a_401_reading_weight_with_incorrect_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->get('/api/weights/' . $weight->id, ['Authorization' => 'Bearer 1234566'])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_401_reading_weight_with_no_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->get('/api/weights/' . $weight->id)
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_422_creating_weight_when_no_data_is_provided()
    {
        $data = [];
        $this->post('/api/weights', $data, $this->headers)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.'])
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weight_is_provided()
    {
        $data = ['weigh_in_date' => '4/30/2017'];
        $this->post('/api/weights', $data, $this->headers)
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

        $this->post('/api/weights', $data, $this->headers)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight must be a number.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weigh_in_date_is_provided()
    {
        $data = ['weight' => 160];
        $this->post('/api/weights', $data, $this->headers)
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

        $this->post('/api/weights', $data, $this->headers)
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

        $this->post('/api/weights', $data, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Weight created.'
            ])            
            ->seeJsonContains([
                'weight' => 160,
                'weigh_in_date' => '4/30/2017',
                'user_id' => $this->user->id
            ]);
    }

    /** @test */
    public function it_should_return_a_401_when_creating_weights_with_incorrect_auth_header()
    {
        $this->post('/api/weights', [], ['Authorization' => 'Bearer 1234566'])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_401_when_creating_weights_with_no_auth_header()
    {
        $this->post('/api/weights', [], [])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_405_when_no_id_is_provided_for_delete()
    {
        $this->delete('/api/weights', $this->headers)
            ->seeStatusCode(405);
    }

    /** @test */
    public function it_should_delete_a_weight_record_for_user()
    {
        $initalWeightCount = $this->user->weights->count();

        $weight = $this->user->weights()->create([
            'weight' => 175,
            'weigh_in_date' => '1/30/2017'
        ]);

        $updatedUser = $this->user->fresh();

        $this->assertEquals($initalWeightCount + 1, $updatedUser->weights->count());
        
        $data = [];
        $this->delete('api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Weight deleted.'
            ]);

        $this->assertEquals($updatedUser->fresh()->weights->count(), $initalWeightCount);
    }

    /** @test */
    public function it_should_return_a_401_when_deleting_weights_with_incorrect_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->delete('api/weights/' . $weight->id, [], ['Authorization' => 'Bearer 1234566'])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_401_when_deleting_weights_with_no_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->delete('api/weights/' . $weight->id, [], [])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_405_when_no_id_is_provided_for_update()
    {
        $this->put('api/weights')
            ->seeStatusCode(405);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weight_is_provided_for_update()
    {
        $weight = $this->user->weights->first();
        $data = ['weigh_in_date' => '4/30/2017'];
        $this->put('/api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weight field is required.']);
    }

    /** @test */
    public function it_should_return_a_422_when_no_weigh_in_date_is_provided_for_update()
    {
        $weight = $this->user->weights->first();
        $data = ['weight' => '170'];
        $this->put('/api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(422)
            ->seeJsonContains(['The weigh in date field is required.']);
    }

    /** @test */
    public function it_should_update_weights_weight()
    {
        $weight = $this->user->weights->first();

        $newWeight = $weight->weight - 5;

        $data = [
            'weight' => $newWeight,
            'weigh_in_date' => $weight->weigh_in_date
        ];

        $this->put('api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Weight updated.'
            ])
            ->seeJsonContains([
                'weight' => $newWeight,
                'weigh_in_date' => $weight->weigh_in_date,
                'user_id' => (string) $this->user->id
            ]);

        $updatedWeight = $this->user->fresh()->weights->first();

        $this->assertEquals($updatedWeight->weight, $newWeight);
    }

    /** @test */
    public function it_should_update_weights_weigh_in_date()
    {
        $weight = $this->user->weights->first();

        $newDate = '1/27/2017';

        $data = [
            'weight' => $weight->weight,
            'weigh_in_date' => $newDate
        ];

        $this->put('api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Weight updated.'
            ])
            ->seeJsonContains([
                'weight' => $weight->weight,
                'weigh_in_date' => $newDate,
                'user_id' => (string) $this->user->id
            ]);

        $updatedWeight = $this->user->fresh()->weights->first();

        $this->assertEquals($updatedWeight->weigh_in_date, $newDate);
    }

    /** @test */
    public function it_should_update_weights_weight_and_weigh_in_date()
    {
        $weight = $this->user->weights->first();

        $newWeight = $weight->weight - 5;
        $newDate = '1/27/2017';

        $data = [
            'weight' => $newWeight,
            'weigh_in_date' => $newDate
        ];

        $this->put('api/weights/' . $weight->id, $data, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                'message' => 'Weight updated.'
            ])
            ->seeJsonContains([
                'weight' => $newWeight,
                'weigh_in_date' => $newDate,
                'user_id' => (string) $this->user->id
            ]);

        $updatedWeight = $this->user->fresh()->weights->first();

        $this->assertEquals($updatedWeight->weight, $newWeight);
        $this->assertEquals($updatedWeight->weigh_in_date, $newDate);
    }

    /** @test */
    public function it_should_return_a_401_for_updating_weights_with_incorrect_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->put('api/weights/' . $weight->id, [], ['Authorization' => 'Bearer 1234566'])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /** @test */
    public function it_should_return_a_401_for_updating_weights_with_no_auth_header()
    {
        $weight = $this->user->weights->first();
        $this->put('api/weights/' . $weight->id, [], [])
            ->seeStatusCode(401)
            ->assertEquals('Unauthorized.', $this->response->getContent());
    }

    /**
     * Set up the data for the initial tests for the Weight modal. 
     * Create a user and 3 weights for that user. 
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
