<x-layout>
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

    <form action="
        @switch($mode)
            @case('edit')
            @case('approve')
                {{ route('infotainments.profiles.update', [$infotainment, $infotainmentProfile]) }}
                @break
            @default
                {{ route('infotainments.profiles.store', $infotainment) }}
        @endswitch
        " method="POST">

        @csrf
        @if($mode === 'edit' || $mode === 'approve')
            @method('PATCH')
        @endif

        @if($mode === 'approve')
            <input type="hidden" name="approving_infotainment_profile" value="1">
        @endif

        <div class="mb-3">
            <ul class="nav nav-tabs" id="profile-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="base-tab" data-bs-toggle="tab" data-bs-target="#base-tab-pane"
                            type="button" role="tab" aria-controls="base-tab-pane" aria-selected="true">
                        Base information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="additional-tab" data-bs-toggle="tab"
                            data-bs-target="#additional-tab-pane" type="button" role="tab"
                            aria-controls="additional-tab-pane" aria-selected="false">
                        Additional information
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="timing-tab" data-bs-toggle="tab" data-bs-target="#timing-tab-pane"
                            type="button" role="tab" aria-controls="timing-tab-pane" aria-selected="false">
                        Timing
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="extra-timing-tab" data-bs-toggle="tab"
                            data-bs-target="#extra-timing-tab-pane" type="button" role="tab"
                            aria-controls="extra-timing-tab-pane" aria-selected="false">
                        Extra Timing
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="base-tab-pane" role="tabpanel" aria-labelledby="base-tab"
                     tabindex="0">
                    <label for="color_bit_depth" class="form-label">Color bit depth</label>
                    <select name="color_bit_depth" id="color_bit_depth"
                            @class(['form-select', 'is-invalid' => $errors->has('color_bit_depth')])
                            required>
                        @foreach($colorBitDepths as $key => $colorBitDepth)
                            <option value="{{ $key }}"
                                @selected(old('color_bit_depth', $infotainmentProfile->color_bit_depth?->value) == $key)>
                                {{ $colorBitDepth }}
                            </option>
                        @endforeach
                    </select>
                    @error('color_bit_depth')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror<label for="interface" class="form-label">Interface</label>
                    <select name="interface" id="interface"
                            @class(['form-select', 'is-invalid' => $errors->has('interface')])
                            required>
                        @foreach($interfaces as $key => $interface)
                            <option value="{{ $key }}"
                                @selected(old('interface', $infotainmentProfile->interface?->value) == $key)>
                                {{ $interface }}
                            </option>
                        @endforeach
                    </select>
                    @error('interface')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="horizontal_size" class="form-label">Horizontal size</label>
                    <input type="number" name="horizontal_size"
                           value="{{ old('horizontal_size', $infotainmentProfile->horizontal_size) }}"
                           id="horizontal_size"
                           @class(['form-control', 'is-invalid' => $errors->has('horizontal_size')])
                           required>
                    @error('horizontal_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="vertical_size" class="form-label">Vertical size</label>
                    <input type="number" name="vertical_size"
                           value="{{ old('vertical_size', $infotainmentProfile->vertical_size) }}"
                           id="vertical_size"
                           @class(['form-control', 'is-invalid' => $errors->has('vertical_size')])
                           required>
                    @error('vertical_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="form-check">
                        <input type="checkbox" name="is_ycrcb_4_4_4"
                               value="1" id="is_ycrcb_4_4_4"
                               class="form-check-input"
                            @checked(old('is_ycrcb_4_4_4', $infotainmentProfile->is_ycrcb_4_4_4))>
                        <label for="is_ycrcb_4_4_4" class="form-check-label">
                            YCrCb 4:4:4
                        </label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_ycrcb_4_2_2"
                               value="1" id="is_ycrcb_4_2_2"
                               class="form-check-input"
                            @checked(old('is_ycrcb_4_2_2', $infotainmentProfile->is_ycrcb_4_2_2))>
                        <label for="is_ycrcb_4_2_2" class="form-check-label">
                            YCrCb 4:2:2
                        </label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_srgb"
                               value="1" id="is_srgb"
                               class="form-check-input"
                            @checked(old('is_srgb', $infotainmentProfile->is_srgb))>
                        <label for="is_srgb" class="form-check-label">
                            sRGB
                        </label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_continuous_frequency"
                               value="1" id="is_continuous_frequency"
                               class="form-check-input"
                            @checked(old('is_continuous_frequency', $infotainmentProfile->is_continuous_frequency))>
                        <label for="is_continuous_frequency" class="form-check-label">
                            Continuous frequency
                        </label>
                    </div>
                </div>
                <div class="tab-pane fade" id="additional-tab-pane" role="tabpanel" aria-labelledby="additional-tab"
                     tabindex="0">
                    <label for="hw_version" class="form-label">HW version</label>
                    <input type="text" name="hw_version"
                           value="{{ old('hw_version', $infotainmentProfile->hw_version) }}"
                           id="hw_version"
                           @class(['form-control', 'is-invalid' => $errors->has('hw_version')])
                           maxlength="3" required>
                    @error('hw_version')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="sw_version" class="form-label">SW version</label>
                    <input type="text" name="sw_version"
                           value="{{ old('sw_version', $infotainmentProfile->sw_version) }}"
                           id="sw_version"
                           @class(['form-control', 'is-invalid' => $errors->has('sw_version')])
                           maxlength="4" required>
                    @error('sw_version')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="vendor_block_1" class="form-label">Vendor block 1</label>
                    <input type="text" name="vendor_block_1"
                           value="{{ old('vendor_block_1', $infotainmentProfile->vendor_block_1) }}"
                           id="vendor_block_1"
                           @class(['form-control', 'is-invalid' => $errors->has('vendor_block_1')])
                           maxlength="31" required>
                    @error('vendor_block_1')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="vendor_block_2" class="form-label">Vendor block 2</label>
                    <input type="text" name="vendor_block_2"
                           value="{{ old('vendor_block_2', $infotainmentProfile->vendor_block_2) }}"
                           id="vendor_block_2"
                           @class(['form-control', 'is-invalid' => $errors->has('vendor_block_2')])
                           maxlength="31" required>
                    @error('vendor_block_2')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="vendor_block_3" class="form-label">Vendor block 3</label>
                    <input type="text" name="vendor_block_3"
                           value="{{ old('vendor_block_3', $infotainmentProfile->vendor_block_3) }}"
                           id="vendor_block_3"
                           @class(['form-control', 'is-invalid' => $errors->has('vendor_block_3')])
                           maxlength="31" required>
                    @error('vendor_block_3')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="tab-pane fade" id="timing-tab-pane" role="tabpanel" aria-labelledby="timing-tab"
                     tabindex="0">
                    <label for="pixel_clock" class="form-label">Pixel clock</label>
                    <input type="number" name="pixel_clock"
                           value="{{ old('pixel_clock', $timing->pixel_clock) }}"
                           id="pixel_clock"
                           @class(['form-control', 'is-invalid' => $errors->has('pixel_clock')])
                           required>
                    @error('pixel_clock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="row">
                        <div class="col-md-6">
                            <label for="horizontal_pixels" class="form-label">Horizontal pixels</label>
                            <input type="number" name="horizontal_pixels"
                                   value="{{ old('horizontal_pixels', $timing->horizontal_pixels) }}"
                                   id="horizontal_pixels"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_pixels')])
                                   required>
                            @error('horizontal_pixels')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="horizontal_blank" class="form-label">Horizontal pixels</label>
                            <input type="number" name="horizontal_blank"
                                   value="{{ old('horizontal_blank', $timing->horizontal_blank) }}"
                                   id="horizontal_blank"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_blank')])
                                   required>
                            @error('horizontal_blank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="horizontal_front_porch" class="form-label">Horizontal front porch</label>
                            <input type="number" name="horizontal_front_porch"
                                   value="{{ old('horizontal_front_porch', $timing->horizontal_front_porch) }}"
                                   id="horizontal_front_porch"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_front_porch')])
                                   required>
                            @error('horizontal_front_porch')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="horizontal_sync_width" class="form-label">Horizontal sync width</label>
                            <input type="number" name="horizontal_sync_width"
                                   value="{{ old('horizontal_sync_width', $timing->horizontal_sync_width) }}"
                                   id="horizontal_sync_width"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_sync_width')])
                                   required>
                            @error('horizontal_sync_width')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="horizontal_image_size" class="form-label">Horizontal image size</label>
                            <input type="number" name="horizontal_image_size"
                                   value="{{ old('horizontal_image_size', $timing->horizontal_image_size) }}"
                                   id="horizontal_image_size"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_image_size')])
                                   required>
                            @error('horizontal_image_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="horizontal_border" class="form-label">Horizontal border</label>
                            <input type="number" name="horizontal_border"
                                   value="{{ old('horizontal_border', $timing->horizontal_border) }}"
                                   id="horizontal_border"
                                   @class(['form-control', 'is-invalid' => $errors->has('horizontal_border')])
                                   required>
                            @error('horizontal_border')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-check">
                                <input type="checkbox" name="signal_horizontal_sync_positive"
                                       value="1" id="signal_horizontal_sync_positive"
                                       class="form-check-input"
                                    @checked(old('signal_horizontal_sync_positive', $timing->signal_horizontal_sync_positive))>
                                <label for="signal_horizontal_sync_positive" class="form-check-label">
                                    Horizontal signal sync polarity (+)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="vertical_lines" class="form-label">Vertical lines</label>
                            <input type="number" name="vertical_lines"
                                   value="{{ old('vertical_lines', $timing->vertical_lines) }}"
                                   id="vertical_lines"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_lines')])
                                   required>
                            @error('vertical_lines')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="vertical_blank" class="form-label">Vertical pixels</label>
                            <input type="number" name="vertical_blank"
                                   value="{{ old('vertical_blank', $timing->vertical_blank) }}"
                                   id="vertical_blank"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_blank')])
                                   required>
                            @error('vertical_blank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="vertical_front_porch" class="form-label">Vertical front porch</label>
                            <input type="number" name="vertical_front_porch"
                                   value="{{ old('vertical_front_porch', $timing->vertical_front_porch) }}"
                                   id="vertical_front_porch"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_front_porch')])
                                   required>
                            @error('vertical_front_porch')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="vertical_sync_width" class="form-label">Vertical sync width</label>
                            <input type="number" name="vertical_sync_width"
                                   value="{{ old('vertical_sync_width', $timing->vertical_sync_width) }}"
                                   id="vertical_sync_width"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_sync_width')])
                                   required>
                            @error('vertical_sync_width')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="vertical_image_size" class="form-label">Vertical image size</label>
                            <input type="number" name="vertical_image_size"
                                   value="{{ old('vertical_image_size', $timing->vertical_image_size) }}"
                                   id="vertical_image_size"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_image_size')])
                                   required>
                            @error('vertical_image_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="vertical_border" class="form-label">Vertical border</label>
                            <input type="number" name="vertical_border"
                                   value="{{ old('vertical_border', $timing->vertical_border) }}"
                                   id="vertical_border"
                                   @class(['form-control', 'is-invalid' => $errors->has('vertical_border')])
                                   required>
                            @error('vertical_border')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-check">
                                <input type="checkbox" name="signal_vertical_sync_positive"
                                       value="1" id="signal_vertical_sync_positive"
                                       class="form-check-input"
                                    @checked(old('signal_vertical_sync_positive', $timing->signal_vertical_sync_positive))>
                                <label for="signal_vertical_sync_positive" class="form-check-label">
                                    Vertical signal sync polarity (+)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="extra-timing-tab-pane" role="tabpanel"
                     aria-labelledby="extra-timing-tab" tabindex="0">
                    <div class="form-check">
                        <input type="checkbox" name="extra_timing_block"
                               value="1" id="extra_timing_block"
                               class="form-check-input"
                            @checked(old('extra_timing_block', $extraTiming->exists))>
                        <label for="extra_timing_block" class="form-check-label">
                            Enable extra timing (if you uncheck this, you will loose the extra timing settings after
                            save)
                        </label>
                    </div>

                    <label for="extra_pixel_clock" class="form-label">Pixel clock</label>
                    <input type="number" name="extra_pixel_clock"
                           value="{{ old('extra_pixel_clock', $extraTiming->pixel_clock) }}"
                           id="extra_pixel_clock"
                           @class(['form-control', 'is-invalid' => $errors->has('extra_pixel_clock')])
                           required>
                    @error('extra_pixel_clock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="row">
                        <div class="col-md-6">
                            <label for="extra_horizontal_pixels" class="form-label">Horizontal pixels</label>
                            <input type="number" name="extra_horizontal_pixels"
                                   value="{{ old('extra_horizontal_pixels', $extraTiming->horizontal_pixels) }}"
                                   id="extra_horizontal_pixels"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_pixels')])
                                   required>
                            @error('extra_horizontal_pixels')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_horizontal_blank" class="form-label">Horizontal pixels</label>
                            <input type="number" name="extra_horizontal_blank"
                                   value="{{ old('extra_horizontal_blank', $extraTiming->horizontal_blank) }}"
                                   id="extra_horizontal_blank"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_blank')])
                                   required>
                            @error('extra_horizontal_blank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_horizontal_front_porch" class="form-label">Horizontal front
                                porch</label>
                            <input type="number" name="extra_horizontal_front_porch"
                                   value="{{ old('extra_horizontal_front_porch', $extraTiming->horizontal_front_porch) }}"
                                   id="extra_horizontal_front_porch"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_front_porch')])
                                   required>
                            @error('extra_horizontal_front_porch')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_horizontal_sync_width" class="form-label">Horizontal sync
                                width</label>
                            <input type="number" name="extra_horizontal_sync_width"
                                   value="{{ old('extra_horizontal_sync_width', $extraTiming->horizontal_sync_width) }}"
                                   id="extra_horizontal_sync_width"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_sync_width')])
                                   required>
                            @error('extra_horizontal_sync_width')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_horizontal_image_size" class="form-label">Horizontal image
                                size</label>
                            <input type="number" name="extra_horizontal_image_size"
                                   value="{{ old('extra_horizontal_image_size', $extraTiming->horizontal_image_size) }}"
                                   id="extra_horizontal_image_size"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_image_size')])
                                   required>
                            @error('extra_horizontal_image_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_horizontal_border" class="form-label">Horizontal border</label>
                            <input type="number" name="extra_horizontal_border"
                                   value="{{ old('extra_horizontal_border', $extraTiming->horizontal_border) }}"
                                   id="extra_horizontal_border"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_horizontal_border')])
                                   required>
                            @error('extra_horizontal_border')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-check">
                                <input type="checkbox" name="extra_signal_horizontal_sync_positive"
                                       value="1" id="extra_signal_horizontal_sync_positive"
                                       class="form-check-input"
                                    @checked(old('extra_signal_horizontal_sync_positive', $extraTiming->signal_horizontal_sync_positive))>
                                <label for="extra_signal_horizontal_sync_positive" class="form-check-label">
                                    Horizontal signal sync polarity (+)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="extra_vertical_lines" class="form-label">Vertical lines</label>
                            <input type="number" name="extra_vertical_lines"
                                   value="{{ old('extra_vertical_lines', $extraTiming->vertical_lines) }}"
                                   id="extra_vertical_lines"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_lines')])
                                   required>
                            @error('extra_vertical_lines')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_vertical_blank" class="form-label">Vertical pixels</label>
                            <input type="number" name="extra_vertical_blank"
                                   value="{{ old('extra_vertical_blank', $extraTiming->vertical_blank) }}"
                                   id="extra_vertical_blank"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_blank')])
                                   required>
                            @error('extra_vertical_blank')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_vertical_front_porch" class="form-label">Vertical front porch</label>
                            <input type="number" name="extra_vertical_front_porch"
                                   value="{{ old('extra_vertical_front_porch', $extraTiming->vertical_front_porch) }}"
                                   id="extra_vertical_front_porch"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_front_porch')])
                                   required>
                            @error('extra_vertical_front_porch')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_vertical_sync_width" class="form-label">Vertical sync width</label>
                            <input type="number" name="extra_vertical_sync_width"
                                   value="{{ old('extra_vertical_sync_width', $extraTiming->vertical_sync_width) }}"
                                   id="extra_vertical_sync_width"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_sync_width')])
                                   required>
                            @error('extra_vertical_sync_width')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_vertical_image_size" class="form-label">Vertical image size</label>
                            <input type="number" name="extra_vertical_image_size"
                                   value="{{ old('extra_vertical_image_size', $extraTiming->vertical_image_size) }}"
                                   id="extra_vertical_image_size"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_image_size')])
                                   required>
                            @error('extra_vertical_image_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="extra_vertical_border" class="form-label">Vertical border</label>
                            <input type="number" name="extra_vertical_border"
                                   value="{{ old('extra_vertical_border', $extraTiming->vertical_border) }}"
                                   id="extra_vertical_border"
                                   @class(['form-control', 'is-invalid' => $errors->has('extra_vertical_border')])
                                   required>
                            @error('extra_vertical_border')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-check">
                                <input type="checkbox" name="extra_signal_vertical_sync_positive"
                                       value="1" id="extra_signal_vertical_sync_positive"
                                       class="form-check-input"
                                    @checked(old('extra_signal_vertical_sync_positive', $extraTiming->signal_vertical_sync_positive))>
                                <label for="extra_signal_vertical_sync_positive" class="form-check-label">
                                    Vertical signal sync polarity (+)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                @if($mode === 'approve')
                    <button type="submit" class="btn btn-primary">Approve</button>
                    <a href="{{ route('infotainments.show', $infotainment) }}" class="btn btn-outline-danger">Cancel</a>
                @else
                    <button type="submit" class="btn btn-primary">Save</button>
                @endif
        </div>
    </form>
</x-layout>
