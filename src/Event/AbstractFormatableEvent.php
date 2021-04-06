<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractFormatableEvent extends Event
{
    private array $args = [];

    protected function setArgs(array $args): void
    {
        $this->args = $args;
    }

    protected function format(string $string): string
    {
        return sprintf($string, ...$this->args);
    }
}
