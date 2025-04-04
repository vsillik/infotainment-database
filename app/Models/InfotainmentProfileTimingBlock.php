<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder<InfotainmentProfileTimingBlock>
 *
 * @property int $id
 * @property float $pixel_clock
 * @property int $horizontal_pixels
 * @property int $horizontal_blank
 * @property int $horizontal_front_porch
 * @property int $horizontal_sync_width
 * @property int $horizontal_image_size
 * @property ?int $horizontal_border
 * @property int $vertical_lines
 * @property int $vertical_blank
 * @property int $vertical_front_porch
 * @property int $vertical_sync_width
 * @property int $vertical_image_size
 * @property ?int $vertical_border
 * @property bool $signal_horizontal_sync_positive
 * @property bool $signal_vertical_sync_positive
 * @property InfotainmentProfile $infotainmentProfile
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class InfotainmentProfileTimingBlock extends Model
{
    public $fillable = [
        'pixel_clock',
        'horizontal_pixels',
        'vertical_lines',
        'horizontal_blank',
        'horizontal_front_porch',
        'horizontal_sync_width',
        'horizontal_image_size',
        'horizontal_border',
        'vertical_blank',
        'vertical_front_porch',
        'vertical_sync_width',
        'vertical_image_size',
        'vertical_border',
        'signal_horizontal_sync_positive',
        'signal_vertical_sync_positive',
    ];

    protected $casts = [
        'pixel_clock' => 'float',
        'signal_horizontal_sync_positive' => 'boolean',
        'signal_vertical_sync_positive' => 'boolean',
    ];

    /**
     * @return HasOne<InfotainmentProfile, $this>
     */
    public function infotainmentProfile(): HasOne
    {
        return $this->hasOne(InfotainmentProfile::class, 'timing_block_id');
    }
}
