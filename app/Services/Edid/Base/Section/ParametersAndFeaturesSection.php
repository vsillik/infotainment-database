<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

use App\Enums\ColorBitDepth;
use App\Enums\DisplayInterface;

/**
 * Represents the base EDID section basic display parameters and features
 */
class ParametersAndFeaturesSection extends AbstractSection
{
    public function __construct(
        public readonly ColorBitDepth $colorBitDepth,
        public readonly DisplayInterface $displayInterface,
        public readonly int $horizontalScreenSize,
        public readonly int $verticalScreenSize,
        public readonly float $gamma,
        public readonly bool $isYCrCb444,
        public readonly bool $isYCrCb422,
        public readonly bool $isSRgb,
        public readonly bool $isPreferredTimingMode,
        public readonly bool $isContinuousFrequency,
    ) {
        if ($horizontalScreenSize < 1 || $horizontalScreenSize > 255) {
            throw new \InvalidArgumentException('horizontal screen size is invalid');
        }

        if ($verticalScreenSize < 1 || $verticalScreenSize > 255) {
            throw new \InvalidArgumentException('vertical screen size is invalid');
        }

        if ($gamma < 1 || $gamma > 3.54) {
            throw new \InvalidArgumentException('gamma is invalid');
        }
    }

    public function toBytes(): array
    {
        /** @var array<int> $mergedBytes */
        $mergedBytes = array_merge(
            $this->videoInputDefinitionToBytes(),
            $this->screenSizeToBytes(),
            $this->gammaToBytes(),
            $this->featuresToBytes()
        );

        return $mergedBytes;
    }

    private function colorBitDepthToThreeBits(): int
    {
        return match ($this->colorBitDepth) {
            ColorBitDepth::BIT_6 => 1,
            ColorBitDepth::BIT_8 => 2,
            ColorBitDepth::BIT_10 => 3,
            ColorBitDepth::BIT_12 => 4,
            ColorBitDepth::BIT_14 => 5,
            ColorBitDepth::BIT_16 => 6,
        };
    }

    private function displayInterfaceToFourBits(): int
    {
        return match ($this->displayInterface) {
            DisplayInterface::DVI => 1,
            DisplayInterface::HDMI_A => 2,
            DisplayInterface::HDMI_B => 3,
            DisplayInterface::MDDI => 4,
            DisplayInterface::DISPLAYPORT => 5,
        };
    }

    /**
     * @return array<int>
     */
    private function videoInputDefinitionToBytes(): array
    {
        // single byte, with 1st bit 1, next 3 bits are color bit depth, last 4 bits are display interface
        return [
            (0b10000000 | (($this->colorBitDepthToThreeBits() & 0b111) << 4) | ($this->displayInterfaceToFourBits() & 0b1111)),
        ];
    }

    /**
     * @return array<int>
     */
    private function screenSizeToBytes(): array
    {
        return [
            $this->horizontalScreenSize,
            $this->verticalScreenSize,
        ];
    }

    /**
     * @return array<int>
     */
    private function gammaToBytes(): array
    {
        $calculatedGamma = ((int) round($this->gamma * 100)) - 100;

        return [
            $calculatedGamma,
        ];
    }

    /**
     * @return array<int>
     */
    private function featuresToBytes(): array
    {
        // 3 bits are 0 (unsupported for this app), next bit is 1 if 4:2:2 is supported, next bit is 1 if 4:4:4 is supported
        // next bit is 1 if sRGB is default, next bit is 1 if preferred timing includes native pixel, last bit is 1 if is continuous frequency
        $result = 0;
        $result = $result | (((int) $this->isYCrCb422) << 4);
        $result = $result | (((int) $this->isYCrCb444) << 3);
        $result = $result | (((int) $this->isSRgb) << 2);
        $result = $result | (((int) $this->isPreferredTimingMode) << 1);
        $result = $result | ((int) $this->isContinuousFrequency);

        return [$result];
    }
}
