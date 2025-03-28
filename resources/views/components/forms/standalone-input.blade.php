<div @class(['input-group' => $suffixText !== null, 'has-validation' => $suffixText !== null])>
    <input type="{{ $type }}" name="{{ $name }}"
           value="{{ old($name, $defaultValue) }}"
           id="{{ $name }}"
           @disabled($isDisabled)
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name),
        ]) }}
    >

    @if($suffixText !== null)
        <span class="input-group-text">{{ $suffixText }}</span>
    @endif

    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
