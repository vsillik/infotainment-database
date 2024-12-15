<?php

namespace App\Http\Requests;

use App\ColorBitDepth;
use App\DisplayInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class InfotainmentProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
                'integer',
            ],
            'horizontal_sync_width' => [
                'integer',
            ],
            'horizontal_image_size' => [
                'integer',
            ],
            'horizontal_border' => [
                'integer',
            ],
            'vertical_blank' => [
                'required',
                'integer',
            ],
            'vertical_front_porch' => [
                'integer',
            ],
            'vertical_sync_width' => [
                'integer',
            ],
            'vertical_image_size' => [
                'integer',
            ],
            'vertical_border' => [
                'integer',
            ],
            'extra_pixel_clock' => [
                'required_if_accepted:extra_timing_block',
                'numeric',
            ],
            'extra_horizontal_pixels' => [
                'required_if_accepted:extra_timing_block',
                'integer'
            ],
            'extra_vertical_lines' => [
                'required_if_accepted:extra_timing_block',
                'integer'
            ],
            'extra_horizontal_blank' => [
                'required_if_accepted:extra_timing_block',
                'integer',
            ],
            'extra_horizontal_front_porch' => [
                'integer',
            ],
            'extra_horizontal_sync_width' => [
                'integer',
            ],
            'extra_horizontal_image_size' => [
                'integer',
            ],
            'extra_horizontal_border' => [
                'integer',
            ],
            'extra_vertical_blank' => [
                'required_if_accepted:extra_timing_block',
                'integer',
            ],
            'extra_vertical_front_porch' => [
                'integer',
            ],
            'extra_vertical_sync_width' => [
                'integer',
            ],
            'extra_vertical_image_size' => [
                'integer',
            ],
            'extra_vertical_border' => [
                'integer',
            ],
        ];
    }
}
