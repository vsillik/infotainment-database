@php
    use App\Models\Infotainment;
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainments
    </x-slot:title>

    @can('create', Infotainment::class)
        <x-action-buttons.create :targetUrl="route('infotainments.create')" label="Create infotainment"/>
    @endcan

    @if($infotainments->count() > 0)
        @can('assignUsers', Infotainment::class)
            <div class="mt-1">
                <a href="#" class="btn-select-all btn btn-sm btn-outline-secondary">Select all</a>
                <a href="#" class="btn-deselect-all btn btn-sm btn-outline-secondary d-none">Deselect all</a>
                <a href="{{ route('infotainments.assign') }}" id="assign-infotainments"
                   class="btn btn-sm btn-outline-success">Assign users to selected infotainments</a>
            </div>
        @endcan
    @endif

    <form action="{{ route('infotainments.index') }}" method="GET" id="filter-form">
        @if($perPageQuery)
            <input type="hidden" name="per_page" value="{{ $perPageQuery }}">
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                @can('assignUsers', Infotainment::class)
                    <th class="text-center">Select</th>
                @endcan

                <th>Infotainment manufacturer</th>
                <th>Model year</th>
                <th>Part number</th>
                <th>Diagonal size</th>
                <th>Resolution</th>
                <th class="text-end">Actions</th>
            </tr>
            @if(count($infotainments) > 0 || $hasActiveFilters)
                <tr class="align-top">
                    @can('assignUsers', Infotainment::class)
                        <td></td>
                    @endcan
                    <td>
                        <x-forms.standalone-input name="infotainment_manufacturer_name"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['infotainment_manufacturer_name'] ?? null"
                        />
                    </td>
                    <td>
                        <div class="row mb-1 justify-content-between">
                            <div class="col-auto col-form-label col-form-label-sm">
                                From
                            </div>
                            <div class="col-10" style="max-width: 80px">
                                <x-forms.standalone-input name="model_year_from"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          :defaultValue="$filters['model_year_from'] ?? null"
                                />
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto col-form-label col-form-label-sm">
                                To
                            </div>
                            <div class="col-10" style="max-width: 80px;">
                                <x-forms.standalone-input name="model_year_to"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          :defaultValue="$filters['model_year_to'] ?? null"
                                />
                            </div>
                        </div>
                    </td>
                    <td>
                        <x-forms.standalone-input name="part_number"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['part_number'] ?? null"
                        />
                    </td>
                    <td colspan="2"></td>
                    <td class="text-end">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter-form">Filter
                        </button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('infotainments.index', ['per_page' => $perPageQuery]) }}" class="btn btn-sm btn-outline-danger">Reset</a>
                        @endif
                    </td>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($infotainments as $infotainment)
                <tr>
                    @can('assignUsers', Infotainment::class)
                        <td class="text-center">
                            <x-forms.standalone-checkbox
                                name="infotainments[{{ $infotainment->id }}]"
                                :isCheckedByDefault="false"
                                :value="$infotainment->id"
                                class="select-infotainment"
                                autocomplete="off"
                            />
                        </td>
                    @endcan

                    <td><x-shorten-text :text="$infotainment->infotainmentManufacturer->name" /></td>
                    <td>{{ $infotainment->model_year }}</td>
                    <td>{{ $infotainment->part_number }}</td>
                    <td>
                        @if ($infotainment->latestProfile === null)
                            N/A
                        @else
                            {{ number_format($infotainment->latestProfile->diagonalSize(), 1) }}"
                        @endif
                    </td>
                    <td>
                        @if ($infotainment->latestProfile === null)
                            N/A
                        @else
                            {{ $infotainment->latestProfile->timing->horizontal_pixels }}x{{ $infotainment->latestProfile->timing->vertical_lines }}
                        @endif
                    </td>
                    <td class="text-end">
                        @can('view', $infotainment)
                            <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)"/>
                        @endcan

                        @can('update', $infotainment)
                            <x-action-buttons.edit :targetUrl="route('infotainments.edit', $infotainment)"/>
                        @endcan

                        @can('delete', $infotainment)
                            <x-action-buttons.delete
                                :targetUrl="route('infotainments.destroy', $infotainment)"
                                confirmSubject="infotainment ID: {{ $infotainment->id }} ({{ $infotainment->part_number }})"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        @if($hasActiveFilters)
                            No infotainment found. Try <a href="{{ route('infotainments.index', ['per_page' => $perPageQuery]) }}">resetting filters</a>.
                        @else
                            @can('create', Infotainment::class)
                                No infotainment found.
                                <a href="{{ route('infotainments.create') }}">Add infotainment</a>
                            @else
                                There is no infotainment assigned to your account. If you think this is an error please
                                contact administrator at {{ config('app.admin_email') }}.
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $infotainments->links() }}

    @can('assignUsers', Infotainment::class)
        @pushonce('scripts')
            <script>
                function attachAssignInfotainmentButton() {
                    const assignInfotainmentsButton = document.getElementById('assign-infotainments');

                    assignInfotainmentsButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const checkboxes = document.getElementsByClassName('select-infotainment');
                        const infotainmentIds = [];

                        for (const checkbox of checkboxes) {
                            if (checkbox.checked) {
                                infotainmentIds.push(checkbox.value);
                            }
                        }

                        let url = assignInfotainmentsButton.href;

                        if (infotainmentIds.length > 0) {
                            url += '?infotainments=' + infotainmentIds.join(',');
                        }

                        window.location.href = url;
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', attachAssignInfotainmentButton);
                } else {
                    attachAssignInfotainmentButton();
                }
            </script>
        @endpushonce
    @endcan
</x-layout>
