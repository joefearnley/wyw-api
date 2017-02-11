<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WeightTest extends TestCase
{
    use DatabaseMigrations;

    public function testItShouldReturnAllWeights()
    {
        $weight1 = factory(App\Weight::class)->make([
            'weight' => 175,
            'weigh_in_date' => '1/30/2017'
        ]);

        $weight2 = factory(App\Weight::class)->make([
            'weight' => 170,
            'weight_in_date' => '1/30/2017'
        ]);
        $weight3 = factory(App\Weight::class)->make([
            'weight' => 165,
            'weight_in_date' => '1/30/2017'
        ]);

        $this->get('/weights')
             ->seeJson([
                'weight' => 175,
                'weigh_in_date' => '1/30/2017'
             ]);
    }
}
