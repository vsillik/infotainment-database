<form action="{{ $targetUrl }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="btn btn-danger btn-sm mb-1"
            onclick="return confirm('Are you sure you want to delete {{ $confirmSubject }}?')">
        {{ $label }}
    </button>
</form>
