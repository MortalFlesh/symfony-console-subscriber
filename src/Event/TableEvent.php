<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TableEvent extends Event
{
    public function __construct(private array $headers, private array $rows)
    {
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
