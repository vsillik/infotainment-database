<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

/**
 * Represents version and revision of EDID block, currently supported version 1.4
 */
class VersionRevisionSection extends AbstractSection
{
    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        return [
            1,
            4,
        ];
    }
}
