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

    public function show(int $id): ?ProductType
    {
        $stmt = $this->db->prepare('SELECT * FROM product_types WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

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

    public function update(ProductType $productType): bool
    {
        $id = $productType->getId();
        $name = $productType->getName();
        $description = $productType->getDescription();
        $updatedAt = $productType->getUpdatedAt();

        $stmt = $this->db->prepare(
            'UPDATE product_types SET name = :name, description = :description, updated_at = :updatedAt WHERE id = :id'
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':updatedAt', $updatedAt);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function destroy(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM product_types WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
