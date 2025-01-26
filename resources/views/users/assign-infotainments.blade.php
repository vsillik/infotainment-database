@php
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Assign infotainments to {{ Str::limit($user->email, 50) }}
    </x-slot:title>

    <p>Select below the infotainments you want to assign to the user.</p>

    <form action="{{ route('users.assign-infotainments.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-forms.errors-alert :errors="$errors" />

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center">Assign</th>
                    <th>Infotainment manufacturer</th>
                    <th>Serializer manufacturer</th>
                    <th>Product ID</th>
                    <th>Model year</th>
                    <th>Part number</th>
                </tr>
                </thead>
                <tbody>
                @foreach($infotainments as $infotainment)
                    <tr>
                        <td class="text-center">
                            <x-forms.standalone-checkbox
                                name="infotainments[{{ $infotainment->id }}]"
                                :isCheckedByDefault="$assignedInfotainments->contains($infotainment->id)"
                                :value="$infotainment->id"
                            />
                        </td>
                        <td>{{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}</td>
                        <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                        <td>{{ $infotainment->product_id }}</td>
                        <td>{{ $infotainment->model_year }}</td>
                        <td>{{ $infotainment->part_number }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

    </form>
</x-layout>
