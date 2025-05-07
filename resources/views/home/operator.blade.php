<x-welcome-layout :breadcrumbs="$breadcrumbs">
    <h3>How to create an infotainment profile</h3>
    <ol>
        <li>
            <p>
                Make sure that the required infotainment manufacturer exists <a href="{{ route('infotainment_manufacturers.index') }}">here</a>.
                If not, you can create the manufacturer by clicking on the button <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment manufacturer</span>.
            </p>
        </li>
        <li>
            <p>
                Make sure that the required serializer manufacturer exists <a href="{{ route('serializer_manufacturers.index') }}">here</a>.
                If not, you can create the manufacturer there by clicking on the button <span class="btn btn-primary btn-sm disabled opacity-75">Create serializer manufacturer</span>.
            </p>
        </li>
        <li>
            <p>
                Make sure that the infotainment for which you want to create the profile exists <a href="{{ route('infotainments.index') }}">here</a>.
                If not, you can create the infotainment there by clicking on the button <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment</span>.
            </p>
        </li>
        <li>
            <p>
                In the "Actions" column, click the button <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> for the infotainment for which you want to add the profile.
            </p>
        </li>
        <li>
            <p>
                In the infotainment detail, you can create a profile either from scratch via the <span class="btn btn-primary btn-sm disabled opacity-75">Create infotainment profile</span> button or by copying
                an existing profile via the button <span class="btn btn-secondary btn-sm disabled opacity-75">Copy</span> in the "Actions" column of the profile.
            </p>
        </li>
    </ol>
</x-welcome-layout>
