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

        $start_date = $value['start_date'] ?? null;
        $end_date = $value['end_date'] ?? null;

        try {

            if ($start_date) {
                $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                $query->whereDate('data_os', '>=', $start_date);
            }

            if ($end_date) {
                $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');
                $query->whereDate('data_os', '<=',$end_date);
            }

        } catch (\Exception $e) {

        }
    }
}
