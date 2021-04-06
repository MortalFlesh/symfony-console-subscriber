<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class SectionEvent extends AbstractFormatableEvent
{
    private string $section;

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
