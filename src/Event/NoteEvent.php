<?php

namespace MF\ConsoleSubscriber\Event;

class NoteEvent extends FormatableEvent
{
    /** @var string */
    private $note;

    public function __construct(string $note, string ...$args)
    {
        $this->note = $note;
        $this->setArgs($args);
    }

    public function getNote(): string
    {
        return $this->format($this->note);
    }
}
