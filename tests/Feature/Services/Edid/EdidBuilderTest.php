<?php

namespace Services\Edid;

use App\Enums\ColorBitDepth;
use App\Enums\DisplayInterface;
use App\Models\Infotainment;
use App\Models\InfotainmentManufacturer;
use App\Models\InfotainmentProfile;
use App\Models\InfotainmentProfileTimingBlock;
use App\Models\SerializerManufacturer;
use App\Services\Edid\EdidBuilder;
use Illuminate\Support\Carbon;
use Mockery;
use Tests\TestCase;

class EdidBuilderTest extends TestCase
{
    private static function mockInfotainment(InfotainmentManufacturer $infotainmentManufacturer, SerializerManufacturer $serializerManufacturer): Infotainment
    {
        /** @var Mockery\LegacyMockInterface&Mockery\MockInterface&Infotainment $infotainment */
        $infotainment = Mockery::mock(Infotainment::class)->makePartial();
        $infotainment->shouldReceive('getRelationValue')->with('infotainmentManufacturer')->andReturn($infotainmentManufacturer);
        $infotainment->shouldReceive('getRelationValue')->with('serializerManufacturer')->andReturn($serializerManufacturer);

        return $infotainment;
    }

    private static function mockInfotainmentProfile(InfotainmentProfileTimingBlock $timingBlock, int $profileNumber, Carbon $updatedAt): InfotainmentProfile
    {
        /** @var Mockery\MockInterface&Mockery\LegacyMockInterface&InfotainmentProfile $profile */
        $profile = Mockery::mock(InfotainmentProfile::class)->makePartial();
        $profile->shouldReceive('getRelationValue')->with('timing')->andReturn($timingBlock);
        $profile->shouldReceive('getAttribute')->with('profile_number')->andReturn($profileNumber);
        $profile->shouldReceive('getAttribute')->with('updated_at')->andReturn($updatedAt);

        return $profile;
    }

    /**
     * @return array{0: Infotainment, 1: InfotainmentProfile, 2: array<int>}
     */
    private static function dataForFirstProfile(): array
    {
        $infotainmentManufacturer = new InfotainmentManufacturer;
        $infotainmentManufacturer->name = 'Volkswagen';

        $serializerManufacturer = new SerializerManufacturer;
        $serializerManufacturer->id = 'TXN';
        $serializerManufacturer->name = 'Texas Instruments';

        $infotainment = self::mockInfotainment($infotainmentManufacturer, $serializerManufacturer);
        $infotainment->product_id = '0949';
        $infotainment->model_year = 2024;
        $infotainment->part_number = '14A.919.606.A';

        $timing = new InfotainmentProfileTimingBlock;
        $timing->pixel_clock = 178.42;
        $timing->horizontal_pixels = 2240;
        $timing->horizontal_blank = 96;
        $timing->horizontal_front_porch = 28;
        $timing->horizontal_sync_width = 28;
        $timing->horizontal_image_size = 332;
        $timing->horizontal_border = 0;
        $timing->vertical_lines = 1260;
        $timing->vertical_blank = 13;
        $timing->vertical_front_porch = 6;
        $timing->vertical_sync_width = 2;
        $timing->vertical_image_size = 187;
        $timing->vertical_border = 0;
        $timing->signal_horizontal_sync_positive = false;
        $timing->signal_vertical_sync_positive = false;

        /** @var Carbon $updatedAt */
        $updatedAt = Carbon::create(2025, 1, 12, 12, 30);

        $profile = self::mockInfotainmentProfile($timing, 2, $updatedAt);
        $profile->color_bit_depth = ColorBitDepth::BIT_8;
        $profile->interface = DisplayInterface::HDMI_A;
        $profile->horizontal_size = 33;
        $profile->vertical_size = 19;
        $profile->is_ycrcb_4_4_4 = false;
        $profile->is_ycrcb_4_2_2 = false;
        $profile->is_srgb = false;
        $profile->is_continuous_frequency = false;
        $profile->hw_version = '030';
        $profile->sw_version = 'A030';
        $profile->vendor_block_1 = [
            '44', '51', '01', '10', 'FF', '01', '00', '01', '00', '03', '02', '64',
        ];
        $profile->vendor_block_2 = [
            '44', '51', '02', '10', '02', '02', '01', '02',
        ];

        return [
            $infotainment,
            $profile,
            [
                0x00, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0x00, 0x53, 0x0E, 0x49, 0x09, 0xCE, 0x14, 0x14, 0x95,
                0xFF, 0x22, 0x01, 0x04, 0xA2, 0x21, 0x13, 0x78, 0x02, 0xEC, 0x18, 0xA3, 0x54, 0x46, 0x98, 0x25,
                0x0F, 0x48, 0x4C, 0x00, 0x00, 0x00, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01,
                0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0xB2, 0x45, 0xC0, 0x60, 0x80, 0xEC, 0x0D, 0x40, 0x1C, 0x1C,
                0x62, 0x00, 0x4C, 0xBB, 0x10, 0x00, 0x00, 0x18, 0x00, 0x00, 0x00, 0xFC, 0x00, 0x31, 0x34, 0x41,
                0x2E, 0x39, 0x31, 0x39, 0x2E, 0x36, 0x30, 0x36, 0x2E, 0x41, 0x00, 0x00, 0x00, 0xFE, 0x00, 0x48,
                0x30, 0x33, 0x30, 0x53, 0x41, 0x30, 0x33, 0x30, 0x50, 0x30, 0x32, 0x0A, 0x00, 0x00, 0x00, 0x10,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x01, 0x8F,
                0x02, 0x03, 0x28, 0x00, 0x67, 0x03, 0x0C, 0x00, 0x00, 0x00, 0x00, 0x24, 0x6F, 0x00, 0x00, 0x00,
                0x44, 0x51, 0x01, 0x10, 0xFF, 0x01, 0x00, 0x01, 0x00, 0x03, 0x02, 0x64, 0x6B, 0x00, 0x00, 0x00,
                0x44, 0x51, 0x02, 0x10, 0x02, 0x02, 0x01, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xA1,
            ],
        ];
    }

