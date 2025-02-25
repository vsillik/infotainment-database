<?php

declare(strict_types=1);

namespace App\Paginator;

use App\Paginator\Exceptions\InvalidPageException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator
{
    /**
     * @return array{25: 25, 100: 100, all: "all"}
     */
    public static function perPageOptions(): array
    {
        return [
            25 => 2,
            100 => 100,
            'all' => 'all',
        ];
    }

    /**
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return AbstractPaginator<TModel>
     *
     * @throws InvalidPageException
     */
    public static function paginate(Builder $query, ?string $perPage): AbstractPaginator
    {
        $perPageOptions = self::perPageOptions();

        if ($perPage === null || ! in_array($perPage, $perPageOptions)) {
            $paginatePerPage = current($perPageOptions);
        } else {
            $paginatePerPage = $perPageOptions[$perPage];
        }

        if ($paginatePerPage === 'all') {
            $items = $query->get();
            // otherwise there would be division by 0 when there are no results
            $paginatePerPage = max(1, $items->count());
            $paginator = new LengthAwarePaginator($items, $items->count(), $paginatePerPage);
        } else {
            $paginator = $query->paginate($paginatePerPage);
        }

        if ($paginator->currentPage() > $paginator->lastPage()) {
            throw new InvalidPageException;
        }

        return $paginator->withQueryString();
    }

    /**
     * @return AbstractPaginator<Model>
     */
    public static function emptyPagination(): AbstractPaginator
    {
        return (new LengthAwarePaginator([], 0, 1))->withQueryString();
    }
}
