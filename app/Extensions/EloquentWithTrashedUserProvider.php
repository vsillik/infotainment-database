<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\Eloquent\Builder;

class EloquentWithTrashedUserProvider extends EloquentUserProvider
{
    public function __construct(HasherContract $hasher, $model)
    {
        parent::__construct($hasher, $model);

        $this->withQuery(function (Builder $query) {
            // check if the Builder is capable of returning trashed models
            if (is_callable([$query, 'withTrashed'])) {
                $query = $query->withTrashed();
            }

            return $query;
        });
    }
}
