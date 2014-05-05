<?php

namespace WordSoapServerTest\Service;

use WordSoapServer\Service\WordService;

class WordServiceTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * Flip most frequently used words
     */
    public function testWordFlip()
    {
        $service = new WordService();

        $this->assertEquals('olleH', $service->wordFlip('Hello'));
    }

    /**
     * What happed then flipping empty text
     */
    public function testWordFlipEmptyString()
    {
        $service = new WordService();

        $this->assertEquals('', $service->wordFlip(''));
    }

    /**
     * Generate random word and try to flip it
     */
    public function testWordFlipRandomWord()
    {
        $service = new WordService();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = $stringFlipped = '';
        for ($i = 0; $i < 10; $i++) {
            $char = $characters[rand(0, strlen($characters)-1)];
            $string = $string.$char;
            $stringFlipped = $char.$stringFlipped;
        }

        $this->assertEquals($stringFlipped, $service->wordFlip($string));
    }

    /**
     * Flipping too long word should throw validation exception
     */
    public function testWordFlipTooLongThrowsException()
    {
        $service = new WordService();

        $string = str_repeat(' ', 64);
        $this->assertEquals($string, $service->wordFlip($string));

        $this->setExpectedException('InvalidArgumentException');
        $this->assertEquals('', $service->wordFlip(str_repeat('a', 65)));
    }
}
