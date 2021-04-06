<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function expectsUnicode(string $withUnicode, string $withoutUnicode): string
    {
        return '\\' === DIRECTORY_SEPARATOR
            ? $withoutUnicode
            : $withUnicode;
    }
}