    /**
     * @return array{0: Infotainment, 1: InfotainmentProfile, 2: array<int>}
     */
    private static function dataForSecondProfile(): array
    {
        $infotainmentManufacturer = new InfotainmentManufacturer;
        $infotainmentManufacturer->name = 'Unknown manufacturer';

        $serializerManufacturer = new SerializerManufacturer;
        $serializerManufacturer->id = 'TXN';
        $serializerManufacturer->name = 'Texas Instruments';

        $infotainment = self::mockInfotainment($infotainmentManufacturer, $serializerManufacturer);
        $infotainment->product_id = '0949';
        $infotainment->model_year = 2022;
        $infotainment->part_number = '14A.919.603';

        $timing = new InfotainmentProfileTimingBlock;
        $timing->pixel_clock = 92.25;
        $timing->horizontal_pixels = 1560;
        $timing->horizontal_blank = 156;
        $timing->horizontal_front_porch = 124;
        $timing->horizontal_sync_width = 24;
        $timing->horizontal_image_size = 227;
        $timing->horizontal_border = 0;
        $timing->vertical_lines = 878;
        $timing->vertical_blank = 18;
        $timing->vertical_front_porch = 10;
        $timing->vertical_sync_width = 2;
        $timing->vertical_image_size = 127;
        $timing->vertical_border = 0;
        $timing->signal_horizontal_sync_positive = false;
        $timing->signal_vertical_sync_positive = false;

        /** @var Carbon $updatedAt */
        $updatedAt = Carbon::create(2024, 7, 25, 8, 11);

        $profile = self::mockInfotainmentProfile($timing, 1, $updatedAt);
        $profile->color_bit_depth = ColorBitDepth::BIT_8;
        $profile->interface = DisplayInterface::HDMI_A;
        $profile->horizontal_size = 23;
        $profile->vertical_size = 13;
        $profile->is_ycrcb_4_4_4 = false;
        $profile->is_ycrcb_4_2_2 = false;
        $profile->is_srgb = false;
        $profile->is_continuous_frequency = false;
        $profile->hw_version = 'H20';
        $profile->sw_version = 'B010';
        $profile->vendor_block_1 = [
            '44', '51', '01', '10', 'FF', '01', '00', '01', '00', '02', '01', '64',
        ];
        $profile->vendor_block_2 = [
            '44', '51', '02', '10', '02', '02', '01', '02',
        ];

        return [
            $infotainment,
            $profile,
            [
                0x00, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0xFF, 0x00, 0x53, 0x0E, 0x49, 0x09, 0x7B, 0xBB, 0x7B, 0x8F,
                0xFF, 0x20, 0x01, 0x04, 0xA2, 0x17, 0x0D, 0x78, 0x02, 0xEC, 0x18, 0xA3, 0x54, 0x46, 0x98, 0x25,
                0x0F, 0x48, 0x4C, 0x00, 0x00, 0x00, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x01,
                0x01, 0x01, 0x01, 0x01, 0x01, 0x01, 0x09, 0x24, 0x18, 0x9C, 0x60, 0x6E, 0x12, 0x30, 0x7C, 0x18,
                0xA2, 0x00, 0xE3, 0x7F, 0x00, 0x00, 0x00, 0x18, 0x00, 0x00, 0x00, 0xFC, 0x00, 0x31, 0x34, 0x41,
                0x2E, 0x39, 0x31, 0x39, 0x2E, 0x36, 0x30, 0x33, 0x0A, 0x20, 0x00, 0x00, 0x00, 0xFE, 0x00, 0x48,
                0x48, 0x32, 0x30, 0x53, 0x42, 0x30, 0x31, 0x30, 0x50, 0x30, 0x31, 0x0A, 0x00, 0x00, 0x00, 0x10,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x01, 0x17,
                0x02, 0x03, 0x28, 0x00, 0x67, 0x03, 0x0C, 0x00, 0x00, 0x00, 0x00, 0x13, 0x6F, 0x00, 0x00, 0x00,
                0x44, 0x51, 0x01, 0x10, 0xFF, 0x01, 0x00, 0x01, 0x00, 0x02, 0x01, 0x64, 0x6B, 0x00, 0x00, 0x00,
                0x44, 0x51, 0x02, 0x10, 0x02, 0x02, 0x01, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00,
                0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xB4,
            ],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app' => [
                'vendor_id' => '000000',
                'chromaticity' => [
                    'red_x' => '0.640',
                    'red_y' => '0.330',
                    'green_x' => '0.276',
                    'green_y' => '0.594',
                    'blue_x' => '0.145',
                    'blue_y' => '0.060',
                    'white_x' => '0.283',
                    'white_y' => '0.297',
                ],
            ],
        ]);
    }

    public function test_build_first_profile(): void
    {
        [$infotainment, $infotainmentProfile, $expectedBytes] = self::dataForFirstProfile();
        $result = EdidBuilder::build($infotainment, $infotainmentProfile);

        $this->assertEquals($expectedBytes, array_values($result));

    }

    public function test_build_second_profile(): void
    {
        [$infotainment, $infotainmentProfile, $expectedBytes] = self::dataForSecondProfile();
        $result = EdidBuilder::build($infotainment, $infotainmentProfile);

        $this->assertEquals($expectedBytes, array_values($result));

    }
}
