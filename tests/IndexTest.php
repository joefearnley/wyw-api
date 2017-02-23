<?php

class IndexTest extends TestCase
{
    /** @test */
    public function it_should_return_the_correct_response()
    {
        $this->get('/');

        $this->assertEquals('Nothing to see here.', $this->response->getContent());
    }
}
