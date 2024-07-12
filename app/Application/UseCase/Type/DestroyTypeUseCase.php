<?php

namespace App\Application\UseCase\Type;

use App\Application\DTO\Type\DestroyTypeInputDto;
use App\Domain\Contract\Repositories\Type\IDestroyType;
use App\Domain\Contract\Repositories\Type\IShowType;
use App\Domain\Exception\Type\TypeDestroyException;
use App\Domain\Exception\Type\TypeNotFoundException;

readonly class DestroyTypeUseCase
{
    public function __construct(
        protected IDestroyType|IShowType $typeRepository
    ) {
    }

    /**
     * @throws TypeNotFoundException
     * @throws TypeDestroyException
     */
    public function handle(DestroyTypeInputDto $input): void
    {
        $Type = $this->typeRepository->show($input->id);

        if ($Type === null) {
            throw new TypeNotFoundException('Product type not found.');
        }

        $deleted = $this->typeRepository->destroy($Type->getId());

        if ($deleted === 0) {
            throw new TypeDestroyException('Product type could not be deleted.');
        }
    }
}
