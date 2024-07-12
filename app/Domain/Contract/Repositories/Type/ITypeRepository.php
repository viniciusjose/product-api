<?php

namespace App\Domain\Contract\Repositories\Type;

interface ITypeRepository extends
    IListType,
    IShowType,
    IStoreType,
    IUpdateType,
    IDestroyType,
    IGetByNameType
{
}
