<?php

namespace WordSoapServerTest\Service;

use WordSoapServer\Service\WordService;

class WordServiceTest
    extends \PHPUnit_Framework_TestCase
{

    public function testWordFlip()
    {
        $service = new WordService();

        $this->assertEquals('olleH', $service->wordFlip('Hello'));
    }
}
