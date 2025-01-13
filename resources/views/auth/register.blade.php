<x-guest-layout>
    <x-slot:title>Register</x-slot:title>

    <p class="text-secondary">Already have an account? <a href="{{ route('login') }}">Login instead.</a></p>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="name"
            label="Name"
            extraText="Maximum length 255 characters."
            required="true"
        />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            required="true"
        />

        <x-forms.input
            name="password"
            type="password"
            label="Password"
            extraText="Minimum length 8 characters. Maximum length 72 characters."
            required="true"
        />

        <x-forms.input
            name="password_confirmation"
            type="password"
            label="Repeat password"
            required="true"
        />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</x-guest-layout>
