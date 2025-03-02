<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment manufacturer
    </x-slot:title>

    <h4>Name</h4>
    <p class="text-break">{{ $infotainmentManufacturer->name }}</p>

    <h4>Internal notes</h4>
    <p class="text-break">{{ $infotainmentManufacturer->internal_notes ?? 'N/A' }}</p>

    <h4>Created at</h4>
    <p>
        <x-audit-date :timestamp="$infotainmentManufacturer->created_at" :by="$infotainmentManufacturer->createdBy" />
    </p>

    <h4>Updated at</h4>
    <p>
        <x-audit-date :timestamp="$infotainmentManufacturer->updated_at" :by="$infotainmentManufacturer->updatedBy" />
    </p>
</x-layout>
