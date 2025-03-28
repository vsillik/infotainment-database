<?php

namespace App\Http\Requests;

use App\Enums\ColorBitDepth;
use App\Enums\DisplayInterface;
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
                new Enum(ColorBitDepth::class),
            ],
            'interface' => [
                'required',
                new Enum(DisplayInterface::class),
            ],
            'horizontal_size' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],
            'vertical_size' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],
            'hw_version' => [
                'required',
                'regex:/^[a-z0-9]{1,3}$/i',
            ],
            'sw_version' => [
                'required',
                'regex:/^[a-z0-9]{1,4}$/i',
            ],
            'vendor_block_1' => [
                'array',
                'max:28',
            ],
            'vendor_block_1.*' => [
                'required',
                'regex:/^[a-f0-9]{1,2}$/i',
            ],
            'vendor_block_2' => [
                'array',
                'max:28',
            ],
            'vendor_block_2.*' => [
                'required',
                'regex:/^[a-f0-9]{1,2}$/i',
            ],
            'vendor_block_3' => [
                'array',
                'max:28',
            ],
            'vendor_block_3.*' => [
                'required',
                'regex:/^[a-f0-9]{1,2}$/i',
            ],
            'pixel_clock' => [
                'required',
                'numeric',
                'min:0.01',
                'max:655.35',
            ],
            'horizontal_pixels' => [
                'required',
                'integer',
                'min:0',
                'max:4095',
            ],
            'horizontal_blank' => [
                'required',
                'integer',
                'min:0',
                'max:4095',
            ],
            'horizontal_front_porch' => [
                'nullable',
                'integer',
                'min:0',
                'max:1023',
            ],
            'horizontal_sync_width' => [
                'nullable',
                'integer',
                'min:0',
                'max:1023',
            ],
            'horizontal_image_size' => [
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'horizontal_border' => [
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
            'vertical_lines' => [
                'required',
                'integer',
                'min:0',
                'max:4095',
            ],
            'vertical_blank' => [
                'required',
                'integer',
                'min:0',
                'max:4095',
            ],
            'vertical_front_porch' => [
                'nullable',
                'integer',
                'min:0',
                'max:63',
            ],
            'vertical_sync_width' => [
                'nullable',
                'integer',
                'min:0',
                'max:63',
            ],
            'vertical_image_size' => [
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'vertical_border' => [
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
            'extra_pixel_clock' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'numeric',
                'min:0.01',
                'max:655.35',
            ],
            'extra_horizontal_pixels' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_horizontal_blank' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_horizontal_front_porch' => [
                'nullable',
                'integer',
                'min:0',
                'max:1023',
            ],
            'extra_horizontal_sync_width' => [
                'nullable',
                'integer',
                'min:0',
                'max:1023',
            ],
            'extra_horizontal_image_size' => [
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_horizontal_border' => [
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
            'extra_vertical_lines' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_vertical_blank' => [
                'required_if_accepted:extra_timing_block',
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_vertical_front_porch' => [
                'nullable',
                'integer',
                'min:0',
                'max:63',
            ],
            'extra_vertical_sync_width' => [
                'nullable',
                'integer',
                'min:0',
                'max:63',
            ],
            'extra_vertical_image_size' => [
                'nullable',
                'integer',
                'min:0',
                'max:4095',
            ],
            'extra_vertical_border' => [
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        $requiredMessage = 'This field is required when extra timing block is enabled';

        return [
            'extra_pixel_clock.required_if_accepted' => $requiredMessage,
            'extra_horizontal_pixels.required_if_accepted' => $requiredMessage,
            'extra_horizontal_blank.required_if_accepted' => $requiredMessage,
            'extra_vertical_lines.required_if_accepted' => $requiredMessage,
            'extra_vertical_blank.required_if_accepted' => $requiredMessage,
        ];
    }
}
