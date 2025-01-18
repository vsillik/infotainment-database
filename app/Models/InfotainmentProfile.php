<?php

namespace App\Models;

use App\ColorBitDepth;
use App\DisplayInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property integer id
 * @property integer infotainment_id
 * @property integer timing_block_id
 * @property integer|null extra_timing_block_id
 * @property bool is_approved
 * @property int color_bit_depth
 * @property string interface
 * @property int horizontal_size
 * @property int vertical_size
 * @property bool is_ycrcb_4_4_4
 * @property bool is_ycrcb_4_2_2
 * @property bool is_srgb
 * @property bool is_continuous_frequency
 * @property string hw_version
 * @property string sw_version
 * @property array<string> vendor_block_1 array of bytes in hex (2 hex chars per byte)
 * @property array<string> vendor_block_2 array of bytes in hex (2 hex chars per byte)
 * @property array<string> vendor_block_3 array of bytes in hex (2 hex chars per byte)
 * @property-read int profile_number dynamically calculated number of profile for assigned infotainment
 * @property Infotainment $infotainment
 * @property ?InfotainmentProfileTimingBlock $timing
 * @property ?InfotainmentProfileTimingBlock $extraTiming
 */
class InfotainmentProfile extends Model
{

    // get all profile numbers for a specific infotainment (map profile id => profile number) - static method
    // get profile number for this profile

    protected $casts = [
        'color_bit_depth' => ColorBitDepth::class,
        'interface' => DisplayInterface::class,
    ];

    protected static function convertVendorBlockFromBin(?string $value): array
    {
        if ($value === null) {
            return [];
        }

        $hex = bin2hex($value);

        return str_split($hex, 2);
    }

    protected function convertVendorBlockToBin(array $hexValues): ?string
    {
        if ($hexValues === []) {
            return null;
        }

        if (count($hexValues) > 28) {
            throw new \InvalidArgumentException('The vendor block can have only up to 28 bytes');
        }

        $hex = implode('', $hexValues);

        return hex2bin($hex);
    }


    protected function vendorBlock1(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::convertVendorBlockFromBin($value),
            set: fn (array $hexValues) => self::convertVendorBlockToBin($hexValues),
        );
    }

    protected function vendorBlock2(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::convertVendorBlockFromBin($value),
            set: fn (array $hexValues) => self::convertVendorBlockToBin($hexValues),
        );
    }

    protected function vendorBlock3(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::convertVendorBlockFromBin($value),
            set: fn (array $hexValues) => self::convertVendorBlockToBin($hexValues),
        );
    }

    protected function profileNumber(): Attribute
    {
        return Attribute::get(
            fn () => DB::table('infotainment_profiles')
                ->where('infotainment_id', $this->infotainment_id)
                ->where('id', '<=', $this->id)
                ->count()
        );
    }

    public function infotainment(): BelongsTo
    {
        return $this->belongsTo(Infotainment::class);
    }

    public function timing(): BelongsTo
    {
        return $this->belongsTo(InfotainmentProfileTimingBlock::class, 'timing_block_id');
    }

    public function extraTiming(): BelongsTo
    {
        return $this->belongsTo(InfotainmentProfileTimingBlock::class, 'extra_timing_block_id');
    }

    /**
     * Returns map of profile ids to profile number for specific infotainment
     * @return Collection of id to key mapping
     */
    public static function mapIdsToProfileNumbers(Infotainment $infotainment): Collection
    {
        $ids = DB::table('infotainment_profiles')
            ->select('id')
            ->where('infotainment_id', $infotainment->id)
            ->orderBy('id')
            ->get();

        return $ids->mapWithKeys(fn (\stdClass $item, int $index) => [$item->id => $index + 1]);
    }
}
