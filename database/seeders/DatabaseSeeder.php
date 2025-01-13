<?php

namespace Database\Seeders;

use App\DisplayInterface;
use App\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createUsers();
        $this->createInfotainmentManufacturers();
        $this->createSerializerManufacturers();
        $this->createInfotainments();
        $this->createInfotainmentProfiles();
        $this->infotainmentProfileUserAssignment();
    }

    private function createUsers(): void
    {
        for ($i = 0; $i < 200; $i++) {
            info(sprintf('INSERT INTO users (%s, %s, %s, %s, %s, %s, %s) VALUES ("%s", "%s", "%s", %d, %d, "%s", "%s");',
                'name',
                'email',
                'password',
                'role',
                'is_approved',
                'created_at',
                'updated_at',
                Str::random(255),
                Str::random(255),
                Hash::make(Str::random(72)),
                UserRole::CUSTOMER->value,
                true,
                now(),
                now()));

            info(sprintf('INSERT INTO password_reset_tokens (%s, %s, %s) VALUES ("%s", "%s", "%s");',
                'email',
                'token',
                'created_at',
                Str::random(255),
                Str::random(255),
                now()));

            info(sprintf('INSERT INTO sessions (%s, %s, %s, %s, %s, %s) VALUES ("%s", %d, "%s", "%s", "%s", %d);',
                'id',
                'user_id',
                'ip_address',
                'user_agent',
                'payload',
                'last_activity',
                Str::random(255),
                0,
                Str::random(45),
                Str::random(255),
                Str::random(1024),
                1234));
        }
    }

    private function createInfotainmentManufacturers(): void
    {
        for ($i = 0; $i < 100; $i++) {
            info(sprintf('INSERT INTO infotainment_manufacturers (%s) VALUES ("%s");',
                'name',
                Str::random(250) . $i));
        }
    }

    private function createSerializerManufacturers(): void
    {
        for ($i = 0; $i < 100; $i++) {
            info(sprintf('INSERT INTO serializer_manufacturers (%s, %s) VALUES ("%s", "%s");',
                'id',
                'name',
                str_pad($i, 3, '0', STR_PAD_LEFT),
                Str::random(250) . $i));
        }
    }

    private function createInfotainments(): void
    {
        for ($i = 0; $i < 1500; $i++) {
            info(sprintf('INSERT INTO infotainments (%s, %s, %s, %s, %s, %s, %s, %s) VALUES (%d, "%s", "%s", %d, "%s", "%s", "%s", "%s");',
                'infotainment_manufacturer_id',
                'serializer_manufacturer_id',
                'product_id',
                'model_year',
                'part_number',
                'compatible_platforms',
                'internal_code',
                'internal_notes',
                1,
                '000',
                str_pad($i, 4, '0', STR_PAD_LEFT),
                3000,
                'XXX.XXX.XXX.X',
                Str::random(1024),
                Str::random(150),
                Str::random(1024)));
        }
    }

    private function createInfotainmentProfiles(): void
    {
        for ($i = 0; $i < 1500; $i++) {
            for ($j = 0; $j < 100; $j++) {
                info(sprintf('INSERT INTO infotainment_profile_timing_blocks (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d);',
                    'pixel_clock',
                    'horizontal_pixels',
                    'horizontal_blank',
                    'horizontal_front_porch',
                    'horizontal_sync_width',
                    'horizontal_image_size',
                    'horizontal_border',
                    'vertical_lines',
                    'vertical_blank',
                    'vertical_front_porch',
                    'vertical_sync_width',
                    'vertical_image_size',
                    'vertical_border',
                    'signal_horizontal_sync_positive',
                    'signal_vertical_sync_positive',
                    655,
                    4095,
                    4095,
                    1023,
                    1023,
                    4095,
                    255,
                    4095,
                    4095,
                    63,
                    63,
                    4095,
                    255,
                    true,
                    true));

                // extra timing
                info(sprintf('INSERT INTO infotainment_profile_timing_blocks (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d);',
                    'pixel_clock',
                    'horizontal_pixels',
                    'horizontal_blank',
                    'horizontal_front_porch',
                    'horizontal_sync_width',
                    'horizontal_image_size',
                    'horizontal_border',
                    'vertical_lines',
                    'vertical_blank',
                    'vertical_front_porch',
                    'vertical_sync_width',
                    'vertical_image_size',
                    'vertical_border',
                    'signal_horizontal_sync_positive',
                    'signal_vertical_sync_positive',
                    655,
                    4095,
                    4095,
                    1023,
                    1023,
                    4095,
                    255,
                    4095,
                    4095,
                    63,
                    63,
                    4095,
                    255,
                    true,
                    true));

                info(sprintf('INSERT INTO infotainment_profiles (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) VALUES (%d, %d, %d, %d, %d, "%s", %d, %d, %d, %d, %d, %d, %d, "%s", "%s", "%s", "%s");',
                    'infotainment_id',
                    'timing_block_id',
                    'extra_timing_block_id',
                    'is_approved',
                    'color_bit_depth',
                    'interface',
                    'horizontal_size',
                    'vertical_size',
                    'is_ycrcb_4_4_4',
                    'is_ycrcb_4_2_2',
                    'is_srgb',
                    'is_continuous_frequency',
                    'hw_version',
                    'sw_version',
                    'vendor_block_1',
                    'vendor_block_2',
                    'vendor_block_3',
                    1,
                    1,
                    1,
                    false,
                    8,
                    DisplayInterface::DVI->value,
                    255,
                    255,
                    true,
                    true,
                    true,
                    true,
                    'XXX',
                    'XXXX',
                    Str::random(31),
                    Str::random(31),
                    Str::random(31)));
            }
        }
    }

    private function infotainmentProfileUserAssignment(): void
    {
        for ($i = 0; $i < 1500; $i++) {
            for ($j = 0; $j < 200; $j++) {
                info(sprintf('INSERT INTO infotainment_user (%s, %s) VALUES (%d, %d);',
                    'infotainment_id',
                    'user_id',
                    $i + 1,
                    $j + 1));
            }
        }
    }
}
