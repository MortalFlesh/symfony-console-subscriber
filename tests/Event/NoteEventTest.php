<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use MF\ConsoleSubscriber\AbstractTestCase;

class NoteEventTest extends AbstractTestCase
{
    public function testShouldFormatNote(): void
    {
        $expected = 'Message with args Value.';
        $event = new NoteEvent('Message with args %s.', 'Value');

        $result = $event->getNote();

        $this->assertSame($expected, $result);
    }
}
