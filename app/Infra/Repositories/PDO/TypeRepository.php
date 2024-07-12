<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Type\ITypeRepository;
use App\Domain\Entities\Type;
use App\Domain\Queries\Type\ListTypeQuery;
use Carbon\Carbon;
use PDO;

class TypeRepository implements ITypeRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    public function list(ListTypeQuery $query): array
    {
        $stmt = $this->db->prepare('SELECT * FROM types ORDER BY :orderBy');
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $stmt->bindParam(':orderBy', $orderBy);
        $stmt->execute();

        $data = $stmt->fetchAll();

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

    public function show(int $id): ?Type
    {
        $stmt = $this->db->prepare('SELECT * FROM types WHERE id = :id');
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
            updatedAt: Carbon::parse($data['updated_at'])
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
}
