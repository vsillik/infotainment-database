<div id="guide-modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vendor data block guide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invalid-data-loaded" class="alert alert-warning d-none" role="alert">
                    Loaded data might be incomplete, because some bytes contains invalid values.
                </div>

                <form action="#">
                    <input type="hidden" name="guide_target" id="guide_target">

                    <x-forms.select
                        name="guide_payload_type"
                        label="Payload type"
                        :options="[1 => 'CAN Simulation', 2 => 'Video Interface Additional Parameters']"
                        required="true"
                    />

                    <div class="row">
                        <div class="col-md-6">
                            <x-forms.input
                                name="guide_major_version"
                                type="number"
                                :defaultValue="config('app.vendor_guide.default_major')"
                                label="Major document version"
                                extraText="The value must be between 0-15."
                                required="true"
                                min="0"
                                max="15"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-forms.input
                                name="guide_minor_version"
                                type="number"
                                :defaultValue="config('app.vendor_guide.default_minor')"
                                label="Minor document version"
                                extraText="The value must be between 0-15."
                                required="true"
                                min="0"
                                max="15"
                            />
                        </div>
                    </div>

                    <div id="guide-can-simulation" class="d-none">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_1"
                                    label="CAN 1"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_2"
                                    label="CAN 2"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_3"
                                    label="CAN 3"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_4"
                                    label="CAN 4"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_5"
                                    label="CAN 5"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_6"
                                    label="CAN 6"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_7"
                                    label="CAN 7"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-forms.checkbox
                                    name="guide_simulation_can_8"
                                    label="CAN 8"
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.select
                                    name="guide_simulation_id"
                                    label="Simulation ID"
                                    :options="[
                                        0 => 'No simulation',
                                        1 => 'MIB-CAN',
                                        2 => 'AB-CAN',
                                        -1 => 'Custom'
                                    ]"
                                    required="true"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input
                                    name="guide_custom_simulation_id"
                                    label="Custom Simulation ID"
                                    extraText="The value must contain up to 4 hexadecimal characters when Simulation ID is 'Custom'."
                                    :disabled="true"
                                    min="0"
                                    max="65535"
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-forms.select
                                    name="guide_iso_tp"
                                    label="ISO TP"
                                    :options="[
                                        0 => 'None (blank)',
                                        1 => 'ABT',
                                        2 => 'CDD',
                                        3 => 'i.ID/FID',
                                        4 => 'HUD',
                                        5 => 'PPE CID',
                                        6 => 'PPE FID',
                                        7 => 'FPK',
                                        -1 => 'Custom',
                                    ]"
                                    required="true"
                                />
                            </div>
                            <div class="col-md-6">
                                <x-forms.input
                                    name="guide_custom_iso_tp"
                                    label="Custom ISO TP"
                                    extraText="The value must contain up to 4 hexadecimal characters when ISO TP is 'Custom'."
                                    :disabled="true"
                                    min="0"
                                    max="65535"
                                />
                            </div>
                        </div>

                        <x-forms.input
                            name="guide_display_multiplication_x"
                            type="number"
                            label="Display multiplication coefficient X-axis"
                            extraText="The value must be between 0-255."
                            required="true"
                            min="0"
                            max="255"
                        />

                        <x-forms.input
                            name="guide_display_multiplication_y"
                            type="number"
                            label="Display multiplication coefficient Y-axis"
                            extraText="The value must be between 0-255."
                            required="true"
                            min="0"
                            max="255"
                        />

                        <x-forms.checkbox
                            name="guide_digitizer_mirrored"
                            label="Touchscreen digitizer mirrored (horizontally)"
                        />

                        <x-forms.input
                            name="guide_digitizer_rotated_degrees"
                            type="number"
                            label="Relative touchscreen digitizer's orientation (clockwise rotation)"
                            suffixText="×90°"
                            extraText="The value must be between 0-3."
                            required="true"
                            min="0"
                            max="3"
                        />

                        <x-forms.checkbox
                            name="guide_screen_mirrored"
                            label="Screen mirrored (horizontally)"
                        />

                        <x-forms.input
                            name="guide_screen_rotated_degrees"
                            type="number"
                            label="Relative screen's orientation (clockwise rotation)"
                            suffixText="×90°"
                            extraText="The value must be between 0-3."
                            required="true"
                            min="0"
                            max="3"
                        />

                    </div>

                    <div id="guide-video-params" class="d-none">
                        <x-forms.select
                            name="guide_output_interface"
                            label="Output interface"
                            :options="[
                                0 => 'Native LVDS (OpenLDI)',
                                1 => 'FPD-Link II',
                                2 => 'FPD-Link III',
                                3 => 'FPD-Link IV',
                                4 => 'GMSL 1',
                                5 => 'GMSL 2',
                                6 => 'GMSL 3',
                                7 => 'GMSL 4',
                                8 => 'Embedded DisplayPort',
                            ]"
                            required="true"
                        />

                        <x-forms.input
                            name="guide_processed_pixels"
                            type="number"
                            label="Processed pixels per pixel clock"
                            extraText="The value must be between 0-255."
                            required="true"
                            min="0"
                            max="255"
                        />

                        <x-forms.select
                            name="guide_color_mapping"
                            label="Color mapping"
                            :options="[
                                0 => 'Unspecified or not applicable',
                                1 => 'VESA',
                                2 => 'JEIDA',
                            ]"
                            required="true"
                        />

                        <div id="fpd-link-3" class="d-none">
                            <x-forms.select
                                name="guide_link_count"
                                label="Link count"
                                :options="[
                                    0 => 'Automatic',
                                    1 => 'Force Single-Link',
                                    2 => 'Force Dual-Link',
                                ]"
                                required="true"
                            />
                        </div>

                        <div id="gmsl" class="d-none">
                            <x-forms.input
                                name="guide_link_rate"
                                type="number"
                                label="Link rate"
                                suffixText="Gbps"
                                extraText="The value must be between 0-255. Nominal speeds are 3/6/12."
                                required="true"
                                min="0"
                                max="255"
                            />

                            <x-forms.checkbox
                                name="guide_fec_enabled"
                                label="FEC enabled"
                            />

                            <x-forms.input
                                name="guide_stream_id"
                                type="number"
                                label="Stream ID"
                                extraText="The value must be between 1-4."
                                required="true"
                                min="1"
                                max="4"
                            />

                            <x-forms.select
                                name="guide_gmsl_output"
                                label="Output"
                                :options="[
                                    0 => 'Unspecified',
                                    1 => 'Out A',
                                    2 => 'Out B',
                                    3 => 'Out A & B',
                                ]"
                                required="true"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="modal-apply" class="btn btn-primary" @disabled($isDisabled)>Apply</button>
            </div>
        </div>
    </div>
