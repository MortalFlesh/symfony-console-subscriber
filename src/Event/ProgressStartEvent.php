<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ProgressStartEvent extends Event
{
    private int $count;

    public function __construct(int|\Countable|array $count)
    {
        $this->count = is_int($count) ? $count : count($count);
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
