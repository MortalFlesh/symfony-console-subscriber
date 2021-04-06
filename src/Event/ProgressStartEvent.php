<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ProgressStartEvent extends Event
{
    private int $count;

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
