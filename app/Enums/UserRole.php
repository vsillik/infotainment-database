<?php

namespace App\Enums;

enum UserRole: int
{
    case CUSTOMER = 0;

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
            $labels[$case->value] = $case->toHumanReadable();
        }

        return $labels;
    }

    public function toHumanReadable(): string
    {
        return ucfirst(strtolower($this->name));
    }
}
