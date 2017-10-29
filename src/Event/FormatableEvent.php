<?php

namespace MF\ConsoleSubscriber\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class FormatableEvent extends Event
{
    /** @var array */
    private $args = [];

    protected function setArgs(array $args)
    {
        $this->args = $args;
    }

    protected function format(string $string): string
    {
        return sprintf($string, ...$this->args);
    }
}
