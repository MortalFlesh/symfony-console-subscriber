<?php

namespace MF\ConsoleSubscriber\Service;

class TableFormatter
{
    public static function formatRows(array $rows): array
    {
        return array_map(
            function ($row) {
                if (is_string($row)) {
                    return MessageFormatter::formatMessage($row);
                }

                return is_array($row)
                    ? self::formatRow($row)
                    : $row;
            },
            $rows
        );
    }

    private static function formatRow(array $row): array
    {
        return array_map(
            function ($column) {
                return is_string($column)
                    ? MessageFormatter::formatMessage($column)
                    : $column;
            },
            $row
        );
    }
}
