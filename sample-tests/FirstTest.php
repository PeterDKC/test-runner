<?php

namespace SampleTests;

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /** @test */
    public function myFirstTest()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function mySecondTest()
    {
        $this->assertFalse(false);
    }
}
