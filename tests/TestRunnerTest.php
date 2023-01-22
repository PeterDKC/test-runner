<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PeterDKC\TestRunner;
use Composer\Script\Event;

class TestRunnerTest extends TestCase
{
    /** @test */
    public function testsCanRun()
    {
        $output = `composer test testdox`;

        $this->assertStringContainsString(
            'My first test',
            $output
        );

        $this->assertStringContainsString(
            'My second test',
            $output
        );

        $this->assertStringContainsString(
            'This is also a test',
            $output
        );
    }

    /** @test */
    public function testsCanBeFiltered()
    {
        $output = `composer filter myFirstTest testdox`;

        $this->assertStringContainsString(
            'My first test',
            $output
        );

        $this->assertStringNotContainsString(
            'My second test',
            $output
        );

        $this->assertStringNotContainsString(
            'This is also a test',
            $output
        );
    }

    /** @test */
    public function testsCanBeRepeated()
    {
        $output = `composer repeat 3 thisIsAlsoATest testdox`;

        $lines = explode("\n", $output);

        for ($i = 3; $i < 6; $i++) {
            $this->assertEquals(
                "This is also a test",
                substr($lines[$i], 14)
            );
        }

        $this->assertStringNotContainsString(
            'My first test',
            $output
        );

        $this->assertStringNotContainsString(
            'My second test',
            $output
        );
    }

    /** @test */
    public function textCoverageCanBeGenerated()
    {
        $output = `composer coverage-text`;

        $this->assertStringContainsString(
            'OK (3 tests, 3 assertions)',
            $output
        );

        $this->assertStringContainsString(
            'Code Coverage Report:',
            $output
        );
    }

    /** @test */
    public function cloverCoverageCanBeGenerated()
    {
        `composer coverage-clover`;
        $output = `cat coverage.xml`;
        unlink('coverage.xml');

        $this->assertStringContainsString(
            '<file name="/Users/peterdemarco/code/packages/test-runner/src/TestRunner.php">',
            $output
        );

        $this->assertStringContainsString(
            '<line num="27" type="method" name="coverageClover" visibility="public" complexity="1" crap="2" count="0"/>',
            $output
        );
    }

    /** @test */
    public function fullCoverageCanBeGenerated()
    {
        `composer coverage-full`;
        $output = `cat coverage/index.html`;
        `rm -rf coverage`;

        $this->assertStringContainsString(
            '<title>Code Coverage for',
            $output
        );

        $this->assertStringContainsString(
            '<td colspan="9"><div align="center"><strong>Code Coverage</strong></div></td>',
            $output
        );
    }

    /** @test */
    public function fullCoverageCanBeFiltered()
    {
        /**
         * Unfortunately we can only test execution here
         * Since we're not actually running coverage
         * Against what the tests are executing
         */
        `composer filter-coverage mySecondTest`;
        $output = `cat coverage/TestRunner.php.html`;
        `rm -rf coverage`;

        $this->assertStringContainsString(
            '<td colspan="3"><div align="center"><strong>Lines</strong></div></td>',
            $output
        );

        $this->assertStringContainsString(
            '<td class="danger"><abbr title="PeterDKC\TestRunner">TestRunner</abbr></td>',
            $output
        );
    }
}