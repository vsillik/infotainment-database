<div class="form-check">
    <x-forms.standalone-checkbox
        :name="$name"
        :value="$value"
        :isCheckedByDefault="$isCheckedByDefault"
        :isDisabled="$isDisabled"
        {{ $attributes }}
    />

    <label for="{{ $name }}" class="form-check-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @if($extraText !== null)
        <div class="form-text">
            {{ $extraText }}
        </div>
    @endif
</div>
