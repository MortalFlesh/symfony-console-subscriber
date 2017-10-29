<?php

namespace MF\ConsoleSubscriber\Event;

class SectionEvent extends FormatableEvent
{
    /** @var string */
    private $section;

    public function __construct(string $section, string ...$args)
    {
        $this->section = $section;
        $this->setArgs($args);
    }

    public function getSection(): string
    {
        return $this->format($this->section);
    }
}
