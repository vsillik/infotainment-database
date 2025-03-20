<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section\DataBlock;

/**
 * represents unused display descriptor for base EDID (data block)
 */
class UnusedDisplayDescriptor extends AbstractDataBlock
{
    public function toBytes(): array
    {
        return [
            0, 0, 0, 0x10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        ];
    }
}
