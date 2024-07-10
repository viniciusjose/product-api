<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\ProductType\IProductTypeRepository;
use App\Domain\Entities\ProductType;
use App\Domain\Queries\ProductType\ListProductTypeQuery;
use Carbon\Carbon;
use PDO;

class ProductTypeRepository implements IProductTypeRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    public function list(ListProductTypeQuery $query): array
    {
        $stmt = $this->db->prepare('SELECT * FROM product_types ORDER BY :orderBy');
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $stmt->bindParam(':orderBy', $orderBy);
        $stmt->execute();

        $data = $stmt->fetchAll();

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function store(ProductType $productType): int
    {
        $stmt = $this->db->prepare('INSERT INTO product_types (name, description) VALUES (?, ?)');
        $stmt->execute([$productType->getName(), $productType->getDescription()]);

        return (int)$this->db->lastInsertId();
    }


    public function getByName(string $name): ?ProductType
    {
        $stmt = $this->db->prepare('SELECT * FROM product_types WHERE name = ? LIMIT 1');
        $stmt->execute([$name]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new ProductType(
            name: $data['name'],
            id: $data['id'],
            description: $data['description'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }
}
