@php
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Assign infotainments to <x-shorten-text :text="$user->email" />
    </x-slot:title>

    <p>Select below the infotainments you want to assign to the user.</p>

    <form action="{{ route('users.assign-infotainments.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-forms.errors-alert :errors="$errors"/>

        <div>
            <a href="#"
                @class([
                    'btn-select-all',
                    'btn',
                    'btn-sm',
                    'btn-outline-secondary',
                    'd-none' => count($infotainments) === count($assignedInfotainments),
                ])
            >
                Select all
            </a>
            <a href="#"
                @class([
                    'btn-deselect-all',
                    'btn',
                    'btn-sm',
                    'btn-outline-secondary',
                    'd-none' => count($infotainments) !== count($assignedInfotainments),
                ])
            >
                Deselect all
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center">Assign</th>
                    <th>ID</th>
                    <th>Infotainment manufacturer</th>
                    <th>Model year</th>
                    <th>Part number</th>
                    <th>Diagonal size</th>
                    <th>Resolution</th>
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
                                autocomplete="off"
                            />
                        </td>
                        <td>
                            {{ $infotainment->id }}
                        </td>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

    </form>
</x-layout>
