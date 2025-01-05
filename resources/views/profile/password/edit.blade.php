<x-layout>
    <x-slot:title>
        Update password
    </x-slot:title>

    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="password"
            type="password"
            label="Password"
            required="true"
            minLength="8" />

        <x-forms.input
            name="password_confirmation"
            type="password"
            label="Repeat password"
            required="true"
            minLength="8" />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-layout>
