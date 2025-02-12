<x-guest-layout>
    <x-slot:title>Reset password</x-slot:title>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            required="true"
            :defaultValue="$email"
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

        <button type="submit" class="btn btn-primary">Reset password</button>
    </form>
</x-guest-layout>
