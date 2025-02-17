@php
    use App\Models\SerializerManufacturer;
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Serializer manufacturers
    </x-slot:title>

    @can('create', SerializerManufacturer::class)
        <x-action-buttons.create :targetUrl="route('serializer_manufacturers.create')"
                                 label="Create serializer manufacturer"/>
    @endcan

    <form action="{{ route('serializer_manufacturers.index') }}" method="GET" id="filter-form"></form>

    <div class="table-responsive">
        <table class="table">
            @if(count($serializerManufacturers) > 0 || $hasActiveFilters)
                <thead>
                <tr>
                    <th>Identifier</th>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>
                        <x-forms.standalone-input name="identifier"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['identifier'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-input name="name"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  :defaultValue="$filters['name'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-input name="created_at"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  type="date"
                                                  :defaultValue="$filters['created_at'] ?? null"
                        />
                    </td>
                    <td>
                        <x-forms.standalone-input name="updated_at"
                                                  class="form-control-sm"
                                                  form="filter-form"
                                                  type="date"
                                                  :defaultValue="$filters['updated_at'] ?? null"
                        />
                    </td>

                    <td>
                        <button type="submit" class="btn btn-sm btn-outline-secondary" form="filter-form">Filter
                        </button>
                        @if ($hasActiveFilters)
                            <a href="{{ route('serializer_manufacturers.index') }}"
                               class="btn btn-sm btn-outline-danger">Clear</a>
                        @endif
                    </td>
                </tr>
                </thead>
            @endif
            <tbody>
            @forelse($serializerManufacturers as $serializerManufacturer)
                <tr>
                    <td>{{ $serializerManufacturer->id }}</td>
                    <td>{{ Str::limit($serializerManufacturer->name, 70) }}</td>
                    <td>
                        <x-audit-date :timestamp="$serializerManufacturer->created_at"
                                      :by="$serializerManufacturer->createdBy"
                        />
                    </td>
                    <td>
                        <x-audit-date :timestamp="$serializerManufacturer->updated_at"
                                      :by="$serializerManufacturer->updatedBy"
                        />
                    </td>
                    <td>
                        @can('update', $serializerManufacturer)
                            <x-action-buttons.edit
                                :targetUrl="route('serializer_manufacturers.edit', $serializerManufacturer)"/>
                        @endcan

                        @can('delete', $serializerManufacturer)
                            <x-action-buttons.delete
                                :targetUrl="route('serializer_manufacturers.destroy', $serializerManufacturer)"
                                confirmSubject="serializer manufacturer {{ $serializerManufacturer->name }}"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        No serializer manufacturer found.
                        @if($hasActiveFilters)
                            Try <a href="{{ route('serializer_manufacturers.index') }}">resetting filters</a>.
                        @else
                            @can('create', SerializerManufacturer::class)
                                <a href="{{ route('serializer_manufacturers.create') }}">Add serializer manufacturer</a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($serializerManufacturers->hasPages())
        <div class="mt-2">
            {{ $serializerManufacturers->links() }}
        </div>
    @endif
</x-layout>
