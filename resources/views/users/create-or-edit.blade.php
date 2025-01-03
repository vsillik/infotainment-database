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
            maxLength="255" />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            :defaultValue="$user->email"
            required="true"
            maxLength="1024" />

        <x-forms.input
            name="password"
            type="password"
            label="Password"
            :required="!$user->exists"
            minLength="8" />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
