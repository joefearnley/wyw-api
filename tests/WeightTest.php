<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WeightTest extends TestCase
{
    public function testItShouldReturnAllWeights()
    {
        $this->get('/weights')
             ->seeJson([
                'weight' => 175,
                'date' => '1/30/2017'
             ])
            ->seeJson([
                'weight' => 170,
                'date' => '2/30/2017'
             ])
            ->seeJson([
                'weight' => 165,
                'date' => '3/30/2017'
             ]);
    }
}
