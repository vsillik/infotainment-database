<?php

declare(strict_types=1);

namespace App\Services\Edid;

trait TCalculateChecksumByte
{
    /**
     * @param  array<int>  $bytes
     */
    private function calculateChecksumByte(array $bytes): int
    {
        $sum = 0;

        foreach ($bytes as $byte) {
            $sum += $byte;
        }

        // sum as a byte in range 0 to 255
        $sumModulo = $sum % 256;

        // in order for the checksum with the checksum byte to be 256, we need to calculate difference from 25ž of this sum
        return 256 - $sumModulo;
    }
}
