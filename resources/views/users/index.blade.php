<x-layout>
    <x-slot:title>
        Users
    </x-slot:title>

    @can('create', \App\Models\User::class)
        <x-action-buttons.create :targetUrl="route('users.create')" label="Create user"/>
    @endcan

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        {{ $user->email }}

                        @if($user->is_approved)
                            <span class="badge rounded-pill text-bg-success">Approved</span>
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role->toHumanReadable() }}</td>
                    <td>
                        @if ($user->id !== 1)
                            @if($user->is_approved)
                                @can('unapprove', $user)
                                    <x-action-buttons.unapprove :targetUrl="route('users.unapprove', $user)" />
                                @endcan
                            @else
                                @can('approve', $user)
                                    <x-action-buttons.approve :targetUrl="route('users.approve', $user)" />
                                @endcan
                            @endif
                        @endif

                        @can('update', $user)
                            <x-action-buttons.edit :targetUrl="route('users.edit', $user)" />
                        @endcan

                        @if($user->id !== 1)
                            @can('delete', $user)
                                <x-action-buttons.delete :targetUrl="route('users.destroy', $user)" />
                            @endcan
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        No user found.
                        @can('create', \App\Models\User::class)
                            <a href="{{ route('users.create') }}">Add user</a>
                        @endcan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
