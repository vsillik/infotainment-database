<x-layout>
    <x-slot:title>
        Infotainment
    </x-slot:title>

    <h4>Infotainment manufacturer</h4>
    <p>{{ $infotainment->infotainmentManufacturer->name }}</p>

    <h4>Serializer manufacturer</h4>
    <p>{{ $infotainment->serializerManufacturer->name }}</p>

    <h4>Product ID</h4>
    <p>{{ $infotainment->product_id }}</p>

    <h4>Model year</h4>
    <p>{{ $infotainment->model_year }}</p>

    <h4>Part number</h4>
    <p>{{ $infotainment->part_number }}</p>

    <h4>Compatible platforms</h4>
    <p>{{ $infotainment->compatible_platforms }}</p>

    <h4>Internal code</h4>
    <p>{{ $infotainment->internal_code }}</p>

    <h4>Internal notes</h4>
    <p>{{$infotainment->internal_notes }}</p>

    <h3>Infotainment profiles</h3>
    <hr/>

    <x-action-buttons.create :targetUrl="route('infotainments.profiles.create', $infotainment)" label="Create infotainment profile" />

    <table class="table">
        <thead>
        <tr>
            <th>Profile ID</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($infotainmentProfiles as $infotainmentProfile)
            <tr>
                <td>
                    {{ $infotainmentProfile->id }}

                    @if($infotainmentProfile->extraTiming)
                        <span class="badge rounded-pill text-bg-primary">Extra timing</span>
                    @endif

                    @if($infotainmentProfile->is_approved)
                        <span class="badge rounded-pill text-bg-success">Approved</span>
                    @endif
                </td>
                <td>
                    @if($infotainmentProfile->is_approved)
                        <x-action-buttons.download targetUrl="#" label="Download EDID" />
                    @else
                        <x-action-buttons.approve :targetUrl="route('infotainments.profiles.approve', [$infotainment, $infotainmentProfile])" />

                        <x-action-buttons.edit :targetUrl="route('infotainments.profiles.edit', [$infotainment, $infotainmentProfile])" />
                    @endif

                    <x-action-buttons.delete :targetUrl="route('infotainments.profiles.destroy', [$infotainment, $infotainmentProfile])" />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2">
                    No infotainment profile found.
                    <a href="{{ route('infotainments.profiles.create', $infotainment) }}">Add infotainment profile</a>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-layout>
