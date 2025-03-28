<?php

declare(strict_types=1);

namespace App\Services\Edid\Extension\DataBlock;

class HdmiVendorSpecificDataBlock extends VendorSpecificDataBlock
{
    /**
     * @param  int  $maxTmdsClock  maximum TMDS clock in increments of 5 MHz (1 = 5 MHz, 2 = 10 MHz, ...)
     */
    public function __construct(int $maxTmdsClock)
    {
        if ($maxTmdsClock < 0 || $maxTmdsClock > 255) {
            throw new \InvalidArgumentException('max tmds clock is invalid');
        }

        $data = [
            // physical source address 1st part
            0,
            // physical source address 2nd part
            0,
            // features byte
            0,
            $maxTmdsClock,
        ];

        parent::__construct('000C03', $data);
    }
}
