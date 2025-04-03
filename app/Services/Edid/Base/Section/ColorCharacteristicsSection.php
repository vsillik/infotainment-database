<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

/**
 * Represents the base EDID section color characteristics section, provides empty values
 */
class ColorCharacteristicsSection extends AbstractSection
{
    public function __construct(
        public readonly float $redX,
        public readonly float $redY,
        public readonly float $greenX,
        public readonly float $greenY,
        public readonly float $blueX,
        public readonly float $blueY,
        public readonly float $whiteX,
        public readonly float $whiteY,
    ) {
        if ($redX >= 1 || $redX < 0) {
            throw new \InvalidArgumentException('red x is invalid');
        }

        if ($redY >= 1 || $redY < 0) {
            throw new \InvalidArgumentException('red y is invalid');
        }

        if ($greenX >= 1 || $greenX < 0) {
            throw new \InvalidArgumentException('green x is invalid');
        }

        if ($greenY >= 1 || $greenY < 0) {
            throw new \InvalidArgumentException('green y is invalid');
        }

        if ($blueX >= 1 || $blueX < 0) {
            throw new \InvalidArgumentException('blue x is invalid');
        }

        if ($blueY >= 1 || $blueY < 0) {
            throw new \InvalidArgumentException('blue y is invalid');
        }

        if ($whiteX >= 1 || $whiteX < 0) {
            throw new \InvalidArgumentException('white x is invalid');
        }

        if ($whiteY >= 1 || $whiteY < 0) {
            throw new \InvalidArgumentException('white y is invalid');
        }
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        $redY = $this->colorToTenBits($this->redY);
        $redX = $this->colorToTenBits($this->redX);
        $greenX = $this->colorToTenBits($this->greenX);
        $greenY = $this->colorToTenBits($this->greenY);
        $blueX = $this->colorToTenBits($this->blueX);
        $blueY = $this->colorToTenBits($this->blueY);
        $whiteX = $this->colorToTenBits($this->whiteX);
        $whiteY = $this->colorToTenBits($this->whiteY);

        return [
            // Bit 1-0 red X, bit 1-0 red Y, bit 1-0 green X, bit 1-0 green Y
            (($redX & 0b11) << 6) | (($redY & 0b11) << 4) | (($greenX & 0b11) << 2) | ($greenY & 0b11),
            // Bit 1-0 blue X, bit 1-0 blue Y, bit 1-0 white X, bit 1-0 white Y
            (($blueX & 0b11) << 6) | (($blueY & 0b11) << 4) | (($whiteX & 0b11) << 2) | ($whiteY & 0b11),
            ($redX & 0b11_11111100) >> 2,
            ($redY & 0b11_11111100) >> 2,
            ($greenX & 0b11_11111100) >> 2,
            ($greenY & 0b11_11111100) >> 2,
            ($blueX & 0b11_11111100) >> 2,
            ($blueY & 0b11_11111100) >> 2,
            ($whiteX & 0b11_11111100) >> 2,
            ($whiteY & 0b11_11111100) >> 2,
        ];
    }

    private function colorToTenBits(float $value): int
    {
        // convert number to multiply of 1/1024, because the 10-bit number represents 2^{-10} increments
        // => $value / (1/1024) = $value * 1024, then we round the number and make sure it's 10 bits
        return (int) round($value * 1024) & 0b11_11111111;
    }
}
