@php
    use App\Paginator\Paginator;

    $perPageOptions = Paginator::perPageOptions();
    $perPageQuery = request()->query('per_page');
@endphp

<nav class="d-flex justify-items-center justify-content-between mt-1">
    <div @class([
        "d-flex",
        "justify-content-between",
        "align-items-center",
        "flex-fill",
        "d-sm-none",
        "flex-row-reverse" => !$paginator->hasPages(),
    ])>
        @if ($paginator->hasPages())
            <ul class="pagination mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            @lang('pagination.previous')
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            @lang('pagination.next')
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        @endif
        <div class="d-flex">
            <label for="per_page" class="col-form-label col-form-label-sm text-muted">Items per page</label>
            <div class="ps-2">
                <x-forms.standalone-select
                    name="per_page"
                    :options="$perPageOptions"
                    :defaultValue="$perPageQuery"
                    class="form-select-sm"
                />
            </div>
        </div>
    </div>

    <div @class([
        "d-none",
        "flex-sm-fill",
        "d-sm-flex",
        "align-items-sm-center",
        "justify-content-sm-between",
        "flex-row-reverse" => !$paginator->hasPages(),
    ])>
        @if ($paginator->hasPages())
            <div>
                <p class="small text-muted mb-0">
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    items
                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                               aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                               aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="d-flex">
            <label for="per_page" class="col-form-label col-form-label-sm text-muted">Items per page</label>
            <div class="ps-2">
                <x-forms.standalone-select
                    name="per_page"
                    :options="$perPageOptions"
                    :defaultValue="$perPageQuery"
                    class="form-select-sm pagination-per-page"
                />
            </div>
        </div>
    </div>
</nav>
