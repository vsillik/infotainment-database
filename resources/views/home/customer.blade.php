<x-welcome-layout :breadcrumbs="$breadcrumbs">
    <h3>How to download an E-EDID profile file</h3>
    <ol>
        <li>
            <p>
                Find infotainment you are looking for <a href="{{ route('infotainments.index') }}">here</a>. <br>
                <span class="text-secondary">If you can't find infotainment you are looking for, consider contacting administrator at {{ config('app.admin_email') }}.</span>
            <p>
        </li>
        <li>
            <p>
                From there select action <span class="btn btn-outline-primary btn-sm disabled opacity-75">Show</span> in the "Actions" column.
            </p>
        </li>
        <li>
            <p>
                You will be presented with infotainment profile, from there you can select action <span class="btn btn-success btn-sm disabled opacity-75">Download EDID</span> in the "Actions" column and the download of profile file will start.
            </p>
        </li>
    </ol>
</x-welcome-layout>
