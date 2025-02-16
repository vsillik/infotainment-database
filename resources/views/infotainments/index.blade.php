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

    <form action="{{ route('infotainments.index') }}" method="GET" id="filter"></form>

    <div class="table-responsive">
        <table class="table">

            @if(count($infotainments) > 0 || $hasActiveFilters)
                <thead>
                <tr>
                    @can('assignUsers', Infotainment::class)
                        <th class="text-center">Select</th>
                    @endcan

                    <th>Infotainment manufacturer</th>

                    @if($displayAdvancedColumns)
                        <th>Serializer manufacturer</th>
                        <th>Product ID</th>
                    @endif

                    <th>Model year</th>
                    <th>Part number</th>
                    <th>Actions</th>
                </tr>
                <tr class="align-top">
                    @can('assignUsers', Infotainment::class)
                        <td></td>
                    @endcan

                    <td>
                        <x-forms.standalone-input name="infotainment_manufacturer_name"
                                                  class="form-control-sm"
                                                  form="filter"
                                                  :defaultValue="$filters['infotainment_manufacturer_name'] ?? null"
                        />
                    </td>

                    @if($displayAdvancedColumns)
                        <td>
                            <x-forms.standalone-input name="serializer_manufacturer_name"
                                                      class="form-control-sm"
                                                      form="filter"
                                                      :defaultValue="$filters['serializer_manufacturer_name'] ?? null"
                            />
                        </td>
                        <td>
                            <x-forms.standalone-input name="product_id"
                                                      class="form-control-sm"
                                                      form="filter"
                                                      :defaultValue="$filters['product_id'] ?? null"
                            />
                        </td>
                    @endif

                    <td>
                        <x-forms.standalone-input name="model_year"
                                                  class="form-control-sm"
                                                  form="filter"
                                                  :defaultValue="$filters['model_year'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-input name="part_number"
                                                  class="form-control-sm"
                                                  form="filter"
                                                  :defaultValue="$filters['part_number'] ?? null"
                        />
                    </td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter">Filter</button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('infotainments.index') }}" class="btn btn-sm btn-outline-danger">Reset</a>
                        @endif
                    </td>
                </tr>
                </thead>
            @endif
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

                    <td>{{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}</td>

                    @if($displayAdvancedColumns)
                        <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                        <td>{{ $infotainment->product_id }}</td>
                    @endif

                    <td>{{ $infotainment->model_year }}</td>
                    <td>{{ $infotainment->part_number }}</td>
                    <td>
                        @can('view', $infotainment)
                            <x-action-buttons.show :targetUrl="route('infotainments.show', $infotainment)"/>
                        @endcan

                        @can('update', $infotainment)
                            <x-action-buttons.edit :targetUrl="route('infotainments.edit', $infotainment)"/>
                        @endcan

                        @can('delete', $infotainment)
                            <x-action-buttons.delete
                                :targetUrl="route('infotainments.destroy', $infotainment)"
                                confirmSubject="infotainment ID: {{ $infotainment->id }}"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        @if($hasActiveFilters)
                            No infotainment found. Try <a href="{{ route('infotainments.index') }}">resetting
                                filters</a>.
                        @else
                            @can('create', Infotainment::class)
                                No infotainment found. <a href="{{ route('infotainments.create') }}">Add
                                    infotainment</a>
                            @else
                                There is no infotainment assigned to your account. If you think this is an error please
                                contact administrator.
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($infotainments->hasPages())
        <div class="mt-2">
            {{ $infotainments->links() }}
        </div>
    @endif

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
