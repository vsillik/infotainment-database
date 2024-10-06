<x-layout>
    <x-slot:title>
        @if($infotainmentManufacturer->exists)
            Edit infotainment manufacturer
        @else
            Create infotainment manufacturer
        @endif
    </x-slot:title>

    <form action="@if($infotainmentManufacturer->exists)
                    {{ route('infotainment_manufacturers.update', $infotainmentManufacturer) }}
                  @else
                    {{ route('infotainment_manufacturers.store') }}
                  @endif" method="POST">
        @csrf
        @if($infotainmentManufacturer->exists)
            @method('PATCH')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name"
                   value="{{ old('name', $infotainmentManufacturer->name) }}"
                   id="name"
                   @class(['form-control', 'is-invalid' => $errors->has('name')])
                   maxlength="255" required>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
