<?php

namespace MF\Tests\Service;

use MF\ConsoleSubscriber\Service\TableFormatter;
use MF\Tests\AbstractTestCase;

class TableFormatterTest extends AbstractTestCase
{
    /** @dataProvider rowsWithUnicodeChars */
    public function testShouldFormatRowsWithUnicodeChars(array $rows, array $expected)
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('This test should not run on this environment.');
        }

        $result = TableFormatter::formatRows($rows);

        $this->assertEquals($expected, $result);
    }

    public function rowsWithUnicodeChars()
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
                    ["<fg=green;options=bold>\xE2\x9C\x94</>", 'other value'],
                    ['<fg=yellow;options=bold>!</>', 'other value'],
                    ["<fg=red;options=bold>\xE2\x9C\x98</>", 'other value'],
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
                    "<fg=green;options=bold>\xE2\x9C\x94</> value",
                    '<fg=yellow;options=bold>!</> value',
                    "<fg=red;options=bold>\xE2\x9C\x98</> value",
                ],
            ],
        ];
    }

    /** @dataProvider rowsWithoutUnicodeChars */
    public function testShouldFormatRowsWithoutUnicodeChars(array $rows, array $expected)
    {
        if ('\\' !== DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('This test should not run on this environment.');
        }

        $result = TableFormatter::formatRows($rows);

        $this->assertEquals($expected, $result);
    }

    public function rowsWithoutUnicodeChars()
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
                    ['<fg=green;options=bold>OK</>', 'other value'],
                    ['<fg=yellow;options=bold>WARNING</>', 'other value'],
                    ['<fg=red;options=bold>ERROR</>', 'other value'],
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
                    "<fg=green;options=bold>OK</> value",
                    '<fg=yellow;options=bold>WARNING</> value',
                    "<fg=red;options=bold>ERROR</> value",
                ],
            ],
        ];
    }
}
