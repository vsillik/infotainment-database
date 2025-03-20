<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section\DataBlock;

trait TAsciiToBytes
{
    /**
     * @return array<int>
     */
    public function asciiToBytes(string $asciiData): array
    {
        $bytes = [];
        for ($i = 0; $i < strlen($asciiData); $i++) {
            $bytes[] = ord($asciiData[$i]);
        }

        if (count($bytes) < 13) {
            $bytes[] = 0x0A;

            for ($i = count($bytes); $i < 13; $i++) {
                $bytes[] = 0x20;
            }
        }

        return $bytes;
    }
}
