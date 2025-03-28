<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <x-forms.standalone-select
        :name="$name"
        :options="$options"
        :defaultValue="$defaultValue"
        :isDisabled="$isDisabled"
    />

    @if($extraText !== null)
        <div class="form-text">
            {{ $extraText }}
        </div>
    @endif
</div>
