<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

/**
 * Represents the base EDID section established timings section, provides empty values
 */
class EstablishedTimingsSection extends AbstractSection
{
    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        return [0, 0, 0];
    }
}
