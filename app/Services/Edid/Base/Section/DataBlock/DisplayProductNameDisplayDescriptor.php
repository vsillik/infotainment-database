<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section\DataBlock;

class DisplayProductNameDisplayDescriptor extends AbstractDataBlock
{
    use TAsciiToBytes;

    public function __construct(
        public readonly string $data,
    ) {
        if (preg_match('/^[\x20-\x7e]{1,13}$/', $data) !== 1) {
            throw new \InvalidArgumentException('data is invalid');
        }
    }

    public function toBytes(): array
    {
        return [
            0, 0, 0, 0xFC, 0,
            ...$this->asciiToBytes($this->data),
        ];
    }
}
