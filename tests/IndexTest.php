<?php

class IndexTest extends TestCase
{
    public function testItShouldReturnCorrectText()
    {
        $this->get('/');

        $this->assertEquals('Nothing to see here.', $this->response->getContent());
    }
}
