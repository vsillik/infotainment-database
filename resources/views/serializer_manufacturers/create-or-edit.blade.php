<x-layout>
    <x-slot:title>
        @if($serializerManufacturer->exists)
            Edit serializer manufacturer
        @else
            Create serializer manufacturer
        @endif
    </x-slot:title>

    <form action="@if($serializerManufacturer->exists)
                    {{ route('serializer_manufacturers.update', $serializerManufacturer) }}
                  @else
                    {{ route('serializer_manufacturers.store') }}
                  @endif" method="POST">
        @csrf
        @if($serializerManufacturer->exists)
            @method('PATCH')
        @endif

        <div class="mb-3">
            <label for="id" class="form-label">Identifier</label>
            <input type="text" name="id"
                   value="{{ old('id', $serializerManufacturer->id) }}"
                   id="id"
                   @class(['form-control', 'is-invalid' => $errors->has('name')])
                   minlength="3" maxlength="3" required>
            @error('id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name"
                   value="{{ old('name', $serializerManufacturer->name) }}"
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
