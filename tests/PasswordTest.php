<?php

use Dakzilla\Strongpass\Strongpass;
use Tests\TestCase;

class PasswordTest extends TestCase
{

    /** @var Strongpass */
    protected $strongpass;

    public function setUp()
    {
        $this->strongpass = new Strongpass([
            'length' => 16,
            'use_letters' => true,
            'use_numbers' => true,
            'use_symbols' => true
        ]);
        parent::setUp();
    }

    public function testString()
    {
        $isString = is_string($this->strongpass->generate());
        $this->assertTrue($isString);
    }

    public function testLength()
    {
        $length = random_int(6, 32);
        $this->strongpass->setLength($length);
        $this->assertEquals($length, strlen($this->strongpass->generate()));
    }

    public function testNoNumbers()
    {
        $this->strongpass->setUseNumbers(false);
        $this->assertNotRegExp('/[0-9]/', $this->strongpass->generate());
    }

    public function testNoLetters()
    {
        $this->strongpass->setUseLetters(false);
        $this->assertNotRegExp('/[a-zA-Z]/', $this->strongpass->generate());
    }

    public function testNoSymbols()
    {
        $this->strongpass->setUseSymbols(false);
        $this->assertNotRegExp('/[{}\[\]()\/\'"`~,;:.<>]/', $this->strongpass->generate());
    }

    public function testWrongConfig()
    {
        $this->strongpass
            ->setUseLetters(false)
            ->setUseNumbers(false)
            ->setUseSymbols(false);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/No character set was selected/');

        $this->strongpass->generate();
    }
}
