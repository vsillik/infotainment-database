<?php

declare(strict_types=1);

namespace App\Services\Edid;

abstract class AbstractEdidBlock
{
    /**
     * @return array<int> 128 bytes
     */
    abstract public function toBytes(): array;
}
