<form action="{{ $targetUrl  }}" method="POST" class="d-inline-block">
    @csrf
    @method('PATCH')
    <button type="submit"
            class="btn btn-success btn-success btn-sm mb-1">
        {{ $label }}
    </button>
</form>
