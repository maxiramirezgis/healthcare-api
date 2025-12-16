<?php

declare(strict_types=1);

namespace Lightit\Clinic\Domain\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lightit\Clinic\Domain\Models\Clinic;
use Lightit\Doctor\Domain\Models\Doctor;
use Spatie\QueryBuilder\QueryBuilder;

class ListClinicDoctorsAction
{
    /**
     * @return LengthAwarePaginator<int, Doctor>
     */
    public function execute(Clinic $clinic): LengthAwarePaginator
    {
        return QueryBuilder::for($clinic->doctors())
            ->allowedFilters(['name'])
            ->allowedSorts(['name', 'id'])
            ->orderBy('id', 'desc')
            ->paginate();
    }
}
