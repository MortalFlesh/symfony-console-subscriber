<?php

namespace MF\ConsoleSubscriber\Event;

use Symfony\Component\EventDispatcher\Event;

class TableEvent extends Event
{
    /** @var array */
    private $headers;

    /** @var array */
    private $rows;

    public function __construct(array $headers, array $rows)
    {
        $this->headers = $headers;
        $this->rows = $rows;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
