<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section\DataBlock;

abstract class AbstractDataBlock
{
    /**
     * @return array<int> 18 bytes
     */
    abstract public function toBytes(): array;
}
