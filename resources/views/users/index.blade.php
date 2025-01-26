@php
    use App\Models\User;
    use App\UserRole;
    use Illuminate\Support\Str;
@endphp
<x-layout :breadcrumbs="$breadcrumbs">
    <x-slot:title>
        Users
    </x-slot:title>

    @can('create', User::class)
        <x-action-buttons.create :targetUrl="route('users.create')" label="Create user"/>
    @endcan

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

                        @if ($user->id !== 1)
                            @if($user->is_approved)
                                @can('unapprove', $user)
                                    <x-action-buttons.unapprove :targetUrl="route('users.unapprove', $user)"/>
                                @endcan
                            @else
                                @can('approve', $user)
                                    <x-action-buttons.approve :targetUrl="route('users.approve', $user)"/>
                                @endcan
                            @endif
                        @endif

                        @can('update', $user)
                            <x-action-buttons.edit :targetUrl="route('users.edit', $user)"/>
                        @endcan

                        @if($user->id !== 1)
                            @can('delete', $user)
                                <x-action-buttons.delete
                                    :targetUrl="route('users.destroy', $user)"
                                    confirmSubject="user {{ $user->email }}"/>
                            @endcan
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
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
