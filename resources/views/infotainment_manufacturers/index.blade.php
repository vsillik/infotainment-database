@php
    use App\Models\InfotainmentManufacturer;
    use Illuminate\Support\Str;
@endphp

<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Infotainment manufacturers
    </x-slot:title>

    @can('create', InfotainmentManufacturer::class)
        <x-action-buttons.create :targetUrl="route('infotainment_manufacturers.create')"
                                 label="Create infotainment manufacturer"/>
    @endcan

    <form action="{{ route('infotainment_manufacturers.index') }}" method="GET" id="filter-form">
        @if($perPageQuery)
            <input type="hidden" name="per_page" value="{{ $perPageQuery }}">
        @endif
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th class="text-end">Actions</th>
            </tr>
            @if(count($infotainmentManufacturers) > 0 || $hasActiveFilters)
                <tr class="align-top">
                    <td>
                        <x-forms.standalone-input name="name"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['name'] ?? null"
                        />
                    </td>
                    <td>
                        <div class="row mb-1">
                            <div class="col-2 col-form-label col-form-label-sm">
                                From
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="created_from"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['created_from'] ?? null"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 col-form-label col-form-label-sm">
                                To
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="created_to"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['created_to'] ?? null"
                                />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row mb-1">
                            <div class="col-2 col-form-label col-form-label-sm">
                                From
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="updated_from"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['updated_from'] ?? null"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 col-form-label col-form-label-sm">
                                To
                            </div>
                            <div class="col-10">
                                <x-forms.standalone-input name="updated_to"
                                                          class="form-control-sm"
                                                          form="filter-form"
                                                          type="date"
                                                          :defaultValue="$filters['updated_to'] ?? null"
                                />
                            </div>
                        </div>
                    </td>
                    <td class="text-end">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter-form">Filter
                        </button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('infotainment_manufacturers.index', ['per_page' => $perPageQuery]) }}"
                               class="btn btn-sm btn-outline-danger">Clear</a>
                        @endif
                    </td>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($infotainmentManufacturers as $infotainmentManufacturer)
                <tr>
                    <td>{{ Str::limit($infotainmentManufacturer->name, 70) }}</td>
                    <td>
                        <x-audit-date :timestamp="$infotainmentManufacturer->created_at"
                                      :by="$infotainmentManufacturer->createdBy"
                        />
                    </td>
                    <td>
                        <x-audit-date :timestamp="$infotainmentManufacturer->updated_at"
                                      :by="$infotainmentManufacturer->updatedBy"
                        />
                    </td>
                    <td class="text-end">
                        @can('view', $infotainmentManufacturer)
                            <x-action-buttons.show :targetUrl="route('infotainment_manufacturers.show', $infotainmentManufacturer)"/>
                        @endcan

                        @can('update', $infotainmentManufacturer)
                            <x-action-buttons.edit
                                :targetUrl="route('infotainment_manufacturers.edit', $infotainmentManufacturer)"/>
                        @endcan

                        @can('delete', $infotainmentManufacturer)
                            <x-action-buttons.delete
                                :targetUrl="route('infotainment_manufacturers.destroy', $infotainmentManufacturer)"
                                confirmSubject="infotainment manufacturer {{$infotainmentManufacturer->name}}"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        No infotainment manufacturer found.
                        @if($hasActiveFilters)
                            Try <a href="{{ route('infotainment_manufacturers.index', ['per_page' => $perPageQuery]) }}">resetting filters</a>.
                        @else
                            @can('create', InfotainmentManufacturer::class)
                                <a href="{{ route('infotainment_manufacturers.create') }}">
                                    Add infotainment manufacturer
                                </a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $infotainmentManufacturers->links() }}
</x-layout>
