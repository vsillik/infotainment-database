<x-guest-layout>
    <x-slot:title>Register</x-slot:title>

    <p class="text-secondary">Already have an account? <a href="{{ route('login') }}">Login instead.</a></p>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <x-forms.errors-alert :errors="$errors" />

        <x-forms.input
            name="name"
            label="Name"
            required="true"
            maxlength="255" />

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            required="true"
            maxlength="1024" />

        <!-- TODO: autocomplete same for password and password_confirmation -->
        <x-forms.input
            name="password"
            type="password"
            label="Password"
            required="true"
            minlength="8" />

        <x-forms.input
            name="password_confirmation"
            type="password"
            label="Repeat password"
            required="true"
            minlength="8" />

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</x-guest-layout>
