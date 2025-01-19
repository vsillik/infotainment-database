<x-welcome-layout :breadcrumbs="$breadcrumbs">
    <h3>How to create an infotainment profile</h3>
    <ol>
        <li>
            <p>
                Make sure that the infotainment manufacturer of the infotainment exists <a href="{{ route('infotainment_manufacturers.index') }}">here</a>.
                If not you can create the manufacturer there by clicking on the <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment manufacturer</span> button.
            <p>
        </li>
        <li>
            <p>
                Make sure that the serializer manufacturer of the infotainment exists <a href="{{ route('serializer_manufacturers.index') }}">here</a>.
                If not you can create the manufacturer there by clicking on the <span class="btn btn-primary btn-sm disabled opacity-75">Create serializer manufacturer</span> button.
            <p>
        </li>
        <li>
            <p>
                Check if the infotainment for which you want to create profile already exists <a href="{{ route('infotainments.index') }}">here</a>.
                If it does not exist, you can create it there by clicking on the <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment</span> button.
            </p>
        </li>
        <li>
            <p>
                At the "Actions" column select <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> action for the infotainment for which you want to add profile.
            </p>
        </li>
        <li>
            <p>
                Then you can create profile either from scratch via the <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment profile</span> button or by copying
                the existing profile via the <span class="btn btn-secondary btn-sm disabled opacity-75">Copy</span> action in "Actions" column of the profile.
            </p>
        </li>
    </ol>
</x-welcome-layout>
