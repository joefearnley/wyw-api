<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class IndexTest extends TestCase
{
    public function testItShouldReturnCorrectText()
    {
        $this->get('/');

        $this->assertEquals('Nothing to see here.', $this->response->getContent());
    }
}
