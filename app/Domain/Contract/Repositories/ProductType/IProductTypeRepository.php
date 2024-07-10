<?php

namespace App\Domain\Contract\Repositories\ProductType;

interface IProductTypeRepository extends IStoreProductType, IListProductType, IGetByNameProductType
{
}
