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

    @can('assignUsers', Infotainment::class)
        <form class="mt-2" id="assignForm" action="{{ route('infotainments.assign') }}" method="POST">
            @csrf
            <a href="#" id="select-all-infotainments" class="btn btn-sm btn-outline-secondary">Select all</a>
            <button type="submit" class="btn btn-sm btn-outline-success">Assign users to selected infotainments</button>
        </form>
    @endcan

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">Select</th>
                <th>Infotainment manufacturer</th>
                <th>Serializer manufacturer</th>
                <th>Product ID</th>
                <th>Model year</th>
                <th>Part number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($infotainments as $infotainment)
                <tr>
                    <td class="text-center">
                        <x-forms.standalone-checkbox
                            name="infotainments[{{ $infotainment->id }}]"
                            :isCheckedByDefault="false"
                            :value="$infotainment->id"
                            form="assignForm"
                            class="select-infotainment"
                        />
                    </td>
                    <td>{{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}</td>
                    <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                    <td>{{ $infotainment->product_id }}</td>
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
                    <td colspan="6">
                        @can('create', Infotainment::class)
                            No infotainment found. <a href="{{ route('infotainments.create') }}">Add infotainment</a>
                        @else
                            There is no infotainment assigned to your account. If you think this is an error please
                            contact administrator.
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @can('assignUsers', Infotainment::class)
        @pushonce('scripts')
            <script>
                function attachSelectAll() {
                    const selectAllButton = document.getElementById('select-all-infotainments');

                    selectAllButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const checkboxes = document.getElementsByClassName('select-infotainment');

                        for (const checkbox of checkboxes) {
                            checkbox.checked = true;
                        }
                    })
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', () => {
                        attachSelectAll();
                    });
                } else {
                    attachSelectAll();
                }
            </script>
        @endpushonce
    @endcan
</x-layout>
