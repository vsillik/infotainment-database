<x-layout>
    <x-slot:title>
            Profile settings
    </x-slot:title>

    <p class="text-secondary">
        You can change your password <a href="{{ route('profile.password.edit') }}">here</a>.
    </p>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="name"
            label="Name"
            :defaultValue="$user->name"
            required="true"
        />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            :defaultValue="$user->email"
            disabled
        />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
