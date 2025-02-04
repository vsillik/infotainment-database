@php
    use App\Models\User;
    use App\UserRole;
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Users
    </x-slot:title>

    <p>
        Default admin user can't be deleted and can't be unapproved.
        You can mark the user as deleted, this will prevent the user from logging in and showing up in infotainment
        assignments. Deleting will also mark the user as unapproved. If you accidentally delete an user, you can
        recover the account on <a href="{{ route('users.deleted') }}">Show deleted</a> page, you can also permanently
        delete the user from this application there.
    </p>

    @can('create', User::class)
        <x-action-buttons.create :targetUrl="route('users.create')" label="Create user"/>
    @endcan

    <a class="btn btn-secondary mb-2" href="{{ route('users.deleted') }}">Show deleted</a>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        {{ Str::limit($user->email, 35) }}

                        @if($user->is_approved)
                            <span class="badge rounded-pill text-bg-success">Approved</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($user->name, 40) }}</td>
                    <td>{{ $user->role->toHumanReadable() }}</td>
                    <td class="text-end">
                        @if($user->role === UserRole::CUSTOMER)
                            @can('assignInfotainments', $user)
                                <x-action-buttons.assign
                                    :targetUrl="route('users.assign-infotainments', $user)"
                                    label="Assign infotainments"
                                />
                            @endcan
                        @endif

                        @if($user->is_approved)
                            @can('unapprove', $user)
                                <x-action-buttons.unapprove :targetUrl="route('users.unapprove', $user)"/>
                            @endcan
                        @else
                            @can('approve', $user)
                                <x-action-buttons.approve :targetUrl="route('users.approve', $user)"/>
                            @endcan
                        @endif

                        @can('update', $user)
                            <x-action-buttons.edit :targetUrl="route('users.edit', $user)"/>
                        @endcan

                        @can('delete', $user)
                            <x-action-buttons.delete
                                :targetUrl="route('users.destroy', $user)"
                                confirmSubject="user {{ $user->email }}"/>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        No user found.
                        @can('create', User::class)
                            <a href="{{ route('users.create') }}">Add user</a>
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
