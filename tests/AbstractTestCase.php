<?php

namespace MF\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function expectsUnicode(string $withUnicode, string $withoutUnicode): string
    {
        return '\\' === DIRECTORY_SEPARATOR
            ? $withoutUnicode
            : $withUnicode;
    }

    protected function tearDown()
    {
        m::close();
    }
}
