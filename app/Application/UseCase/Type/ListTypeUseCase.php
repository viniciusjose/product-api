<?php

namespace App\Application\UseCase\Type;

use App\Domain\Contract\Repositories\Type\IListType;
use App\Domain\Queries\Type\ListTypeQuery;

readonly class ListTypeUseCase
{
    public function __construct(
        protected IListType $typeRepository
    ) {
    }

    public function handle(ListTypeQuery $input): array
    {
        return $this->typeRepository->list($input);
    }
}
