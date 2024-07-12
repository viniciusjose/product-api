<?php

namespace App\Domain\Contract\Repositories\Product;

interface IDestroyProduct
{
    public function destroy(int $id): int;
}