</div>

@pushonce('scripts')
    <script>
        const guideModal = document.getElementById('guide-modal');
        const targetInput = document.getElementById('guide_target');
        const guideApplyButton = document.getElementById('modal-apply');
        const invalidDataLoadedError = document.getElementById('invalid-data-loaded');
        const payloadSelect = document.getElementById('guide_payload_type');
        const canSimulationSection = document.getElementById('guide-can-simulation');
        const simulationIdSelect = document.getElementById('guide_simulation_id');
        const customSimulationId = document.getElementById('guide_custom_simulation_id');
        const isoTpSelect = document.getElementById('guide_iso_tp');
        const customIsoTp = document.getElementById('guide_custom_iso_tp');
        const videoParamsSection = document.getElementById('guide-video-params');
        const outputInterfaceSelect = document.getElementById('guide_output_interface');
        const fpd3Section = document.getElementById('fpd-link-3');
        const gmslSection = document.getElementById('gmsl');

        function setInputInvalid(elementName) {
            const element = document.getElementById(elementName);
            element.classList.add('is-invalid');

            if (element.tagName === "INPUT") {
                const additionalTextElement = element.parentElement.parentElement.querySelector('.form-text');
                if (additionalTextElement !== null) {
                    additionalTextElement.classList.add('invalid-feedback', 'd-block');
                }
            }
        }

        function resetInputInvalid(elementName) {
            const element = document.getElementById(elementName);
            element.classList.remove('is-invalid');

            if (element.tagName === "INPUT") {
                const additionalTextElement = element.parentElement.parentElement.querySelector('.form-text');
                if (additionalTextElement !== null) {
                    additionalTextElement.classList.remove('invalid-feedback', 'd-block');
                }
            }
        }

        function getByteValue(elementName, byteNumber) {
            // byte 4 => element suffix _0, 5 => _1
            return document.getElementById(elementName + '_' + (byteNumber - 4)).value.trim().padStart(2, '0');
        }

        function getByteValueWithDefault(elementName, byteNumber, defaultValue) {
            // byte 4 => element suffix _0, 5 => _1
            let elementValue = document.getElementById(elementName + '_' + (byteNumber - 4)).value.trim();

            if (elementValue === null || elementValue === '') {
                elementValue = defaultValue;
            }

            return elementValue.padStart(2, '0');
        }

        function setInputFromNumberValue(inputName, numberValue, minValidValue, maxValidValue) {
            // reset validation if there is something left from previous guide apply
            resetInputInvalid(inputName);

            const element = document.getElementById(inputName);

            if (numberValue >= minValidValue && numberValue <= maxValidValue) {
                element.value = numberValue;
                return true;
            } else {
                element.value = minValidValue;
                return false;
            }
        }

        function getNumberValueFromInput(inputName, minValidValue, maxValidValue) {
            const element = document.getElementById(inputName);

            if (!/^-?\d+$/.test(element.value.trim())) {
                setInputInvalid(inputName);
                return {value: 0, valid: false};
            }

            const numberValue = Number(element.value.trim());
            let resultValue = 0;
            let valid = true;

            if (numberValue >= minValidValue && numberValue <= maxValidValue) {
                resultValue = numberValue;
                resetInputInvalid(inputName);
            } else {
                valid = false;
                setInputInvalid(inputName);
            }

            return {value: resultValue, valid: valid}
        }

        // returns true if the hexValue was in valid range or false if not
        function setInputFromHexValue(inputName, hexValue, minValidValue, maxValidValue) {
            const numberValue = Number('0x' + hexValue);
            return setInputFromNumberValue(inputName, numberValue, minValidValue, maxValidValue);
        }

        // returns {value: <hex chars>, valid: true/false}
        function getHexValueFromInput(inputName, minValidValue, maxValidValue) {
            const {value, valid} = getNumberValueFromInput(inputName, minValidValue, maxValidValue);

            return {value: value.toString(16).padStart(2, '0'), valid: valid}
        }

        function loadPayloadType(value) {
            return setInputFromHexValue(
                'guide_payload_type',
                value,
                1,
                2
            );
        }

        function getPayloadTypeBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_payload_type',
                1,
                2
            );

            return {bytes: [value], valid: valid};
        }

        function loadVersions(value) {
            const majorString = value.substring(0, 1);
            const minorString = value.substring(1, 2);

            const majorSuccess = setInputFromHexValue(
                'guide_major_version',
                majorString,
                0,
                15,
            );

            const minorSuccess = setInputFromHexValue(
                'guide_minor_version',
                minorString,
                0,
                15,
            );

            return majorSuccess && minorSuccess;
        }

        function getVersionsBytes() {
            let majorVersionValue = '0';
            let minorVersionValue = '0';
            let bothValid = true;

            const {value: valueMajor, valid: validMajor} = getHexValueFromInput(
                'guide_major_version',
                0,
                15,
            );

            if (!validMajor) {
                bothValid = false;
            } else {
                majorVersionValue = valueMajor.substring(1, 2); // take the second hex char only
            }

            const {value: valueMinor, valid: validMinor} = getHexValueFromInput(
                'guide_minor_version',
                0,
                15,
            );

            if (!validMinor) {
                bothValid = false;
            } else {
                minorVersionValue = valueMinor.substring(1, 2); // take the second hex char only
            }

            return {bytes: [majorVersionValue + minorVersionValue], valid: bothValid};
        }

        function loadSimulation(value) {
            let numberValue = Number('0x' + value);
            let valuesIsValid = true;

            if (isNaN(numberValue) || numberValue < 0 || numberValue > 255) {
                numberValue = 0;
                valuesIsValid = false;
            }

            const binaryString = numberValue.toString(2).padStart(8, '0');

            // Bit 0 = CAN 1, bit 1 = CAN 2, ...
            for (let i = 0; i < 8; i++) {
                const checkboxName = 'guide_simulation_can_' + (i + 1);

                // reset validation if there is something left from previous guide apply
                resetInputInvalid(checkboxName);

                const checkbox = document.getElementById(checkboxName);
                // iterating the binary string in reverse order
                checkbox.checked = binaryString.substring(7 - i, 7 - i + 1) === '1';
            }

            return valuesIsValid;
        }

        function getSimulationBytes() {
            let value = 0;

            for (let i = 0; i < 8; i++) {
                const checkbox = document.getElementById('guide_simulation_can_' + (i + 1));
                // CAN1 => 0b00000001, CAN2 => 0b00000010, ...
                if (checkbox.checked) {
                    value = value | (1 << i);
                }
            }

            return {bytes: [value.toString(16).padStart(2, '0')], valid: true}
        }

        function loadCustomValue(elementBaseName, lsbValue, msbValue, maxValidSelectValue) {
            const selectElementName = 'guide_' + elementBaseName;
            const customElementName = 'guide_custom_' + elementBaseName;

            // reset validation if there is something left from previous guide apply
            resetInputInvalid(selectElementName);
            resetInputInvalid(customElementName);

            const numberValue = Number('0x' + msbValue + lsbValue);
            let selectValue = 0;
            let hasValidValue = true;

            if (numberValue >= 0 && numberValue <= 65535) {
                const customElement = document.getElementById(customElementName);
                // custom value
                if (numberValue > maxValidSelectValue) {
                    selectValue = -1;
                    customElement.value = numberValue.toString(16).padStart(4, '0');
                } else {
                    selectValue = numberValue;
                    customElement.value = '';
                }
            } else {
                hasValidValue = false;
            }

            setInputFromNumberValue(
                selectElementName,
                selectValue,
                -1,
                maxValidSelectValue,
            );

            return hasValidValue;
        }

        function getCustomBytes(elementBaseName, maxValidSelectValue) {
            const selectElementName = 'guide_' + elementBaseName;
            const customElementName = 'guide_custom_' + elementBaseName;

            const {value: selectValue, valid: selectValid} = getNumberValueFromInput(
                selectElementName,
                -1,
                maxValidSelectValue
            );
            let value = selectValue;

            if (!selectValid) {
                return {bytes: [], valid: false};
            }

            if (selectValue === -1) {
                const customElement = document.getElementById(customElementName);
                const customNumberValue = Number('0x' + customElement.value);

                if (customNumberValue >= 0 && customNumberValue <= 65535) {
                    resetInputInvalid(customElementName);
                    value = customNumberValue;
                } else {
                    setInputInvalid(customElementName);
                    return {bytes: [], valid: false}
                }
            }

            const valueHex = value.toString(16).padStart(4, '0');
            return {bytes: [valueHex.substring(2, 4), valueHex.substring(0, 2)], valid: true};
        }

        function loadSimulationId(lsbValue, msbValue) {
            return loadCustomValue(
                'simulation_id',
                lsbValue,
                msbValue,
                2
            );
        }

        function getSimulationIdBytes() {
            return getCustomBytes(
                'simulation_id',
                2
            );
        }

        function loadIsoTp(lsbValue, msbValue) {
            return loadCustomValue(
                'iso_tp',
                lsbValue,
                msbValue,
                7,
            );
        }

        function getIsoTpBytes() {
            return getCustomBytes(
                'iso_tp',
                7,
            );
        }

        function loadMultiplicationX(value) {
            return setInputFromHexValue(
                'guide_display_multiplication_x',
                value,
                0,
                255,
            );
        }

        function getMultiplicationXBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_display_multiplication_x',
                0,
                255,
            );

            return {bytes: [value], valid: valid};
        }

        function loadMultiplicationY(value) {
            return setInputFromHexValue(
                'guide_display_multiplication_y',
                value,
                0,
                255,
            );
        }

        function getMultiplicationYBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_display_multiplication_y',
                0,
                255,
            );

            return {bytes: [value], valid: valid};
        }

        function setRotationsElements(elementBaseName, numberValue) {
            const elementMirroredName = elementBaseName + '_mirrored';
            const elementDegreesName = elementBaseName + '_rotated_degrees';

            // reset validation if there is something left from previous guide apply
            resetInputInvalid(elementMirroredName);
            resetInputInvalid(elementDegreesName);

            const elementMirroredCheckbox = document.getElementById(elementMirroredName);
            const elementDegrees = document.getElementById(elementDegreesName);

            // Bit 3 is 1 if it's mirrored, Bits 1--2 are the rotation value
            if (numberValue >= 0 && numberValue <= 0b111) {
                // bit 3 is 1
                if ((numberValue & 0b100) > 0) {
                    elementMirroredCheckbox.checked = true;
                    elementDegrees.value = numberValue - 0b100;
                } else {
                    elementMirroredCheckbox.checked = false;
                    elementDegrees.value = numberValue;
                }
            } else {
                elementMirroredCheckbox.checked = false;
                elementDegrees.value = 0;
                return false;
            }

            return true;
        }

        function loadScreenRotation(value) {
            let valuesAreValid = true;

            const numberValue = Number('0x' + value);

            if (!(numberValue >= 0 && numberValue <= 255)) {
                setRotationsElements('guide_digitizer', 0);
                setRotationsElements('guide_screen', 0);
                return false;
            }

            const digitizerNumberValue = (numberValue >> 4) & 0b111;
            const screenNumberValue = numberValue & 0b111;

            if (!setRotationsElements('guide_digitizer', digitizerNumberValue)) {
                valuesAreValid = false;
            }

            if (!setRotationsElements('guide_screen', screenNumberValue)) {
                valuesAreValid = false;
            }

            return valuesAreValid;
        }

        function getScreenRotationBytes() {
            let value = 0;
            let valuesAreValid = true;

            const digitizerMirroredElement = document.getElementById('guide_digitizer_mirrored');
            if (digitizerMirroredElement.checked) {
                value = value | (1 << 6); // bit 6
            }

            const {value: digitizerRotationValue, valid: digitizerRotationValid} = getNumberValueFromInput(
                'guide_digitizer_rotated_degrees',
                0,
                3,
            )
            if (!digitizerRotationValid) {
                valuesAreValid = false;
            } else {
                value = value | (digitizerRotationValue << 4); // bits 5-4
            }

            const screenMirroredElement = document.getElementById('guide_screen_mirrored');
            if (screenMirroredElement.checked) {
                value = value | (1 << 2); // bit 2
            }

            const {value: screenRotationValue, valid: screenRotationValid} = getNumberValueFromInput(
                'guide_screen_rotated_degrees',
                0,
                3,
            );
            if (!screenRotationValid) {
                valuesAreValid = false;
            } else {
                value = value | (screenRotationValue); // bits 1-0
            }

            if (!valuesAreValid) {
                return {bytes: [], valid: false};
            }

            return {bytes: [value.toString(16).padStart(2, '0')], valid: true};
        }

        function loadOutputInterface(value) {
            return setInputFromHexValue(
                'guide_output_interface',
                value,
                0,
                8,
            );
        }

        function getOutputInterfaceBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_output_interface',
                0,
                8,
            );

            return {bytes: [value], valid: valid};
        }

        function loadProcessedPixels(value) {
            return setInputFromHexValue(
                'guide_processed_pixels',
                value,
                0,
                255,
            );
        }

        function getProcessedPixelsBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_processed_pixels',
                0,
                255,
            );

            return {bytes: [value], valid: valid};
        }

        function loadColorMapping(value) {
            return setInputFromHexValue(
                'guide_color_mapping',
                value,
                0,
                2,
            );
        }

        function getColorMappingBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_color_mapping',
                0,
                2,
            );

            return {bytes: [value], valid: valid};
        }

        function loadLinkCount(value) {
            return setInputFromHexValue(
                'guide_link_count',
                value,
                0,
                2,
            );
        }

        function getLinkCountBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_link_count',
                0,
                2,
            );

            return {bytes: [value], valid: valid};
        }

        function loadLinkRate(value) {
            return setInputFromHexValue(
                'guide_link_rate',
                value,
                0,
                255,
            );
        }

        function getLinkRateBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_link_rate',
                0,
                255,
            );

            return {bytes: [value], valid: valid};
        }

        function loadFec(value) {
            // reset validation if there is something left from previous guide apply
            resetInputInvalid('guide_fec_enabled');

            const numberValue = Number('0x' + value);
            const checkbox = document.getElementById('guide_fec_enabled');

            if (numberValue !== 1 && numberValue !== 0) {
                checkbox.checked = false;
                return false;
            }

            checkbox.checked = numberValue === 1;
            return true;
        }

        function getFecBytes() {
            let value = 0;

            const checkbox = document.getElementById('guide_fec_enabled');
            if (checkbox.checked) {
                value = 1;
            }

            return {bytes: [value.toString(16).padStart(2, '0')], valid: true};
        }

        function loadStreamId(value) {
            return setInputFromHexValue(
                'guide_stream_id',
                value,
                1,
                4,
            );
        }

        function getStreamIdBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_stream_id',
                1,
                4,
            );

            return {bytes: [value], valid: valid};
        }

        function loadGmslOutput(value) {
            return setInputFromHexValue(
                'guide_gmsl_output',
                value,
                0,
                3
            );
        }

        function getGmslOutputBytes() {
            const {value, valid} = getHexValueFromInput(
                'guide_gmsl_output',
                0,
                3,
            );

            return {bytes: [value], valid: valid};
        }

        function loadCan(name) {
            // if the payload type is not CAN, only reset the can values
            if (payloadSelect.value !== '1') {
                loadSimulation('00');
                loadSimulationId('00', '00');
                loadIsoTp('00', '00');
                loadMultiplicationX('00');
                loadMultiplicationY('00');
                return true;
            }

            const bytesCountNumberValue = Number(document.getElementById(name + '_byte_count').value);
            let valuesAreValid = true;

            if (!loadSimulation(getByteValue(name, 8))) {
                valuesAreValid = false;
            }

            if (!loadSimulationId(getByteValue(name, 9), getByteValue(name, 10))) {
                valuesAreValid = false;
            }

            if (!loadIsoTp(getByteValue(name, 11), getByteValue(name, 12))) {
                valuesAreValid = false;
            }

            if (!loadMultiplicationX(getByteValue(name, 13))) {
                valuesAreValid = false;
            }

            if (!loadMultiplicationY(getByteValue(name, 14))) {
                valuesAreValid = false;
            }

            // byte 15 is reserved

            if (!loadScreenRotation(getByteValue(name, 16))) {
                valuesAreValid = false;
            }

            // 16 labeled bytes => 13 bytes = 16 - 3 for IEEE ID
            if (bytesCountNumberValue < 13) {
                valuesAreValid = false;
            }

            return valuesAreValid;
        }

        function getCanBytes() {
            let valuesAreValid = true;
            let bytes = [];

            const {bytes: simulationBytes, valid: simulationValid} = getSimulationBytes();
            if (!simulationValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(simulationBytes);
            }

            const {bytes: simulationIdBytes, valid: simulationIdValid} = getSimulationIdBytes();
            if (!simulationIdValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(simulationIdBytes);
            }

            const {bytes: isoTpBytes, valid: isoTpValid} = getIsoTpBytes();
            if (!isoTpValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(isoTpBytes);
            }

            const {bytes: multiplicationXBytes, valid: multiplicationXValid} = getMultiplicationXBytes();
            if (!multiplicationXValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(multiplicationXBytes);
            }

            const {bytes: multiplicationYBytes, valid: multiplicationYValid} = getMultiplicationYBytes();
            if (!multiplicationYValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(multiplicationYBytes);
            }

            // byte 15 is reserved
            bytes = bytes.concat('00');

            const {bytes: rotationBytes, valid: rotationValid} = getScreenRotationBytes();
            if (!rotationValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(rotationBytes);
            }

            return {bytes: bytes, valid: valuesAreValid};
        }

        function loadVideoParams(name) {
            // if te payload type is not video params, only reset the values
            if (payloadSelect.value !== '2') {
                loadOutputInterface('00');
                loadProcessedPixels('00');
                loadColorMapping('00');
                loadLinkCount('00');
                loadLinkRate('00');
                loadFec('00');
                loadStreamId('00');
                loadGmslOutput('00');
                return true;
            }

            const bytesCountNumberValue = Number(document.getElementById(name + '_byte_count').value);
            let valuesAreValid = true;

            if (!loadOutputInterface(getByteValue(name, 8))) {
                valuesAreValid = false;
            }
            if (!loadProcessedPixels(getByteValue(name, 9))) {
                valuesAreValid = false;
            }
            if (!loadColorMapping(getByteValue(name, 10))) {
                valuesAreValid = false;
            }

            const outputInterfaceValue = document.getElementById('guide_output_interface').value;

            if (outputInterfaceValue === '2') {
                // if the output interface is FPD link III
                if (!loadLinkCount(getByteValue(name, 11))) {
                    valuesAreValid = false;
                }

                // 11 labeled bytes => 8 bytes = 11 - 3 for IEEE ID
                if (bytesCountNumberValue < 8) {
                    valuesAreValid = false;
                }
            } else if (outputInterfaceValue === '5' || outputInterfaceValue === '6') {
                // if the output interface is GMSL 2 or GMSL 3
                if (!loadLinkRate(getByteValue(name, 11))) {
                    valuesAreValid = false;
                }
                if (!loadFec(getByteValue(name, 12))) {
                    valuesAreValid = false;
                }
                if (!loadStreamId(getByteValue(name, 13))) {
                    valuesAreValid = false;
                }
                if (!loadGmslOutput(getByteValue(name, 14))) {
                    valuesAreValid = false;
                }

                // 14 labeled bytes => 11 bytes = 14 - 3 for IEEE ID
                if (bytesCountNumberValue < 11) {
                    valuesAreValid = false;
                }
            } else {
                // reset the values
                loadLinkCount('00');
                loadLinkRate('00');
                loadFec('00');
                loadStreamId('00');
                loadGmslOutput('00');

                // 10 labeled bytes => 7 bytes = 10 - 3 for IEEE ID
                if (bytesCountNumberValue < 7) {
                    valuesAreValid = false;
                }
            }

            return valuesAreValid;
        }

        function getVideoParamsBytes() {
            let valuesAreValid = true;
            let bytes = [];

            const {bytes: outputInterfaceBytes, valid: outputInterfaceValid} = getOutputInterfaceBytes();
            if (!outputInterfaceValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(outputInterfaceBytes);
            }

            const {bytes: processedPixelsBytes, valid: processedPixelsValid} = getProcessedPixelsBytes();
            if (!processedPixelsValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(processedPixelsBytes);
            }

            const {bytes: colorMappingBytes, valid: colorMappingValid} = getColorMappingBytes();
            if (!colorMappingValid) {
                valuesAreValid = false;
            } else {
                bytes = bytes.concat(colorMappingBytes);
            }

            if (outputInterfaceBytes[0] === '02') {
                // ldap III interface
                const {bytes: linkCountBytes, valid: linkCountValid} = getLinkCountBytes();
                if (!linkCountValid) {
                    valuesAreValid = false;
                } else {
                    bytes = bytes.concat(linkCountBytes);
                }
            } else if (outputInterfaceBytes[0] === '05' || outputInterfaceBytes[0] === '06') {
                // gmsl 2 or gmsl3 interface
                const {bytes: linkRateBytes, valid: linkRateValid} = getLinkRateBytes();
                if (!linkRateValid) {
                    valuesAreValid = false;
                } else {
                    bytes = bytes.concat(linkRateBytes);
                }

                const {bytes: fecBytes, valid: fecValid} = getFecBytes();
                if (!fecValid) {
                    valuesAreValid = false;
                } else {
                    bytes = bytes.concat(fecBytes);
                }

                const {bytes: streamIdBytes, valid: streamIdValid} = getStreamIdBytes();
                if (!streamIdValid) {
                    valuesAreValid = false;
                } else {
                    bytes = bytes.concat(streamIdBytes);
                }

                const {bytes: gmslOutputBytes, valid: gmslOutputValid} = getGmslOutputBytes();
                if (!gmslOutputValid) {
                    valuesAreValid = false;
                } else {
                    bytes = bytes.concat(gmslOutputBytes);
                }
            }

            return {bytes: bytes, valid: valuesAreValid};
        }

        function loadDataFromBytes(name) {
            let hasInvalidValues = false;

            // check for DQ characters in header
            const byte4Value = Number('0x' + getByteValue(name, 4));
            const byte5Value = Number('0x' + getByteValue(name, 5));
            if (byte4Value !== 'D'.charCodeAt(0) || byte5Value !== 'Q'.charCodeAt(0)) {
                hasInvalidValues = true;
            }

            if(!loadPayloadType(getByteValue(name, 6))) {
                hasInvalidValues = true;
            }

            // workaround for default major and minor versions
            const defaultMajorVersionHex = '{{ base_convert(config('app.vendor_guide.default_major'), 10, 16) }}';
            const defaultMinorVersionHex = '{{ base_convert(config('app.vendor_guide.default_minor'), 10, 16) }}';

            if(!loadVersions(getByteValueWithDefault(name, 7, defaultMajorVersionHex + defaultMinorVersionHex))) {
                hasInvalidValues = true;
            }

            if(!loadCan(name)) {
                hasInvalidValues = true;
            }

            if(!loadVideoParams(name)) {
                hasInvalidValues = true;
            }

            // show warning only if there are some bytes present
            const bytesCount = document.getElementById(name + '_byte_count').value;
            if (hasInvalidValues && bytesCount !== '0') {
                invalidDataLoadedError.classList.remove('d-none');
            } else {
                invalidDataLoadedError.classList.add('d-none');
            }
        }

        function saveToBytes(name) {
            const letterDHex = 'D'.charCodeAt(0).toString(16).padStart(2, '0');
            const letterQHex = 'Q'.charCodeAt(0).toString(16).padStart(2, '0');

            let bytesToWrite = [letterDHex, letterQHex];
            let hasInvalidValues = false;

            const {bytes: payloadBytes, valid: payloadValid} = getPayloadTypeBytes();
            if (!payloadValid) {
                hasInvalidValues = true;
            } else {
                bytesToWrite = bytesToWrite.concat(payloadBytes);
            }

            const {bytes: versionsBytes, valid: versionsValid} = getVersionsBytes();
            if (!versionsValid) {
                hasInvalidValues = true;
            } else {
                bytesToWrite = bytesToWrite.concat(versionsBytes);
            }

            if (payloadValid) {
                if (payloadBytes[0] === '01') {
                    const {bytes: canBytes, valid: canValid} = getCanBytes();
                    if (!canValid) {
                        hasInvalidValues = true;
                    } else {
                        bytesToWrite = bytesToWrite.concat(canBytes);
                    }
                } else {
                    const {bytes: videoParamsBytes, valid: videoParamsValid} = getVideoParamsBytes();
                    if (!videoParamsValid) {
                        hasInvalidValues = true;
                    } else {
                        bytesToWrite = bytesToWrite.concat(videoParamsBytes);
                    }
                }
            }

            if (!hasInvalidValues) {
                const bytesCountElement = document.getElementById(name + '_byte_count');
                const addByteButton = document.getElementById('btn_add_byte_' + name);
                const removeByteButton = document.getElementById('btn_remove_byte_' + name);

                bytesCountElement.value = bytesToWrite.length;
                addByteButton.classList.remove('disabled');
                removeByteButton.classList.remove('disabled');

                // iterate over all byte inputs
                for (let i = 0; i < 28; i++) {
                    const byteWrapperElement = document.getElementById(name + '_' + i + '_wrapper');
                    const byteElement = document.getElementById(name + '_' + i);

                    // the byte should be written to
                    if (i < bytesToWrite.length) {
                        byteWrapperElement.classList.remove('d-none');
                        byteElement.disabled = false;
                        byteElement.value = bytesToWrite[i];
                    } else {
                        byteWrapperElement.classList.add('d-none');
                        byteElement.disabled = true;
                    }
                }

                // simulate modal close click
                document.getElementById('modal-close').dispatchEvent(new Event('click'));
            }
        }

        function init() {
            guideModal.addEventListener('show.bs.modal', e => {
                const button = e.relatedTarget;
                const target = button.dataset.target;
                targetInput.value = target;

                loadDataFromBytes(target);
                payloadSelect.dispatchEvent(new Event('change'));
                outputInterfaceSelect.dispatchEvent(new Event('change'));
                simulationIdSelect.dispatchEvent(new Event('change'));
                isoTpSelect.dispatchEvent(new Event('change'));
            });

            guideApplyButton.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();

                e.target.disabled = true;
                saveToBytes(targetInput.value);
                e.target.disabled = false;
            });

            // switch payload type
            payloadSelect.addEventListener('change', () => {
                if (payloadSelect.value === '1') {
                    canSimulationSection.classList.remove('d-none');
                    videoParamsSection.classList.add('d-none');
                } else {
                    canSimulationSection.classList.add('d-none');
                    videoParamsSection.classList.remove('d-none');
                }
            });

            // custom simulation ID
            simulationIdSelect.addEventListener('change', () => {
                customSimulationId.disabled = simulationIdSelect.value !== '-1';
            });

            // custom ISO TP
            isoTpSelect.addEventListener('change', () => {
                customIsoTp.disabled = isoTpSelect.value !== '-1';
            });

            // switch video params subsections based on output interface
            outputInterfaceSelect.addEventListener('change', () => {
                const value = outputInterfaceSelect.value;
                if (value === '2') { // FPD Link 3 is selected
                    fpd3Section.classList.remove('d-none');
                    gmslSection.classList.add('d-none');
                } else if (value === '5' || value === '6') { // GMSL 2 or GMSL 3 is selected
                    fpd3Section.classList.add('d-none');
                    gmslSection.classList.remove('d-none');
                } else {
                    fpd3Section.classList.add('d-none');
                    gmslSection.classList.add('d-none');
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    </script>
@endpushonce
