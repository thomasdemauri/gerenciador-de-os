<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DataOsFilter implements Filter
{

    /**
     * @inheritDoc
     */
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        try {
            $date = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            $query->whereDate('data_os', $date);
        } catch (\Exception $e) {

        }
    }
}
