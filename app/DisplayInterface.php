<?php

namespace App;

enum DisplayInterface: string
{
    case DVI = 'dvi';
    case HDMI_A = 'hdmi-a';
    case HDMI_B = 'hdmi-b';
    case MDDI = 'mddi';
    case DISPLAYPORT = 'displayport';

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $case) {
            $labels[$case->value] = match ($case) {
                self::DVI => 'DVI',
                self::HDMI_A => 'HDMI-a',
                self::HDMI_B => 'HDMI-b',
                self::MDDI => 'MDDI',
                self::DISPLAYPORT => 'DisplayPort',
            };
        }

        return $labels;
    }
}
