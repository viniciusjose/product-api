<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Product\IProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Exception\Product\ProductInvalidPriceException;
use App\Domain\Queries\Product\ListProductQuery;
use Carbon\Carbon;
use Decimal\Decimal;
use PDO;

class ProductRepository implements IProductRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    public function list(ListProductQuery $query): array
    {
        $stmt = $this->db->prepare('SELECT * FROM products ORDER BY :orderBy');
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $stmt->bindParam(':orderBy', $orderBy);
        $stmt->execute();

        $data = $stmt->fetchAll();

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function store(Product $product): int
    {
        $stmt = $this->db->prepare('INSERT INTO products (name, price) VALUES (?, ?)');
        $stmt->execute([$product->getName(), $product->getPrice()->toFloat()]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @throws ProductInvalidPriceException
     */
    public function show(int $id): ?Product
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Product(
            name: $data['name'],
            price: new Decimal((string) $data['price']),
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    /**
     * @throws ProductInvalidPriceException
     */
    public function getByName(string $name): ?Product
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE name = ? LIMIT 1');
        $stmt->execute([$name]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Product(
            name: $data['name'],
            price: new Decimal((string) $data['price']),
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    public function update(Product $product): bool
    {
        $id = $product->getId();
        $name = $product->getName();
        $price = $product->getPrice()->toFloat();
        $updatedAt = $product->getUpdatedAt();

        $stmt = $this->db->prepare(
            'UPDATE products SET name = :name, price = :price, updated_at = :updatedAt WHERE id = :id'
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':updatedAt', $updatedAt);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function destroy(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
