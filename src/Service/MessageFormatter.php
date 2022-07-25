<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Service;

class MessageFormatter
{
    public const MARK_OK = '{OK}';
    public const MARK_WARNING = '{WARNING}';
    public const MARK_ERROR = '{ERROR}';

    /** HEAVY CHECK MARK (U+2714) */
    private const MARK_CHECK = "\xE2\x9C\x94";

    /** HEAVY BALLOT X (U+2718) */
    private const MARK_BALLOT = "\xE2\x9C\x98";

    public static function formatMessage(string $value): string
    {
        return str_replace(
            [self::MARK_OK, self::MARK_WARNING, self::MARK_ERROR],
            [self::markOk(), self::markWarning(), self::markError()],
            $value,
        );
    }

    private static function markOk(): string
    {
        return sprintf('<fg=green;options=bold>%s</>', self::unicode(self::MARK_CHECK, 'OK'));
    }

    private static function unicode(string $unicode, string $fallback): string
    {
        return '\\' === DIRECTORY_SEPARATOR ? $fallback : $unicode;
    }

    private static function markWarning(): string
    {
        return sprintf('<fg=yellow;options=bold>%s</>', self::unicode('!', 'WARNING'));
    }

    private static function markError(): string
    {
        return sprintf('<fg=red;options=bold>%s</>', self::unicode(self::MARK_BALLOT, 'ERROR'));
    }
}
