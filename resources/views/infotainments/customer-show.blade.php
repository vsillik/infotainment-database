<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment
    </x-slot:title>

    <div class="row">
        <div class="col-md-6">
            <h3 class="mb-3">Infotainment parameters</h3>

            <h4>Infotainment manufacturer</h4>
            <p class="text-break">{{ $infotainment->infotainmentManufacturer->name }}</p>

            <h4>Model year</h4>
            <p>{{ $infotainment->model_year }}</p>

            <h4>Part number</h4>
            <p>{{ $infotainment->part_number }}</p>
        </div>

        <div class="col-md-6">
            @if($infotainment->latestProfile !== null)
                <h3 class="mb-3 text-body-secondary">
                    Parameters of latest
                    @if ($infotainment->latestProfile->is_approved)
                        approved
                    @endif
                    profile
                </h3>

                <h4 class="text-body-secondary">Diagonal size</h4>
                <p>{{ number_format($infotainment->latestProfile->diagonalSize(), 1) }}"</p>
            @endif
        </div>
    </div>


    <h3>Infotainment profiles</h3>
    <hr/>

    @if(count($infotainmentProfiles) > 0 && $onlyUnapprovedProfiles)
        <div class="alert alert-warning">
            There were no validated profiles found. Below is list of profiles that were not checked yet and may not be
            working properly, proceed with caution.
        </div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>Profile number</th>
            <th>Updated at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($infotainmentProfiles as $infotainmentProfile)
            <tr>
                <td>
                    {{ $profileNumbers->get($infotainmentProfile->id) ?? 'N/A' }}

                    @if(!$infotainmentProfile->is_approved)
                        <span class="badge rounded-pill text-bg-warning">Unapproved</span>
                    @endif
                </td>
                <td>
                    @if($infotainmentProfile->updated_at !== null)
                        @date($infotainmentProfile->updated_at)
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @can('download', $infotainmentProfile)
                        <x-action-buttons.download :targetUrl="route('infotainments.profiles.download', [$infotainment, $infotainmentProfile])" label="Download EDID" />
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">
                    No infotainment profile found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</x-layout>
