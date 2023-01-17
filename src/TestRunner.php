<?php

namespace PeterDKC;

use Composer\Script\Event;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TestRunner
{
    protected static $defaultDescription = 'Filter tests to the given string. Usage: composer tf somethingToFilterOn';

    public static function coverageClover(Event $event): void
    {
        static::run([
            "vendor/bin/phpunit",
            "-dmemory_limit=-1",
            "--colors=always",
            "-dpcov.directory=./",
            "--coverage-clover=coverage.xml",
        ]);
    }

    public static function coverageFull(Event $event): void
    {
        static::run([
            "vendor/bin/phpunit",
            "-dmemory_limit=-1",
            "--colors=always",
            "-dpcov.directory=./",
            "--coverage-html",
            "coverage",
        ]);

        static::run([
            "open",
            "coverage/index.html",
        ]);
    }

    public static function filterCoverage(Event $event): void
    {
        $filter = static::extract($event, 0, 'You must supply a string to filter tests on');

        static::run([
            "vendor/bin/phpunit",
            "-dmemory_limit=-1",
            "--colors=always",
            "-dpcov.directory=./",
            "--filter",
            $filter,
            "--coverage-html",
            "coverage",
        ]);

        static::run([
            "open",
            "coverage/index.html",
        ]);
    }

    public static function coverageText(Event $event): void
    {
        static::run([
            "vendor/bin/phpunit",
            "-dmemory_limit=-1",
            "-dpcov.directory=./",
            "--coverage-text",
            "--colors=never",
        ]);
    }

    public static function test(Event $event): void
    {
        static::run([
            "vendor/bin/phpunit",
            "--colors=always",
            "-dmemory_limit=-1",
        ]);
    }

    public static function filterTests(Event $event): void
    {   
        $filter = static::extract($event, 0, 'You must supply a string to filter tests on');

        static::run([
            "vendor/bin/phpunit",
            "--colors=always",
            "--filter",
            $filter,
        ]);
    }

    public static function repeatTest(Event $event): void
    {   
        $times = $event->getArguments()[0] ?? '';
        $filter = $event->getArguments()[1] ?? '';

        if (empty($times)) {
            throw new Exception('You must supply a number of times to run the filtered tests');
        }

        if (empty($filter)) {
            throw new Exception('You must supply a string to filter tests on');
        }

        static::run([
            "vendor/bin/phpunit",
            "--colors=always",
            "--repeat",
            $times,
            "--filter",
            $filter,
        ]);
    }

    protected static function extract(Event $event, int $index, string $description): mixed
    {
        $argument = $event->getArguments()[0] ?? null;

        if (is_null($argument)) {
            throw new Exception('You must supply a string to filter tests on');
        }

        return $argument;
    }

    protected static function run(array $arguments): void
    {
        $process = new Process($arguments);

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
