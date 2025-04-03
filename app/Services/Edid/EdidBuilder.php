<?php

declare(strict_types=1);

namespace App\Services\Edid;

use App\Enums\DisplayInterface;
use App\Models\Infotainment;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;
use App\Services\Edid\Base\BaseBlock;
use App\Services\Edid\Base\Section\ColorCharacteristicsSection;
use App\Services\Edid\Base\Section\DataBlock\AlphanumericDisplayDescriptor;
use App\Services\Edid\Base\Section\DataBlock\DetailedTimingDataBlock;
use App\Services\Edid\Base\Section\DataBlock\DisplayProductNameDisplayDescriptor;
use App\Services\Edid\Base\Section\DataBlocksSection;
use App\Services\Edid\Base\Section\ParametersAndFeaturesSection;
use App\Services\Edid\Base\Section\VendorProductIdentificationSection;
use App\Services\Edid\Extension\CtaExtensionBlock;
use App\Services\Edid\Extension\DataBlock\HdmiVendorSpecificDataBlock;
use App\Services\Edid\Extension\DataBlock\VendorSpecificDataBlock;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class EdidBuilder
{
    public static function buildDetailedTimingBlock(InfotainmentProfileTimingBlock $timingBlock): DetailedTimingDataBlock
    {
        return new DetailedTimingDataBlock(
            $timingBlock->pixel_clock,
            $timingBlock->horizontal_pixels,
            $timingBlock->horizontal_blank,
            $timingBlock->horizontal_front_porch,
            $timingBlock->horizontal_sync_width,
            $timingBlock->horizontal_image_size,
            $timingBlock->horizontal_border ?? 0,
            $timingBlock->vertical_lines,
            $timingBlock->vertical_blank,
            $timingBlock->vertical_front_porch,
            $timingBlock->vertical_sync_width,
            $timingBlock->vertical_image_size,
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
        $hwSwVersion = sprintf('H%03sS%04sP%02d', $infotainmentProfile->hw_version, $infotainmentProfile->sw_version, $profileNumber);
        $dataBlockSection->addDataBlock(new AlphanumericDisplayDescriptor($hwSwVersion));

        return $dataBlockSection;
    }

    public static function buildBaseEdid(Infotainment $infotainment, InfotainmentProfile $infotainmentProfile, int $extensionCount): BaseBlock
    {
        $vendorSection = new VendorProductIdentificationSection(
            $infotainment->serializerManufacturer->id,
            sprintf('%04s', $infotainment->product_id),
            $infotainmentProfile->updated_at ?? new Carbon,
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

        $colorCharacteristics = new ColorCharacteristicsSection(
            floatval(Config::string('app.chromaticity.red_x')),
            floatval(Config::string('app.chromaticity.red_y')),
            floatval(Config::string('app.chromaticity.green_x')),
            floatval(Config::string('app.chromaticity.green_y')),
            floatval(Config::string('app.chromaticity.blue_x')),
            floatval(Config::string('app.chromaticity.blue_y')),
            floatval(Config::string('app.chromaticity.white_x')),
            floatval(Config::string('app.chromaticity.white_y')),
        );

        $dataBlocksSection = self::buildDataBlocksSection($infotainment, $infotainmentProfile);

        return new BaseBlock(
            $vendorSection,
            $parametersSection,
            $colorCharacteristics,
            $dataBlocksSection,
            $extensionCount,
        );
    }

    public static function buildCtaExtension(InfotainmentProfile $infotainmentProfile): CtaExtensionBlock
    {
        $ctaExtension = new CtaExtensionBlock;

        // get maximum of timing and extra timing pixel clock
        $pixelClock = max($infotainmentProfile->timing->pixel_clock, $infotainmentProfile->extraTiming->pixel_clock ?? 0);
        // if hdmi interface is selected add hdmi extension
        if ($infotainmentProfile->interface === DisplayInterface::HDMI_A || $infotainmentProfile->interface === DisplayInterface::HDMI_B) {
            // HDMI vendor specific data block must be added
            $ctaExtension->addDataBlock(new HdmiVendorSpecificDataBlock(
                // round up the pixel clock divided by 5 as max TMDS clock
                (int) ceil($pixelClock / 5)
            ));
        }

        // add vendor specific data blocks
        $vendorId = str_pad(Config::string('app.vendor_id'), 6, '0', STR_PAD_LEFT);

        $vendorBlock1 = array_map(fn (string $hex) => (int) hexdec($hex), $infotainmentProfile->vendor_block_1);
        $vendorBlock2 = array_map(fn (string $hex) => (int) hexdec($hex), $infotainmentProfile->vendor_block_2);
        $vendorBlock3 = array_map(fn (string $hex) => (int) hexdec($hex), $infotainmentProfile->vendor_block_3);

        if (count($vendorBlock1) > 0) {
            $ctaExtension->addDataBlock(new VendorSpecificDataBlock($vendorId, $vendorBlock1));
        }

        if (count($vendorBlock2) > 0) {
            $ctaExtension->addDataBlock(new VendorSpecificDataBlock($vendorId, $vendorBlock2));
        }

        if (count($vendorBlock3) > 0) {
            $ctaExtension->addDataBlock(new VendorSpecificDataBlock($vendorId, $vendorBlock3));
        }

        return $ctaExtension;
    }

    /**
     * @return array<int> array of bytes of built edid
     */
    public static function build(Infotainment $infotainment, InfotainmentProfile $infotainmentProfile): array
    {
        $baseEdid = self::buildBaseEdid($infotainment, $infotainmentProfile, 1);
        $ctaExtension = self::buildCtaExtension($infotainmentProfile);

        return array_merge(
            $baseEdid->toBytes(),
            $ctaExtension->toBytes()
        );
    }
}
