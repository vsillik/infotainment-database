@php
    use App\ColorBitDepth;
    use App\DisplayInterface;
@endphp

<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        @switch($mode)
            @case('edit')
                Edit infotainment profile
                @break
            @case('approve')
                Approving infotainment profile
                @break
            @default
                Create infotainment profile
        @endswitch
    </x-slot:title>

    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Infotainment manufacturer</th>
                <td>{{ $infotainment->infotainmentManufacturer->name }}</td>
            </tr>
            <tr>
                <th>Serializer manufacturer</th>
                <td>{{ $infotainment->serializerManufacturer->name }}</td>
            </tr>
            <tr>
                <th>Product ID</th>
                <td>{{ $infotainment->product_id }}</td>
            </tr>
            <tr>
                <th>Model year</th>
                <td>{{ $infotainment->model_year }}</td>
            </tr>
            <tr>
                <th>Part number</th>
                <td>{{ $infotainment->part_number }}</td>
            </tr>
        </table>
    </div>

    <form action="
        @switch($mode)
            @case('edit')
            @case('approve')
                {{ route('infotainments.profiles.update', [$infotainment, $infotainmentProfile]) }}
                @break
            @default
                {{ route('infotainments.profiles.store', $infotainment) }}
        @endswitch
        "
          method="POST"
          novalidate
    >
        @csrf
        @if($mode === 'edit' || $mode === 'approve')
            @method('PATCH')
        @endif

        @if($mode === 'approve')
            <input type="hidden" name="approving_infotainment_profile" value="1">
        @endif

        <x-forms.errors-alert :errors="$errors"/>

        @php
            $baseInformationHasError = $errors->hasAny([
                'color_bit_depth',
                'interface',
                'horizontal_size',
                'vertical_size',
            ]);
            $additionalInformationHasError = $errors->hasAny([
                'hw_version',
                'sw_version',
                'vendor_block_1.*',
                'vendor_block_2.*',
                'vendor_block_3.*',
            ]);
            $timingHasError = $errors->hasAny([
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
             ]);
            $extraTimingHasError = $errors->hasAny([
                'extra_pixel_clock',
                'extra_horizontal_pixels',
                'extra_horizontal_blank',
                'extra_horizontal_front_porch',
                'extra_horizontal_sync_width',
                'extra_horizontal_image_size',
                'extra_horizontal_border',
                'extra_vertical_lines',
                'extra_vertical_blank',
                'extra_vertical_front_porch',
                'extra_vertical_sync_width',
                'extra_vertical_image_size',
                'extra_vertical_border',
             ]);;
        @endphp

        <ul class="nav nav-tabs" id="profile-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    @class([
                        'nav-link',
                        'active',
                        'text-danger' => $baseInformationHasError,
                    ])
                    id="base-tab" data-bs-toggle="tab" data-bs-target="#base-tab-pane"
                    type="button" role="tab" aria-controls="base-tab-pane" aria-selected="true">
                    Base information
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    @class([
                        'nav-link',
                        'text-danger' => $additionalInformationHasError,
                    ])
                    id="additional-tab" data-bs-toggle="tab"
                    data-bs-target="#additional-tab-pane" type="button" role="tab"
                    aria-controls="additional-tab-pane" aria-selected="false">
                    Additional information
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    @class([
                        'nav-link',
                        'text-danger' => $timingHasError,
                    ])
                    id="timing-tab" data-bs-toggle="tab" data-bs-target="#timing-tab-pane"
                    type="button" role="tab" aria-controls="timing-tab-pane" aria-selected="false">
                    Timing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    @class([
                        'nav-link',
                        'text-danger' => $extraTimingHasError,
                    ])
                    id="extra-timing-tab" data-bs-toggle="tab"
                    data-bs-target="#extra-timing-tab-pane" type="button" role="tab"
                    aria-controls="extra-timing-tab-pane" aria-selected="false">
                    Extra Timing
                </button>
            </li>
        </ul>

        <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="base-tab-pane" role="tabpanel" aria-labelledby="base-tab"
                 tabindex="0">
                <x-forms.select
                    name="color_bit_depth"
                    label="Color bit depth"
                    :options="$colorBitDepths"
                    :defaultValue="($infotainmentProfile->color_bit_depth ?? ColorBitDepth::BIT_8)->value"
                    required="true"
                />

                <x-forms.select
                    name="interface"
                    label="Interface"
                    :options="$interfaces"
                    :defaultValue="($infotainmentProfile->interface ?? DisplayInterface::HDMI_A)->value"
                    required="true"
                />

                <x-forms.input
                    name="horizontal_size"
                    type="number"
                    label="Horizontal size"
                    :defaultValue="$infotainmentProfile->horizontal_size"
                    required="true"
                    suffixText="cm"
                    extraText="The value must be between 1-255."
                />

                <x-forms.input
                    name="vertical_size"
                    type="number"
                    label="Vertical size"
                    :defaultValue="$infotainmentProfile->vertical_size"
                    required="true"
                    suffixText="cm"
                    extraText="The value must be between 1-255."
                />

                <x-forms.checkbox
                    name="is_ycrcb_4_4_4"
                    label="YCrCb 4:4:4"
                    :isCheckedByDefault="$infotainmentProfile->is_ycrcb_4_4_4"
                />

                <x-forms.checkbox
                    name="is_ycrcb_4_2_2"
                    label="YCrCb 4:2:2"
                    :isCheckedByDefault="$infotainmentProfile->is_ycrcb_4_2_2"
                />

                <x-forms.checkbox
                    name="is_srgb"
                    label="sRGB"
                    :isCheckedByDefault="$infotainmentProfile->is_srgb"
                />

                <x-forms.checkbox
                    name="is_continuous_frequency"
                    label="Continuous frequency"
                    :isCheckedByDefault="$infotainmentProfile->is_continuous_frequency"
                />
            </div>
            <div class="tab-pane fade" id="additional-tab-pane" role="tabpanel" aria-labelledby="additional-tab"
                 tabindex="0">

                <x-forms.input
                    name="hw_version"
                    label="HW version"
                    :defaultValue="$infotainmentProfile->hw_version"
                    required="true"
                    extraText="Must be in range 000-999 (3 numbers). If you enter less than 3 numbers, leading 0s will be added automatically."
                />

                <x-forms.input
                    name="sw_version"
                    label="SW version"
                    :defaultValue="$infotainmentProfile->sw_version"
                    required="true"
                    extraText="Must be in range 0000-9999 (4 numbers). If you enter less than 4 numbers, leading 0s will be added automatically."
                />

                <x-forms.vendor-input
                    name="vendor_block_1"
                    label="Vendor block 1"
                    :defaultValue="$infotainmentProfile->vendor_block_1"
                />

                <x-forms.vendor-input
                    name="vendor_block_2"
                    label="Vendor block 2"
                    :defaultValue="$infotainmentProfile->vendor_block_2"
                />

                <x-forms.vendor-input
                    name="vendor_block_3"
                    label="Vendor block 3"
                    :defaultValue="$infotainmentProfile->vendor_block_3"
                />
            </div>
            <div class="tab-pane fade" id="timing-tab-pane" role="tabpanel" aria-labelledby="timing-tab"
                 tabindex="0">

                <x-forms.input
                    name="pixel_clock"
                    type="number"
                    label="Pixel clock"
                    :defaultValue="$timing->pixel_clock"
                    required="true"
                    step="0.01"
                    suffixText="MHz"
                    extraText="The value must be between 0.01-655.35. Only increments of 0.01 MHz are allowed."
                />

                <div class="row">
                    <div class="col-md-6">

                        <x-forms.input
                            name="horizontal_pixels"
                            type="number"
                            label="Horizontal pixels"
                            :defaultValue="$timing->horizontal_pixels"
                            required="true"
                            suffixText="pixels"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="horizontal_blank"
                            type="number"
                            label="Horizontal blank"
                            :defaultValue="$timing->horizontal_blank"
                            required="true"
                            suffixText="pixels"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="horizontal_front_porch"
                            type="number"
                            label="Horizontal front porch"
                            :defaultValue="$timing->horizontal_front_porch"
                            suffixText="pixels"
                            extraText="The value must be between 0-1023."
                        />

                        <x-forms.input
                            name="horizontal_sync_width"
                            type="number"
                            label="Horizontal sync width"
                            :defaultValue="$timing->horizontal_sync_width"
                            suffixText="pixels"
                            extraText="The value must be between 0-1023."
                        />

                        <x-forms.input
                            name="horizontal_image_size"
                            type="number"
                            label="Horizontal image size"
                            :defaultValue="$timing->horizontal_image_size"
                            suffixText="mm"
                            extraText="The value must be between 0-255."
                        />

                        <x-forms.input
                            name="horizontal_border"
                            type="number"
                            label="Horizontal border"
                            :defaultValue="$timing->horizontal_border"
                            suffixText="pixels"
                            extraText="The value must be between 0-255."
                        />

                        <x-forms.checkbox
                            name="signal_horizontal_sync_positive"
                            label="Horizontal signal sync polarity (+)"
                            :isCheckedByDefault="$timing->signal_horizontal_sync_positive"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-forms.input
                            name="vertical_lines"
                            type="number"
                            label="Vertical lines"
                            :defaultValue="$timing->vertical_lines"
                            required="true"
                            suffixText="lines"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="vertical_blank"
                            type="number"
                            label="Vertical blank"
                            :defaultValue="$timing->vertical_blank"
                            required="true"
                            suffixText="lines"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="vertical_front_porch"
                            type="number"
                            label="Vertical front porch"
                            :defaultValue="$timing->vertical_front_porch"
                            suffixText="lines"
                            extraText="The value must be between 0-63."
                        />

                        <x-forms.input
                            name="vertical_sync_width"
                            type="number"
                            label="Vertical sync width"
                            :defaultValue="$timing->vertical_sync_width"
                            suffixText="lines"
                            extraText="The value must be between 0-63."
                        />

                        <x-forms.input
                            name="vertical_image_size"
                            type="number"
                            label="Vertical image size"
                            :defaultValue="$timing->vertical_image_size"
                            suffixText="mm"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="vertical_border"
                            type="number"
                            label="Vertical border"
                            :defaultValue="$timing->vertical_border"
                            suffixText="lines"
                            extraText="The value must be between 0-255."
                        />

                        <x-forms.checkbox
                            name="signal_vertical_sync_positive"
                            label="Vertical signal sync polarity (+)"
                            :isCheckedByDefault="$timing->signal_vertical_sync_positive"
                        />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="extra-timing-tab-pane" role="tabpanel"
                 aria-labelledby="extra-timing-tab" tabindex="0">

                <x-forms.checkbox
                    name="extra_timing_block"
                    label="Enable extra timing"
                    :isCheckedByDefault="$extraTiming->exists"
                    extraText="If you disable this option, you will loose all the settings from this section.
                    Marked fields in this section are required only if this option is enabled."
                />

                <x-forms.input
                    name="extra_pixel_clock"
                    type="number"
                    label="Pixel clock"
                    :defaultValue="$extraTiming->pixel_clock"
                    required="true"
                    step="0.01"
                    suffixText="MHz"
                    extraText="The value must be between 0.01-655.35. Only increments of 0.01 MHz are allowed."
                />

                <div class="row">
                    <div class="col-md-6">
                        <x-forms.input
                            name="extra_horizontal_pixels"
                            type="number"
                            label="Horizontal pixels"
                            :defaultValue="$extraTiming->horizontal_pixels"
                            required="true"
                            suffixText="pixels"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_horizontal_blank"
                            type="number"
                            label="Horizontal blank"
                            :defaultValue="$extraTiming->horizontal_blank"
                            required="true"
                            suffixText="pixels"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_horizontal_front_porch"
                            type="number"
                            label="Horizontal front porch"
                            :defaultValue="$extraTiming->horizontal_front_porch"
                            suffixText="pixels"
                            extraText="The value must be between 0-1023."
                        />

                        <x-forms.input
                            name="extra_horizontal_sync_width"
                            type="number"
                            label="Horizontal sync width"
                            :defaultValue="$extraTiming->horizontal_sync_width"
                            suffixText="pixels"
                            extraText="The value must be between 0-1023."
                        />

                        <x-forms.input
                            name="extra_horizontal_image_size"
                            type="number"
                            label="Horizontal image size"
                            :defaultValue="$extraTiming->horizontal_image_size"
                            suffixText="mm"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_horizontal_border"
                            type="number"
                            label="Horizontal border"
                            :defaultValue="$extraTiming->horizontal_border"
                            suffixText="pixels"
                            extraText="The value must be between 0-255."
                        />

                        <x-forms.checkbox
                            name="extra_signal_horizontal_sync_positive"
                            label="Horizontal signal sync polarity (+)"
                            :isCheckedByDefault="$extraTiming->signal_horizontal_sync_positive"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-forms.input
                            name="extra_vertical_lines"
                            type="number"
                            label="Vertical lines"
                            :defaultValue="$extraTiming->vertical_lines"
                            required="true"
                            suffixText="lines"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_vertical_blank"
                            type="number"
                            label="Vertical blank"
                            :defaultValue="$extraTiming->vertical_blank"
                            required="true"
                            suffixText="lines"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_vertical_front_porch"
                            type="number"
                            label="Vertical front porch"
                            :defaultValue="$extraTiming->vertical_front_porch"
                            suffixText="lines"
                            extraText="The value must be between 0-63."
                        />

                        <x-forms.input
                            name="extra_vertical_sync_width"
                            type="number"
                            label="Vertical sync width"
                            :defaultValue="$extraTiming->vertical_sync_width"
                            suffixText="lines"
                            extraText="The value must be between 0-63."
                        />

                        <x-forms.input
                            name="extra_vertical_image_size"
                            type="number"
                            label="Vertical image size"
                            :defaultValue="$extraTiming->vertical_image_size"
                            suffixText="mm"
                            extraText="The value must be between 0-4095."
                        />

                        <x-forms.input
                            name="extra_vertical_border"
                            type="number"
                            label="Vertical border"
                            :defaultValue="$extraTiming->vertical_border"
                            suffixText="lines"
                            extraText="The value must be between 0-255."
                        />

                        <x-forms.checkbox
                            name="extra_signal_vertical_sync_positive"
                            label="Vertical signal sync polarity (+)"
                            :isCheckedByDefault="$extraTiming->signal_vertical_sync_positive"
                        />
                    </div>
                </div>
            </div>
        </div>

        <x-forms.required-note/>

        @if($mode === 'approve')
            <button type="submit" class="btn btn-primary">Approve</button>
            <a href="{{ route('infotainments.show', $infotainment) }}" class="btn btn-outline-danger">Cancel</a>
        @else
            <button type="submit" class="btn btn-primary">Save</button>
        @endif
    </form>
</x-layout>
