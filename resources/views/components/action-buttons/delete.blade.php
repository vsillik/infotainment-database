<form action="{{ $targetUrl }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">{{ $label }}</button>
</form>
