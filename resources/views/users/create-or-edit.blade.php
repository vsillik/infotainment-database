<x-layout>
    <x-slot:title>
        @if($user->exists)
            Edit user
        @else
            Create user
        @endif
    </x-slot:title>

    <form action="@if($user->exists)
                    {{ route('users.update', $user) }}
                  @else
                    {{ route('users.store') }}
                  @endif" method="POST">
        @csrf
        @if($user->exists)
            @method('PATCH')
        @endif

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="name"
            label="Name"
            :defaultValue="$user->name"
            required="true"
            extraText="Maximum length 255 characters."
        />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            :defaultValue="$user->email"
            required="true"
        />

        <x-forms.input
            name="password"
            type="password"
            label="Password"
            :required="!$user->exists"
            :extraText="sprintf('Minimum length 8 characters. Maximum length 72 characters.%s', $user->exists ? ' This will change password only if not empty.' : '')"
        />

        <x-forms.select
            name="role"
            label="Role"
            :options="$roles"
            :defaultValue="$user->role?->value"
            required="true"
        />

        <x-forms.multiselect
            name="infotainments[]"
            label="Allowed infotainments to display"
            :options="$infotainments"
            :selected="$selectedInfotainments"
        />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
