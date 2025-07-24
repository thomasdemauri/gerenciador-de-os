<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomerNameFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        $query->whereHas('customer', function (Builder $query) use ($value) {
           $query->where('full_name', 'like', '%' . $value . '%')
               ->orWhere('nickname', 'like', '%' . $value . '%');
        });
    }
}
