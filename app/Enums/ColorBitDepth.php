<?php

namespace App\Enums;

enum ColorBitDepth: int
{
    case BIT_6 = 6;
    case BIT_8 = 8;
    case BIT_10 = 10;
    case BIT_12 = 12;
    case BIT_14 = 14;
    case BIT_16 = 16;

    /**
     * @return array<int, string>
     */
    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->value.'-bit';
        }

        return $labels;
    }
}
