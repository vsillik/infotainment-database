<?php

declare(strict_types=1);

namespace App\Services\Edid\Extension\DataBlock;

abstract class AbstractDataBlock
{
    /**
     * @return array<int>
     */
    abstract public function toBytes(): array;
}
