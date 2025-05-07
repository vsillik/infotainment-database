@php
    use Illuminate\Support\Str;
@endphp
@if(mb_strlen($text) > $maxLength)<abbr title="{{ $text }}">{{ Str::limit($text, $maxLength) }}</abbr>@else{{ $text }}@endif
