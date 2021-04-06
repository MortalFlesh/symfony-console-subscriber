<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

class SectionEvent extends AbstractFormatableEvent
{
    public function __construct(private string $section, string ...$args)
    {
        $this->setArgs($args);
    }

    public function getSection(): string
    {
        return $this->format($this->section);
    }
}
