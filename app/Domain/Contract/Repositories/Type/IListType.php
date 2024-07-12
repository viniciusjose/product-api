<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Queries\Type\ListTypeQuery;

interface IListType
{
    public function list(ListTypeQuery $query): array;
}
