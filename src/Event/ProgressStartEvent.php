<?php

namespace MF\ConsoleSubscriber\Event;

use Symfony\Component\EventDispatcher\Event;

class ProgressStartEvent extends Event
{
    /** @var int */
    private $count;

    /**
     * @param int|\Countable $count
     */
    public function __construct($count)
    {
        $this->count = is_int($count) ? $count : count($count);
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
