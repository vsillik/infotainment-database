<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer id
 * @property float pixel_clock
 * @property integer horizontal_pixels
 * @property integer vertical_lines
 * @property integer horizontal_blank
 * @property integer horizontal_front_porch
 * @property integer horizontal_sync_width
 * @property integer horizontal_image_size
 * @property integer horizontal_border
 * @property integer vertical_blank
 * @property integer vertical_front_porch
 * @property integer vertical_sync_width
 * @property integer vertical_image_size
 * @property integer vertical_border
 * @property boolean signal_horizontal_sync_positive
 * @property boolean signal_vertical_sync_positive
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

    public function infotainmentProfile(): HasOne
    {
       return $this->hasOne(InfotainmentProfile::class, 'timing_block_id');
    }

}
