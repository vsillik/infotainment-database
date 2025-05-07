@php
    use App\Models\Infotainment;
    use App\Models\InfotainmentProfile;
@endphp

<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment
    </x-slot:title>

    <div class="mb-2">
        @can('assignUsers', Infotainment::class)
            <x-action-buttons.assign
                :targetUrl="route('infotainments.assign', ['infotainments' => $infotainment->id])"
                label="Assign users"
            />
        @endcan

        @can('update', $infotainment)
            <x-action-buttons.edit :targetUrl="route('infotainments.edit', $infotainment)"/>
        @endcan

        @can('delete', $infotainment)
            <x-action-buttons.delete
                :targetUrl="route('infotainments.destroy', $infotainment)"
                confirmSubject="infotainment ID: {{ $infotainment->id }} ({{ $infotainment->part_number }})"/>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3 class="mb-3">Infotainment parameters</h3>

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
                <x-audit-date :timestamp="$infotainment->created_at" :by="$infotainment->createdBy" />
            </p>

            <h4>Updated at</h4>
            <p>
                <x-audit-date :timestamp="$infotainment->updated_at" :by="$infotainment->updatedBy" />
            </p>
        </div>

        <div id="profile-timing-details" class="col-md-6">
            @if($infotainment->latestProfile !== null)
                <h3 class="mb-3 text-body-secondary">
                    Parameters of latest
                    @if ($infotainment->latestProfile->is_approved)
                        approved
                    @endif
                    profile
                </h3>

                <h4>Diagonal size</h4>
                <p>{{ number_format($infotainment->latestProfile->diagonalSize(), 1) }}"</p>

                <button id="collapse-latest-profile-timings" class="btn btn-secondary btn-sm mb-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#latest-profile-timings" aria-expanded="false"
                        aria-controls="latest-profile-timings">
                    Toggle timing parameters
                </button>

                <div class="collapse" id="latest-profile-timings">
                    <h4>Pixel clock</h4>
                    <p>{{ $infotainment->latestProfile->timing->pixel_clock }}&nbsp;MHz</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Horizontal active</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_pixels }}&nbsp;pixels</p>

                            <h4>Horizontal blank</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_blank }}&nbsp;pixels</p>

                            <h4>Horizontal front porch</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_front_porch }}&nbsp;pixels</p>

                            <h4>Horizontal sync width</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_sync_width }}&nbsp;pixels</p>

                            <h4>Horizontal image size</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_image_size }}&nbsp;mm</p>

                            <h4>Horizontal border</h4>
                            <p>{{ $infotainment->latestProfile->timing->horizontal_border ?? 0 }}&nbsp;pixels</p>

                            <h4>Horizontal signal sync</h4>
                            <p>{{ $infotainment->latestProfile->timing->signal_horizontal_sync_positive ? 'positive' : 'negative' }}</p>
                        </div>
                        <div id="profile-timing-vertical-details" class="col-md-6">
                            <h4>Vertical lines</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_lines }}&nbsp;lines</p>

                            <h4>Vertical blank</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_blank }}&nbsp;lines</p>

                            <h4>Vertical front porch</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_front_porch }}&nbsp;lines</p>

                            <h4>Vertical sync width</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_sync_width }}&nbsp;lines</p>

                            <h4>Vertical image size</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_image_size }}&nbsp;mm</p>

                            <h4>Vertical border</h4>
                            <p>{{ $infotainment->latestProfile->timing->vertical_border ?? 0 }}&nbsp;lines</p>

                            <h4>Vertical signal sync</h4>
                            <p>{{ $infotainment->latestProfile->timing->signal_vertical_sync_positive ? 'positive' : 'negative' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

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
                    <x-audit-date :timestamp="$infotainmentProfile->created_at"
                                  :by="$infotainmentProfile->createdBy"
                    />
                </td>
                <td>
                    <x-audit-date :timestamp="$infotainmentProfile->updated_at"
                                  :by="$infotainmentProfile->updatedBy"
                    />
                </td>
                <td>
                    @can('view', $infotainmentProfile)
                        <x-action-buttons.show :targetUrl="route('infotainments.profiles.show', [$infotainment, $infotainmentProfile])"/>
                    @endcan

                    @if($infotainmentProfile->is_approved)
                        @can('download', $infotainmentProfile)
                            <x-action-buttons.download :targetUrl="route('infotainments.profiles.download', [$infotainment, $infotainmentProfile])" label="Download EDID" />
                        @endcan
                    @else
                        @can('update', $infotainmentProfile)
                            <x-action-buttons.edit :targetUrl="route('infotainments.profiles.edit', [$infotainment, $infotainmentProfile])" />
                        @endcan

                        @can('approve', $infotainmentProfile)
                                <x-action-buttons.approve :targetUrl="route('infotainments.profiles.approve', [$infotainment, $infotainmentProfile])" />
                        @endcan
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
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
