<?php

namespace MF\ConsoleSubscriber\Service;

class MessageFormatter
{
    public const MARK_OK = '{OK}';
    public const MARK_WARNING = '{WARNING}';
    public const MARK_ERROR = '{ERROR}';

    public static function formatMessage(string $value): string
    {
        return str_replace(
            [self::MARK_OK, self::MARK_WARNING, self::MARK_ERROR],
            [self::markOk(), self::markWarning(), self::markError()],
            $value
        );
    }

    private static function markOk(): string
    {
        return sprintf(
            '<fg=green;options=bold>%s</>',
            '\\' === DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */
        );
    }

    private static function markWarning(): string
    {
        return sprintf('<fg=yellow;options=bold>%s</>', '\\' === DIRECTORY_SEPARATOR ? 'WARNING' : '!');
    }

    private static function markError(): string
    {
        return sprintf(
            '<fg=red;options=bold>%s</>',
            '\\' === DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */
        );
    }
}
