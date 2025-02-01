<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment
    </x-slot:title>

    <h4>Infotainment manufacturer</h4>
    <p class="text-break">{{ $infotainment->infotainmentManufacturer->name }}</p>

    <h4>Serializer manufacturer</h4>
    <p class="text-break">{{ $infotainment->serializerManufacturer->name }}</p>

    <h4>Product ID</h4>
    <p>{{ $infotainment->product_id }}</p>

    <h4>Model year</h4>
    <p>{{ $infotainment->model_year }}</p>

    <h4>Part number</h4>
    <p>{{ $infotainment->part_number }}</p>

    <h3>Infotainment profiles</h3>
    <hr/>

    @if($onlyUnapprovedProfiles)
        <div class="alert alert-warning">
            There were no validated profiles found. Below is list of profiles that were not checked yet and may not be
            working properly, proceed with caution.
        </div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>Profile number</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($infotainmentProfiles as $infotainmentProfile)
            <tr>
                <td>
                    {{ $profileNumbers->get($infotainmentProfile->id) ?? 'N/A' }}

                    @if($infotainmentProfile->extraTiming)
                        <span class="badge rounded-pill text-bg-primary">Extra timing</span>
                    @endif
                </td>
                <td>
                    <x-action-buttons.download targetUrl="#" label="Download EDID"/>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">
                    No infotainment profile found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-layout>
