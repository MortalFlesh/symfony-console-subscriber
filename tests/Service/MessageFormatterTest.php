<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Service;

use MF\ConsoleSubscriber\AbstractTestCase;

class MessageFormatterTest extends AbstractTestCase
{
    /** @dataProvider messageProvider */
    public function testShouldFormatMessage(string $message, string $expected): void
    {
        $result = MessageFormatter::formatMessage($message);

        $this->assertSame($expected, $result);
    }

    public function messageProvider(): array
    {
        return [
            // message, expected
            'empty' => ['', ''],
            'without marks' => ['Some message', 'Some message'],
            'with unkonw mark' => ['Some message with {UNKNOWN}', 'Some message with {UNKNOWN}'],
            'with status ok' => [
                '{OK} Some message',
                sprintf('<fg=green;options=bold>%s</> Some message', $this->expectsUnicode("\xE2\x9C\x94", 'OK')),
            ],
            'with status warning' => [
                '{WARNING} Some message',
                sprintf('<fg=yellow;options=bold>%s</> Some message', $this->expectsUnicode('!', 'WARNING')),
            ],
            'with status error' => [
                '{ERROR} Some message',
                sprintf('<fg=red;options=bold>%s</> Some message', $this->expectsUnicode("\xE2\x9C\x98", 'ERROR')),
            ],
        ];
    }
}
