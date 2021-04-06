<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class NoteEvent extends AbstractFormatableEvent
{
    private string $note;

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
