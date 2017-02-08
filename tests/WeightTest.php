<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WeightTest extends TestCase
{
    /** @test */
    public function testItShouldReturnAllWeights()
    {
        $this->get('/weights')
             ->seeJson([
                'weight' => 175,
                'date' => '1/30/2017'
             ]);
    }
}
