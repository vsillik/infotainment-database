<x-guest-layout>
    <x-slot:title>Reset password</x-slot:title>

    <p class="text-secondary">Forgot password? You can request a password reset link below to be sent to you via email.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <x-forms.input
            name="email"
            type="email"
            label="Email"
            required="true"
        />

        <x-forms.required-note />

        <button type="submit" class="btn btn-primary">Send reset link</button>
    </form>
</x-guest-layout>
