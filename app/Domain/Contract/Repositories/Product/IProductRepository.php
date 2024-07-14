<?php

namespace App\Domain\Contract\Repositories\Product;

interface IProductRepository extends
    IListProduct,
    IShowProduct,
    IStoreProduct,
    IUpdateProduct,
    IDestroyProduct,
    IGetByNameProduct,
    IAttachTypes,
    IDetachTypes
{
}
