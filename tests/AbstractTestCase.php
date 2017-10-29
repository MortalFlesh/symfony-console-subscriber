<?php

namespace MF\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function tearDown()
    {
        m::close();
    }
}
