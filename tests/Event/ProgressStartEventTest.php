<?php

namespace MF\Tests\Event;

use MF\ConsoleSubscriber\Event\ProgressStartEvent;
use MF\Tests\AbstractTestCase;

class ProgressStartEventTest extends AbstractTestCase
{
    /** @dataProvider countProvider */
    public function testShouldStartProgress($count, int $expected)
    {
        $event = new ProgressStartEvent($count);

        $this->assertSame($expected, $event->getCount());
    }

    public function countProvider()
    {
        return [
            // count, expected
            'int' => [5, 5],
            'Counteble - array' => [[1, 2, 3], 3],
            'Counteble - Object' => [
                new class() implements \Countable
                {
                    public function count()
                    {
                        return 5;
                    }
                },
                5,
            ],
        ];
    }
}
