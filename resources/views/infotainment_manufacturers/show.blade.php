<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment manufacturer
    </x-slot:title>

    <div class="mb-2">
        @can('update', $infotainmentManufacturer)
            <x-action-buttons.edit
                :targetUrl="route('infotainment_manufacturers.edit', $infotainmentManufacturer)"/>
        @endcan


        @can('delete', $infotainmentManufacturer)
            <x-action-buttons.delete
                :targetUrl="route('infotainment_manufacturers.destroy', $infotainmentManufacturer)"
                confirmSubject="infotainment manufacturer {{$infotainmentManufacturer->name}}"/>
        @endcan
    </div>

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
