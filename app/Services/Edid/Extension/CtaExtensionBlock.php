<?php

declare(strict_types=1);

namespace App\Services\Edid\Extension;

use App\Services\Edid\AbstractEdidBlock;
use App\Services\Edid\Extension\DataBlock\AbstractDataBlock;
use App\Services\Edid\TCalculateChecksumByte;

class CtaExtensionBlock extends AbstractEdidBlock
{
    use TCalculateChecksumByte;

    /**
     * @var array<AbstractDataBlock>
     */
    private array $dataBlocks = [];

    public function addDataBlock(AbstractDataBlock $dataBlock): void
    {
        $this->dataBlocks[] = $dataBlock;
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        $dataBlocksBytes = [];

        foreach ($this->dataBlocks as $dataBlock) {
            $dataBlocksBytes = array_merge($dataBlocksBytes, $dataBlock->toBytes());
        }

        $dataBlocksBytesCount = count($dataBlocksBytes);
        // max data blocks length = 128 bytes - 4 header bytes - 1 checksum byte
        if ($dataBlocksBytesCount > 123) {
            throw new \InvalidArgumentException('data blocks are too long');
        }

        // set header bytes
        $bytes = [
            // Extension TAG for CTA 861
            0x02,
            // Extension version
            0x03,
            // address of byte after the data block collection = total length of data blocks + 4 (number of header bytes)
            $dataBlocksBytesCount + 4,
            // features byte, bit 3-0 number of detailed timing descriptors = 0
            0,
        ];

        // add data blocks bytes
        $bytes = array_merge(
            $bytes,
            $dataBlocksBytes
        );

        // add padding bytes, so bytes are exactly 127 bytes long (128 - 1 checksum byte)
        for ($i = count($bytes); $i < 127; $i++) {
            $bytes[] = 0;
        }

        // then calculate the needed byte for checksum of all 128 bytes to be 0
        $checksumByte = $this->calculateChecksumByte($bytes);

        $bytes[] = $checksumByte;

        return $bytes;
    }
}
