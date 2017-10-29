<?php

namespace MF\ConsoleSubscriber\Event;

class ProgressFinishedEvent extends FormatableEvent
{
    /** @var string */
    private $message;

    public function __construct(string $message = '', string ...$args)
    {
        $this->message = $message;
        $this->setArgs($args);
    }

    public function getMessage(): string
    {
        return $this->format($this->message);
    }
}
