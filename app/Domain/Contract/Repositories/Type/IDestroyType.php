<?php

namespace App\Domain\Contract\Repositories\Type;

use App\Domain\Entities\Type;

interface IDestroyType
{
    public function destroy(int $id): int;
}
