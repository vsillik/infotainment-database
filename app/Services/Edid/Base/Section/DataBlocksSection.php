<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

use App\Services\Edid\Base\Section\DataBlock\AbstractDataBlock;
use App\Services\Edid\Base\Section\DataBlock\DetailedTimingDataBlock;
use App\Services\Edid\Base\Section\DataBlock\UnusedDisplayDescriptor;

/**
 * Represents the base EDID data blocks section
 */
class DataBlocksSection extends AbstractSection
{
    /**
     * @var array<AbstractDataBlock>
     */
    private array $timings;

    /**
     * @var array<AbstractDataBlock>
     */
    private array $displayDescriptors;

    public function __construct(
        DetailedTimingDataBlock $preferredTimingBlock,
    ) {
        $this->timings = [$preferredTimingBlock];
        $this->displayDescriptors = [];
    }

    public function addDataBlock(AbstractDataBlock $dataBlock): void
    {
        if (count($this->timings) + count($this->displayDescriptors) > 4) {
            throw new \InvalidArgumentException('already reached maximum number of data blocks');
        }

        if ($dataBlock instanceof DetailedTimingDataBlock) {
            $this->timings[] = $dataBlock;

            return;
        }

        $this->displayDescriptors[] = $dataBlock;
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        $blocks = 0;
        $bytes = [];

        // detailed timings needs to be first in the output
        foreach ($this->timings as $timing) {
            $bytes = array_merge($bytes, $timing->toBytes());
            $blocks++;
        }

        // then rest of the data blocks (display descriptors)
        foreach ($this->displayDescriptors as $displayDescriptor) {
            $bytes = array_merge($bytes, $displayDescriptor->toBytes());
            $blocks++;
        }

        // and needs to be padded with unused segments to match required format of 4x 18 bytes blocks
        for ($i = $blocks; $i < 4; $i++) {
            $bytes = array_merge($bytes, (new UnusedDisplayDescriptor)->toBytes());
        }

        return $bytes;
    }
}
