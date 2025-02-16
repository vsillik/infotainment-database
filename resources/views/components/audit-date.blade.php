@if($timestamp !== null)
    @date($timestamp)
    ({{ $by !== null ? $by->email : 'N/A' }})
@else
    N/A
@endif
