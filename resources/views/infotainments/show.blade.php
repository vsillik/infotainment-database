@php
    use App\Models\InfotainmentProfile;
@endphp
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

    <h4>Compatible platforms</h4>
    <p class="text-break">{{ $infotainment->compatible_platforms ?? 'N/A' }}</p>

    <h4>Internal code</h4>
    <p>{{ $infotainment->internal_code ?? 'N/A' }}</p>

    <h4>Internal notes</h4>
    <p class="text-break">{{ $infotainment->internal_notes ?? 'N/A' }}</p>

    <h4>Created at</h4>
    <p>
        @if($infotainment->createdBy)
            @date($infotainment->created_at) ({{ $infotainment->createdBy->email }})
        @else
            N/A
        @endif
    </p>

    <h4>Updated at</h4>
    <p>
        @if($infotainment->updatedBy)
            @date($infotainment->updated_at) ({{ $infotainment->updatedBy->email }})
        @else
            N/A
        @endif
    </p>

    <h3>Infotainment profiles</h3>
    <hr/>

    @can('create', InfotainmentProfile::class)
        <x-action-buttons.create :targetUrl="route('infotainments.profiles.create', $infotainment)" label="Create infotainment profile" />
    @endcan

    <table class="table">
        <thead>
        <tr>
            <th>Profile number</th>
            <th>Created at</th>
            <th>Updated at</th>
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

                    @if($infotainmentProfile->is_approved)
                        <span class="badge rounded-pill text-bg-success">Approved</span>
                    @endif
                </td>
                <td>
                    @if($infotainmentProfile->createdBy)
                        @date($infotainmentProfile->created_at) ({{ $infotainmentProfile->createdBy->email }})
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($infotainmentProfile->updatedBy)
                        @date($infotainmentProfile->updated_at) ({{ $infotainmentProfile->updatedBy->email }})
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($infotainmentProfile->is_approved)
                        <x-action-buttons.download targetUrl="#" label="Download EDID" />
                    @else
                        @can('approve', $infotainmentProfile)
                            <x-action-buttons.approve :targetUrl="route('infotainments.profiles.approve', [$infotainment, $infotainmentProfile])" />
                        @endcan

                        @can('update', $infotainmentProfile)
                            <x-action-buttons.edit :targetUrl="route('infotainments.profiles.edit', [$infotainment, $infotainmentProfile])" />
                        @endcan
                    @endif

                    @can('create', InfotainmentProfile::class)
                        <x-action-buttons.copy :targetUrl="route('infotainments.profiles.copy', [$infotainment, $infotainmentProfile])" />
                    @endcan

                    @can('delete', $infotainmentProfile)
                        <x-action-buttons.delete
                            :targetUrl="route('infotainments.profiles.destroy', [$infotainment, $infotainmentProfile])"
                            confirmSubject="infotainment profile ID: {{ $infotainment->id }} (profile number: {{ $profileNumbers->get($infotainmentProfile->id) ?? 'N/A' }})" />
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">
                    No infotainment profile found.
                    @can('create', InfotainmentProfile::class)
                        <a href="{{ route('infotainments.profiles.create', $infotainment) }}">Add infotainment profile</a>
                    @endcan
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-layout>
