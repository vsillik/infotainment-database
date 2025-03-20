<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

/**
 * Represents the base EDID section standard timings section, provides empty values
 */
class StandardTimingsSection extends AbstractSection
{
    public function toBytes(): array
    {
        // returns for each of 8 standard timings values 0x01 0x01, which indicates unused data
        return [
            1, 1,
            1, 1,
            1, 1,
            1, 1,
            1, 1,
            1, 1,
            1, 1,
            1, 1,
        ];
    }
}
