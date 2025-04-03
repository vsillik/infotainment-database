<?php

declare(strict_types=1);

namespace App\Services\Edid\Base;

use App\Services\Edid\AbstractEdidBlock;
use App\Services\Edid\Base\Section\ColorCharacteristicsSection;
use App\Services\Edid\Base\Section\DataBlocksSection;
use App\Services\Edid\Base\Section\EstablishedTimingsSection;
use App\Services\Edid\Base\Section\HeaderSection;
use App\Services\Edid\Base\Section\ParametersAndFeaturesSection;
use App\Services\Edid\Base\Section\StandardTimingsSection;
use App\Services\Edid\Base\Section\VendorProductIdentificationSection;
use App\Services\Edid\Base\Section\VersionRevisionSection;
use App\Services\Edid\TCalculateChecksumByte;

/**
 * Represents Base EDID (block 0) block
 */
class BaseBlock extends AbstractEdidBlock
{
    use TCalculateChecksumByte;

    public function __construct(
        public readonly VendorProductIdentificationSection $vendorProductIdentification,
        public readonly ParametersAndFeaturesSection $displayParametersAndFeatures,
        public readonly ColorCharacteristicsSection $colorCharacteristics,
        public readonly DataBlocksSection $dataBlocks,
        public readonly int $extensionCount,
    ) {
        if ($extensionCount < 0 || $extensionCount > 255) {
            throw new \InvalidArgumentException('extension count is invalid');
        }
    }

    public function toBytes(): array
    {
        // first fill in all of the bytes in the defined order by EDID standard
        /** @var array<int> $bytes */
        $bytes = array_merge(
            (new HeaderSection)->toBytes(),
            $this->vendorProductIdentification->toBytes(),
            (new VersionRevisionSection)->toBytes(),
            $this->displayParametersAndFeatures->toBytes(),
            $this->colorCharacteristics->toBytes(),
            (new EstablishedTimingsSection)->toBytes(),
            (new StandardTimingsSection)->toBytes(),
            $this->dataBlocks->toBytes(),
        );

        $bytes[] = $this->extensionCount;

        // then calculate the needed byte for checksum of all 128 bytes to be 0
        $checksumByte = $this->calculateChecksumByte($bytes);

        // append checksum to the bytes
        $bytes[] = $checksumByte;

        return $bytes;
    }
}
