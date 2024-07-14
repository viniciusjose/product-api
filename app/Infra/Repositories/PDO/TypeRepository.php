<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Queries\Type\ListTypeQuery;
use Carbon\Carbon;
use JsonException;
use PDO;

class TypeRepository implements ITypeRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    private const string DEFAULT_COLUMNS = <<<EOD
        t.id,
        t.name,
        t.description,
        t.created_at,
        t.updated_at,
        json_agg(tx.*) as taxes
    EOD;

    public const string DEFAULT_GROUP_BY = <<<EOD
        t.id,
        t.name,
        t.description,
        t.created_at,
        t.updated_at
    EOD;

    public function list(ListTypeQuery $query): array
    {
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->query(
            <<<SQL
                SELECT {$columns}
                FROM types t
                LEFT JOIN type_taxes tt ON t.id = tt.type_id
                LEFT JOIN taxes tx ON tt.tax_id = tx.id
                GROUP BY {$groupBy}
                ORDER BY t.{$orderBy}
            SQL
        );

        $data = $stmt->fetchAll(
            PDO::FETCH_FUNC,
            fn($id, $name, $description, $createdAt, $updatedAt, $taxes) => [
                'id'          => $id,
                'name'        => $name,
                'description' => $description,
                'created_at'  => Carbon::parse($createdAt),
                'updated_at'  => Carbon::parse($updatedAt),
                'taxes'       => json_decode($taxes, true, 512, JSON_THROW_ON_ERROR)
            ]
        );

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function store(Type $type): int
    {
        $stmt = $this->db->prepare('INSERT INTO types (name, description) VALUES (?, ?)');
        $stmt->execute([$type->getName(), $type->getDescription()]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @throws JsonException
     */
    public function show(int $id): ?Type
    {
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->prepare(
            <<<SQL
                SELECT
                    {$columns}
                FROM types t
                LEFT JOIN type_taxes tt ON t.id = tt.type_id
                LEFT JOIN taxes tx ON tt.tax_id = tx.id 
                WHERE t.id = :id
                GROUP BY {$groupBy}
            SQL
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Type(
            name: $data['name'],
            id: $data['id'],
            description: $data['description'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at']),
            taxes: json_decode($data['taxes'], true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function getByName(string $name): ?Type
    {
        $stmt = $this->db->prepare('SELECT * FROM types WHERE name = ? LIMIT 1');
        $stmt->execute([$name]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Type(
            name: $data['name'],
            id: $data['id'],
            description: $data['description'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    public function update(Type $type): bool
    {
        $id = $type->getId();
        $name = $type->getName();
        $description = $type->getDescription();
        $updatedAt = $type->getUpdatedAt();

        $stmt = $this->db->prepare(
            'UPDATE types SET name = :name, description = :description, updated_at = :updatedAt WHERE id = :id'
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
        $stmt = $this->db->prepare('DELETE FROM types WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function attachTaxes(array $taxes): void
    {
        $placeholders = [];
        $values = [];

        foreach ($taxes as $tax) {
            $placeholders[] = "(?, ?)";

            $values[] = $tax['type_id'];
            $values[] = $tax['tax_id'];
        }
        $placeholders = implode(", ", $placeholders);

        $stmt = $this->db->prepare(
            "INSERT INTO type_taxes (type_id, tax_id) VALUES {$placeholders}"
        );

        $stmt->execute($values);
    }

    public function detachTaxes(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM type_taxes WHERE type_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
