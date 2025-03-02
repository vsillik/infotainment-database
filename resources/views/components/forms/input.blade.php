<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <x-forms.standalone-input :name="$name"
                              :defaultValue="$defaultValue"
                              :type="$type"
                              :suffixText="$suffixText"
                              {{ $attributes }}
    />

    @if($extraText !== null)
        <div class="form-text">
            {{ $extraText }}
        </div>
    @endif
</div>
