<?php

namespace App\Models;

use App\ColorBitDepth;
use App\DisplayInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string|null vendor_block_1
 * @property string|null vendor_block_2
 * @property string|null vendor_block_3
 */
class InfotainmentProfile extends Model
{

    protected $casts = [
        'color_bit_depth' => ColorBitDepth::class,
        'interface' => DisplayInterface::class,
    ];

    public function infotainment(): BelongsTo
    {
        return $this->belongsTo(Infotainment::class);
    }

    public function timing(): BelongsTo
    {
        return $this->belongsTo(InfotainmentProfileTimingBlock::class, 'timing_block_id');
    }
}
