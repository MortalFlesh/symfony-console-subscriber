<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Event;

use MF\ConsoleSubscriber\AbstractTestCase;

class ProgressStartEventTest extends AbstractTestCase
{
    /** @dataProvider countProvider */
    public function testShouldStartProgress(int|\Countable|array $count, int $expected): void
    {
        $event = new ProgressStartEvent($count);

        $this->assertSame($expected, $event->getCount());
    }

    public function countProvider(): array
    {
        return [
            // count, expected
            'int' => [5, 5],
            'Counteble - array' => [[1, 2, 3], 3],
            'Counteble - Object' => [
                new class() implements \Countable {
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
