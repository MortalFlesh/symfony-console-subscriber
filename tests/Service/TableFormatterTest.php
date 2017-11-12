<?php

namespace MF\Tests\Service;

use MF\ConsoleSubscriber\Service\TableFormatter;
use MF\Tests\AbstractTestCase;

class TableFormatterTest extends AbstractTestCase
{
    /** @dataProvider rowsProvider */
    public function testShouldFormatRows(array $rows, array $expected)
    {
        $result = TableFormatter::formatRows($rows);

        $this->assertEquals($expected, $result);
    }

    public function rowsProvider()
    {
        return [
            // rows, expected
            'empty' => [[], []],
            'without any marks' => [
                [
                    ['1 - first col value', '1 - second col value'],
                    ['2 - first col value', '2 - second col value'],
                ],
                [
                    ['1 - first col value', '1 - second col value'],
                    ['2 - first col value', '2 - second col value'],
                ],
            ],
            'with any marks' => [
                [
                    ['{INVALID}', 'other value'],
                    ['{OK}', 'other value'],
                    ['{WARNING}', 'other value'],
                    ['{ERROR}', 'other value'],
                ],
                [
                    ['{INVALID}', 'other value'],
                    [
                        sprintf("<fg=green;options=bold>%s</>", $this->expectsUnicode("\xE2\x9C\x94", 'OK')),
                        'other value',
                    ],
                    [
                        sprintf("<fg=yellow;options=bold>%s</>", $this->expectsUnicode('!', 'WARNING')),
                        'other value',
                    ],
                    [
                        sprintf("<fg=red;options=bold>%s</>", $this->expectsUnicode("\xE2\x9C\x98", 'ERROR')),
                        'other value',
                    ],
                ],
            ],
            'string rows without marks' => [
                [
                    '1 - first col value',
                    '2 - first col value',
                ],
                [
                    '1 - first col value',
                    '2 - first col value',
                ],
            ],
            'string rows with marks' => [
                [
                    '{INVALID} value',
                    '{OK} value',
                    '{WARNING} value',
                    '{ERROR} value',
                ],
                [
                    '{INVALID} value',
                    sprintf("<fg=green;options=bold>%s</> value", $this->expectsUnicode("\xE2\x9C\x94", 'OK')),
                    sprintf("<fg=yellow;options=bold>%s</> value", $this->expectsUnicode('!', 'WARNING')),
                    sprintf("<fg=red;options=bold>%s</> value", $this->expectsUnicode("\xE2\x9C\x98", 'ERROR')),
                ],
            ],
        ];
    }
}
