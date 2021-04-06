<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class MessageEvent extends AbstractFormatableEvent
{
    public function __construct(private string $message, string ...$args)
    {
        $this->setArgs($args);
    }

    public function getMessage(): string
    {
        return $this->format($this->message);
    }
}
