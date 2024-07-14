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

    private const string DEFAULT_COLUMNS = <<<EOD
        p.id,
        p.name,
        p.price,
        p.created_at,
        p.updated_at,
        json_agg(t.*) as types
    EOD;

    public const string DEFAULT_GROUP_BY = <<<EOD
        p.id,
        p.name,
        p.price,
        p.created_at,
        p.updated_at
    EOD;

    public function list(ListProductQuery $query): array
    {
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->query(
            <<<SQL
                SELECT {$columns}
                FROM products p
                LEFT JOIN product_types pt ON p.id = pt.product_id
                LEFT JOIN types t ON pt.type_id = t.id
                GROUP BY {$groupBy}
                ORDER BY p.{$orderBy}
            SQL
        );
        $stmt->execute();

        $data = $stmt->fetchAll(
            PDO::FETCH_FUNC,
            fn ($id, $name, $price, $createdAt, $updatedAt, $types) => [
                'id'         => $id,
                'name'       => $name,
                'price'      => $price,
                'created_at' => Carbon::parse($createdAt),
                'updated_at' => Carbon::parse($updatedAt),
                'types'      => json_decode($types, true, 512, JSON_THROW_ON_ERROR)
            ]
        );

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
     * @throws \JsonException
     */
    public function show(int $id): ?Product
    {
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->prepare(
            <<<SQL
                SELECT {$columns}
                FROM products p
                LEFT JOIN product_types pt ON p.id = pt.product_id
                LEFT JOIN types t ON pt.type_id = t.id
                WHERE p.id = :id
                GROUP BY {$groupBy}
            SQL
        );

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Product(
            name: $data['name'],
            price: new Decimal((string)$data['price']),
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at']),
            types: json_decode($data['types'], true, 512, JSON_THROW_ON_ERROR)
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
            price: new Decimal((string)$data['price']),
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

    public function attachTypes(array $types): void
    {
        $placeholders = [];
        $values = [];

        foreach ($types as $type) {
            $placeholders[] = "(?, ?)";

            $values[] = $type['product_id'];
            $values[] = $type['type_id'];
        }

        $placeholders = implode(", ", $placeholders);

        $stmt = $this->db->prepare(
            "INSERT INTO product_types (product_id, type_id) VALUES {$placeholders}"
        );

        $stmt->execute($values);
    }

    public function detachTypes(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM product_types WHERE product_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
