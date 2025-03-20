<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

class HeaderSection extends AbstractSection
{
    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        return [0, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0];
    }
}
