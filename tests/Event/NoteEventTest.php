<?php

namespace MF\Tests\Event;

use MF\ConsoleSubscriber\Event\NoteEvent;
use MF\Tests\AbstractTestCase;

class NoteEventTest extends AbstractTestCase
{
    public function testShouldFormatNote()
    {
        $expected = 'Message with args Value.';
        $event = new NoteEvent('Message with args %s.', 'Value');

        $result = $event->getNote();

        $this->assertSame($expected, $result);
    }
}
