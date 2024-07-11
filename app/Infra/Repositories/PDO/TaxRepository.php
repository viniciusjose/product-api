<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Taxes\ITaxRepository;
use App\Domain\Entities\Tax;
use App\Domain\Queries\Taxes\ListTaxesQuery;
use Carbon\Carbon;
use PDO;

class TaxRepository implements ITaxRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    public function list(ListTaxesQuery $query): array
    {
        $stmt = $this->db->prepare('SELECT * FROM taxes ORDER BY :orderBy');
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $stmt->bindParam(':orderBy', $orderBy);
        $stmt->execute();

        $data = $stmt->fetchAll();

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function store(Tax $taxes): int
    {
        $stmt = $this->db->prepare('INSERT INTO taxes (name, percentage) VALUES (?, ?)');
        $stmt->execute([$taxes->getName(), $taxes->getPercentage()]);

        return (int)$this->db->lastInsertId();
    }

    public function show(int $id): ?Tax
    {
        $stmt = $this->db->prepare('SELECT * FROM taxes WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Tax(
            name: $data['name'],
            percentage: $data['percentage'],
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    public function getByName(string $name): ?Tax
    {
        $stmt = $this->db->prepare('SELECT * FROM taxes WHERE name = ? LIMIT 1');
        $stmt->execute([$name]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Tax(
            name: $data['name'],
            percentage: $data['percentage'],
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    public function update(Tax $taxes): bool
    {
        $id = $taxes->getId();
        $name = $taxes->getName();
        $percentage = $taxes->getPercentage();
        $updatedAt = $taxes->getUpdatedAt();

        $stmt = $this->db->prepare(
            'UPDATE taxes SET name = :name, percentage = :percentage, updated_at = :updatedAt WHERE id = :id'
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':percentage', $percentage);
        $stmt->bindParam(':updatedAt', $updatedAt);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function destroy(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM taxes WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
