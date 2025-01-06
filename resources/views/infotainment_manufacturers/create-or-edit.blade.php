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

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="name"
            label="Name"
            :defaultValue="$infotainmentManufacturer->name"
            required="true"
            maxlength="255"
            />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
