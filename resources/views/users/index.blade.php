<x-layout>
    <x-slot:title>
        Users
    </x-slot:title>

    <x-action-buttons.create :targetUrl="route('users.create')" label="Create user"/>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
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
                    <td>
                        @if ($user->id !== 1)
                            @if($user->is_approved)
                                <x-action-buttons.unapprove :targetUrl="route('users.unapprove', $user)" />
                            @else
                                <x-action-buttons.approve :targetUrl="route('users.approve', $user)" />
                            @endif
                        @endif

                        <x-action-buttons.edit :targetUrl="route('users.edit', $user)" />

                        @if($user->id !== 1)
                            <x-action-buttons.delete :targetUrl="route('users.destroy', $user)" />
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        No user found.
                        <a href="{{ route('users.create') }}">Add user</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
