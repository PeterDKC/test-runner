<?php

namespace SampleTests;

use PHPUnit\Framework\TestCase;

class SecondTest extends TestCase
{
    /** @test */
    public function thisIsAlsoATest()
    {
        $this->assertEquals(
            [1, 2, 3],
            range(1, 3)
        );
    }
}
