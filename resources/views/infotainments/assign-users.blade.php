<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Assign users to infotainments
    </x-slot:title>

    @if($errors->hasAny('infotainments', 'infotainments.*'))
    <div class="alert alert-danger">
        There was an error when submitting the data (selected infotainments not found), please try again.
    </div>
    @endif

    @if($errors->hasAny('users', 'users.*'))
    <div class="alert alert-danger">
        You need to select at least one user.
    </div>
    @endif

    <form action="{{ route('infotainments.assign.add') }}" method="POST">
        @csrf
        @method('PATCH')

        <h3>Selected infotainments</h3>
        <p>Below you can see overview of selected infotainments for assignment to users.</p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
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
                        <td>
                            <input type="hidden"
                                   name="infotainments[{{ $infotainment->id }}]"
                                   value="{{ $infotainment->id }}"
                                   autocomplete="off"
                            >
                            {{ Str::limit($infotainment->infotainmentManufacturer->name, 35) }}
                        </td>
                        <td>{{ Str::limit($infotainment->serializerManufacturer->name, 35) }}</td>
                        <td>{{ $infotainment->product_id }}</td>
                        <td>{{ $infotainment->model_year }}</td>
                        <td>{{ $infotainment->part_number }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h3>Select approved customers</h3>
        <p>Below you can select approved customers that you can assign the selected infotainments to.</p>

        <div>
            <a href="#" class="btn-select-all btn btn-sm btn-outline-secondary">Select all</a>
            <a href="#" class="btn-deselect-all btn btn-sm btn-outline-secondary d-none">Deselect all</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center">Select</th>
                    <th>Email</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">
                            <x-forms.standalone-checkbox
                                name="users[{{ $user->id }}]"
                                :isCheckedByDefault="is_array(old('users')) && in_array($user->id, old('users'))"
                                :value="$user->id"
                            />
                        </td>
                        <td>
                            {{ Str::limit($user->email, 35) }}
                        </td>
                        <td>{{ Str::limit($user->name, 40) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
