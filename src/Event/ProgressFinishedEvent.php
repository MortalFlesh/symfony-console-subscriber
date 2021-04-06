<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class ProgressFinishedEvent extends AbstractFormatableEvent
{
    private string $message;

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
