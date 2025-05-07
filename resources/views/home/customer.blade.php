<x-welcome-layout :breadcrumbs="$breadcrumbs">
    <h3>How to download an E-EDID profile file</h3>
    <ol>
        <li>
            <p>
                Find the infotainment you are looking for <a href="{{ route('infotainments.index') }}">here</a>.<br>
                <span class="text-secondary">If you can't find the infotainment you are looking for, consider contacting the administrator at {{ config('app.admin_email') }}.</span>
            </p>
        </li>
        <li>
            <p>
                In the infotainments list, select the <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> button in the "Actions" column to display the details of the infotainment.
            </p>
        </li>
        <li>
            <p>
                In the infotainment details, you can download the E-EDID profile by clicking on the <span class="btn btn-success btn-sm disabled opacity-75">Download EDID</span> button in the "Actions" column.
            </p>
        </li>
    </ol>
</x-welcome-layout>
