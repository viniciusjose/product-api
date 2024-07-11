<?php

namespace App\Domain\Contract\Repositories\ProductType;

interface IProductTypeRepository extends
    IListProductType,
    IShowProductType,
    IStoreProductType,
    IUpdateProductType,
    IDestroyProductType,
    IGetByNameProductType
{
}
