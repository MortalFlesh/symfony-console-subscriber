<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class NoteEvent extends AbstractFormatableEvent
{
    public function __construct(private string $note, string ...$args)
    {
        $this->setArgs($args);
    }

    public function getNote(): string
    {
        return $this->format($this->note);
    }
}
