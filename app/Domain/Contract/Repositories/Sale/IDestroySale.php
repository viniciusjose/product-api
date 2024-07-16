<?php

namespace App\Domain\Contract\Repositories\Sale;

interface IDestroySale
{
    public function destroy(int $id): int;
}
