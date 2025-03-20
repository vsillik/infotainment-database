<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

/**
 * Represents abstract EDID structure section
 */
abstract class AbstractSection
{
    /**
     * @return array<int>
     */
    abstract public function toBytes(): array;
}
