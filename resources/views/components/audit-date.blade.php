@if($timestamp !== null)
    @date($timestamp)
    @if($by !== null)
        (<x-shorten-text :text="$by->email" :maxLength="20" />)
    @else
        (N/A)
    @endif
@else
    N/A
@endif
