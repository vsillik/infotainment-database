<?php

declare(strict_types=1);

namespace App\Services\Edid;

use App\Models\Infotainment;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;
use App\Services\Edid\Base\BaseBlock;
use App\Services\Edid\Base\Section\DataBlock\AlphanumericDisplayDescriptor;
use App\Services\Edid\Base\Section\DataBlock\DetailedTimingDataBlock;
use App\Services\Edid\Base\Section\DataBlock\DisplayProductNameDisplayDescriptor;
use App\Services\Edid\Base\Section\DataBlocksSection;
use App\Services\Edid\Base\Section\ParametersAndFeaturesSection;
use App\Services\Edid\Base\Section\VendorProductIdentificationSection;
use Illuminate\Support\Carbon;

class EdidBuilder
{
    public static function buildDetailedTimingBlock(InfotainmentProfileTimingBlock $timingBlock): DetailedTimingDataBlock
    {
        return new DetailedTimingDataBlock(
            $timingBlock->pixel_clock,
            $timingBlock->horizontal_pixels,
            $timingBlock->horizontal_blank,
            $timingBlock->horizontal_front_porch ?? 0,
            $timingBlock->horizontal_sync_width ?? 0,
            $timingBlock->horizontal_image_size ?? 0,
            $timingBlock->horizontal_border ?? 0,
            $timingBlock->vertical_lines,
            $timingBlock->vertical_blank,
            $timingBlock->vertical_front_porch ?? 0,
            $timingBlock->vertical_sync_width ?? 0,
            $timingBlock->vertical_image_size ?? 0,
            $timingBlock->vertical_border ?? 0,
            $timingBlock->signal_vertical_sync_positive,
            $timingBlock->signal_horizontal_sync_positive,
        );
    }

    public static function buildDataBlocksSection(Infotainment $infotainment, InfotainmentProfile $infotainmentProfile): DataBlocksSection
    {
        $preferredTiming = self::buildDetailedTimingBlock($infotainmentProfile->timing);
        $dataBlockSection = new DataBlocksSection($preferredTiming);

        if ($infotainmentProfile->extraTiming !== null) {
            $dataBlockSection->addDataBlock(self::buildDetailedTimingBlock($infotainmentProfile->extraTiming));
        }

        $dataBlockSection->addDataBlock(new DisplayProductNameDisplayDescriptor($infotainment->part_number));

        $profileNumber = min($infotainmentProfile->profile_number, 99);
        $hwSwVersion = sprintf('H%04sS%03sP%02d', $infotainmentProfile->hw_version, $infotainmentProfile->hw_version, $profileNumber);
        $dataBlockSection->addDataBlock(new AlphanumericDisplayDescriptor($hwSwVersion));

        return $dataBlockSection;
    }

    /**
     * @return array<int> array of bytes of built edid
     */
    public static function build(Infotainment $infotainment, InfotainmentProfile $infotainmentProfile): array
    {
        $vendorSection = new VendorProductIdentificationSection(
            $infotainment->serializerManufacturer->id,
            sprintf('%04s', $infotainment->product_id),
            $infotainmentProfile->created_at ?? new Carbon,
            $infotainment->model_year,
        );

        $parametersSection = new ParametersAndFeaturesSection(
            $infotainmentProfile->color_bit_depth,
            $infotainmentProfile->interface,
            $infotainmentProfile->horizontal_size,
            $infotainmentProfile->vertical_size,
            2.2,
            $infotainmentProfile->is_ycrcb_4_4_4,
            $infotainmentProfile->is_ycrcb_4_2_2,
            $infotainmentProfile->is_srgb,
            true,
            $infotainmentProfile->is_continuous_frequency,
        );

        $dataBlocksSection = self::buildDataBlocksSection($infotainment, $infotainmentProfile);

        $baseEdid = new BaseBlock(
            $vendorSection,
            $parametersSection,
            $dataBlocksSection,
            0
        );

        return $baseEdid->toBytes();
    }
}
