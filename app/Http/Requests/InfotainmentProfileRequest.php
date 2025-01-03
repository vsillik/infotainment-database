<?php

namespace App\Http\Requests;

use App\ColorBitDepth;
use App\DisplayInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class InfotainmentProfileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'color_bit_depth' => [
                'required',
                new Enum(ColorBitDepth::class)
            ],
            'interface' => [
                'required',
                new Enum(DisplayInterface::class)
            ],
            'horizontal_size' => [
                'required',
                'integer'
            ],
            'vertical_size' => [
                'required',
                'integer'
            ],
            'hw_version' => [
                'required',
                'max:3'
            ],
            'sw_version' => [
                'required',
                'max:4'
            ],
            'vendor_block_1' => [
                'max:31',
            ],
            'vendor_block_2' => [
                'max:31',
            ],
            'vendor_block_3' => [
                'max:31',
            ],
            'pixel_clock' => [
                'required',
                'numeric',
            ],
            'horizontal_pixels' => [
                'required',
                'integer'
            ],
            'vertical_lines' => [
                'required',
                'integer'
            ],
            'horizontal_blank' => [
                'required',
                'integer',
            ],
            'horizontal_front_porch' => [
                'nullable',
                'integer',
            ],
            'horizontal_sync_width' => [
                'nullable',
                'integer',
            ],
            'horizontal_image_size' => [
                'nullable',
                'integer',
            ],
            'horizontal_border' => [
                'nullable',
                'integer',
            ],
            'vertical_blank' => [
                'required',
                'integer',
            ],
            'vertical_front_porch' => [
                'nullable',
                'integer',
            ],
            'vertical_sync_width' => [
                'nullable',
                'integer',
            ],
            'vertical_image_size' => [
                'nullable',
                'integer',
            ],
            'vertical_border' => [
                'nullable',
                'integer',
            ],
            'extra_pixel_clock' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'numeric',
            ],
            'extra_horizontal_pixels' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer'
            ],
            'extra_vertical_lines' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer'
            ],
            'extra_horizontal_blank' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
            ],
            'extra_horizontal_front_porch' => [
                'nullable',
                'integer',
            ],
            'extra_horizontal_sync_width' => [
                'nullable',
                'integer',
            ],
            'extra_horizontal_image_size' => [
                'nullable',
                'integer',
            ],
            'extra_horizontal_border' => [
                'nullable',
                'integer',
            ],
            'extra_vertical_blank' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
            ],
            'extra_vertical_front_porch' => [
                'nullable',
                'integer',
            ],
            'extra_vertical_sync_width' => [
                'nullable',
                'integer',
            ],
            'extra_vertical_image_size' => [
                'nullable',
                'integer',
            ],
            'extra_vertical_border' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
