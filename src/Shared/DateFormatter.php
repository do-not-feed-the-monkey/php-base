<?php

declare(strict_types=1);

namespace App\Shared;

class DateFormatter
{
    public const string DATE_FORMAT = 'Y-m-d H:i:s';

    public static function format(\DateTimeImmutable $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }

    public static function formatNullable(?\DateTimeImmutable $dateTime): ?string
    {
        if ($dateTime === null) {
            return null;
        }

        return $dateTime->format(self::DATE_FORMAT);
    }
}
