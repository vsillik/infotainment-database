<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section\DataBlock;

class DetailedTimingDataBlock extends AbstractDataBlock
{
    public function __construct(
        public readonly float $pixelClockInMHz,
        public readonly int $horizontalAddressablePixels,
        public readonly int $horizontalBlankingPixels,
        public readonly int $horizontalFrontPorchPixels,
        public readonly int $horizontalSyncWidthPixels,
        public readonly int $horizontalImageSizeMillimeters,
        public readonly int $horizontalBorderPixels,
        public readonly int $verticalAddressableLines,
        public readonly int $verticalBlankingLines,
        public readonly int $verticalFrontPorchLines,
        public readonly int $verticalSyncWidthLines,
        public readonly int $verticalImageSizeMillimeters,
        public readonly int $verticalBorderLines,
        public readonly bool $isVerticalSyncPositive,
        public readonly bool $isHorizontalSyncPositive,
    ) {
        if ($pixelClockInMHz < 0.01 || $pixelClockInMHz > 655.35) {
            throw new \InvalidArgumentException('pixel clock in MHz is invalid');
        }

        if ($horizontalAddressablePixels < 0 || $horizontalAddressablePixels > 4095) {
            throw new \InvalidArgumentException('horizontal addressable pixels is invalid');
        }

        if ($horizontalBlankingPixels < 0 || $horizontalBlankingPixels > 4095) {
            throw new \InvalidArgumentException('horizontal blanking pixels is invalid');
        }

        if ($horizontalFrontPorchPixels < 0 || $horizontalFrontPorchPixels > 1023) {
            throw new \InvalidArgumentException('horizontal front porch pixels is invalid');
        }

        if ($horizontalSyncWidthPixels < 0 || $horizontalSyncWidthPixels > 1023) {
            throw new \InvalidArgumentException('horizontal sync width pixels is invalid');
        }

        if ($horizontalImageSizeMillimeters < 0 || $horizontalImageSizeMillimeters > 4095) {
            throw new \InvalidArgumentException('horizontal image size is invalid');
        }

        if ($horizontalBorderPixels < 0 || $horizontalBorderPixels > 255) {
            throw new \InvalidArgumentException('horizontal border pixels is invalid');
        }

        if ($verticalAddressableLines < 0 || $verticalAddressableLines > 4095) {
            throw new \InvalidArgumentException('vertical addressable lines is invalid');
        }

        if ($verticalBlankingLines < 0 || $verticalBlankingLines > 4095) {
            throw new \InvalidArgumentException('vertical blanking lines is invalid');
        }

        if ($verticalFrontPorchLines < 0 || $verticalFrontPorchLines > 63) {
            throw new \InvalidArgumentException('vertical front porch lines is invalid');
        }

        if ($verticalSyncWidthLines < 0 || $verticalSyncWidthLines > 63) {
            throw new \InvalidArgumentException('vertical sync width lines is invalid');
        }

        if ($verticalImageSizeMillimeters < 0 || $verticalImageSizeMillimeters > 4095) {
            throw new \InvalidArgumentException('vertical image size millimeters is invalid');
        }

        if ($verticalBorderLines < 0 || $verticalBorderLines > 255) {
            throw new \InvalidArgumentException('vertical border lines is invalid');
        }
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        // first multiply the pixel clock by 1000000 to get it into Hz, and then divide by 10000 to get into edid format
        // => multiply by 100
        $pixelClock = (int) (round($this->pixelClockInMHz, 2) * 100);

        return [
            $pixelClock & 0b11111111,
            ($pixelClock & 0b11111111_00000000) >> 8,
            $this->horizontalAddressablePixels & 0b11111111,
            $this->horizontalBlankingPixels & 0b11111111,
            (($this->horizontalAddressablePixels & 0b1111_00000000) >> 4) | (($this->horizontalBlankingPixels & 0b111100000000) >> 8),
            $this->verticalAddressableLines & 0b11111111,
            $this->verticalBlankingLines & 0b11111111,
            (($this->verticalAddressableLines & 0b1111_00000000) >> 4) | (($this->verticalBlankingLines & 0b111100000000) >> 8),
            $this->horizontalFrontPorchPixels & 0b11111111,
            $this->horizontalSyncWidthPixels & 0b11111111,
            (($this->verticalFrontPorchLines & 0b1111) << 4) | (($this->verticalSyncWidthLines & 0b1111)),
            (($this->horizontalFrontPorchPixels & 0b11_00000000) >> 2) | (($this->horizontalSyncWidthPixels & 0b11_00000000) >> 4) | (($this->verticalFrontPorchLines & 0b110000) >> 2) | (($this->verticalSyncWidthLines & 0b110000) >> 4),
            $this->horizontalImageSizeMillimeters & 0b11111111,
            $this->verticalImageSizeMillimeters & 0b11111111,
            (($this->horizontalImageSizeMillimeters & 0b1111_00000000) >> 4) | (($this->verticalImageSizeMillimeters & 0b1111_00000000) >> 8),
            $this->horizontalBorderPixels & 0b11111111,
            $this->verticalBorderLines & 0b11111111,
            // bit 7 - is interlaced, bits 6,5 and 0 stereo viewing, bits 4+3 set to 1 means digital separate then bit 2 vsync is positive, bit 1 hsync is positive
            0b00011000 | ((int) $this->isVerticalSyncPositive << 2) | ((int) $this->isHorizontalSyncPositive << 1),
        ];
    }
}
