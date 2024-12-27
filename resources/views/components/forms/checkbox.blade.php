<div class="form-check mb-3">
    <input type="checkbox" name="{{ $name }}"
           value="{{ $value }}" id="{{ $name }}"
           class="form-check-input"
        @checked(old('is_ycrcb_4_4_4', $isCheckedByDefault))
        @required($required)>
    <label for="{{ $name }}" class="form-check-label">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
</div>
