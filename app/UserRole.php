<?php

namespace App;

enum UserRole: int
{
    case GUEST = 0;

    case OPERATOR = 1;

    case VALIDATOR = 2;

    case ADMINISTRATOR = 3;

    /**
     * @return array<int, string>
     */
    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $case) {
            $labels[$case->value] = ucfirst(strtolower($case->name));
        }

        return $labels;
    }
}
