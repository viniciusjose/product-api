<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Entities\Sale;
use App\Domain\Exception\Sale\SaleInvalidPriceException;
use App\Domain\Queries\Sale\ListSaleQuery;
use Carbon\Carbon;
use Decimal\Decimal;
use JsonException;
use PDO;

class SaleRepository implements ISaleRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }

    private const string DEFAULT_COLUMNS = <<<EOD
        s.id,
        s.customer,
        s.email,
        s.zip_code,
        s.address,
        s.address_number,
        s.description,
        coalesce(sum(si.price), 0)::numeric(10, 2) as amount,
        coalesce(sum(si.taxes_amount), 0)::numeric(10, 2) as taxes_amount,
        coalesce(sum(si.amount), 0)::numeric(10, 2)       as total_amount,
        CASE WHEN count(si.*) > 0 THEN
            json_agg(json_build_object(
            'id', p.id,
            'name', p.name,
            'quantity', si.quantity,
            'amount', si.price,
            'taxes_amount', si.taxes_amount,
            'total_amount', si.amount
        )) END  as items,
        s.created_at,
        s.updated_at
    EOD;

    public const string DEFAULT_GROUP_BY = <<<EOD
        s.id,
        s.customer,
        s.email,
        s.zip_code,
        s.address,
        s.address_number,
        s.description,
        s.created_at,
        s.updated_at
    EOD;

    public function list(ListSaleQuery $query): array
    {
        $orderBy = implode(', ', $query->orderBy) ?? 'name';
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->query(
            <<<SQL
                SELECT {$columns}
                FROM sales s
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                GROUP BY {$groupBy}
                ORDER BY s.{$orderBy}
            SQL
        );
        $stmt->execute();

        $data = $stmt->fetchAll(
            PDO::FETCH_FUNC,
            fn (
                $id,
                $customer,
                $email,
                $zip_code,
                $address,
                $address_number,
                $description,
                $amount,
                $taxes_amount,
                $total_amount,
                $items,
                $createdAt,
                $updatedAt
            ) => [
                'id'             => $id,
                'amount'         => $amount,
                'customer'       => $customer,
                'email'          => $email,
                'zip_code'       => $zip_code,
                'address'        => $address,
                'address_number' => $address_number,
                'description'    => $description,
                'taxes_amount'   => $taxes_amount,
                'total_amount'   => $total_amount,
                'items'          => $items ? json_decode($items, true, 512, JSON_THROW_ON_ERROR) : [],
                'created_at'     => Carbon::parse($createdAt),
                'updated_at'     => Carbon::parse($updatedAt)
            ]
        );

        if (!$data) {
            return [];
        }

        return $data;
    }

    public function store(Sale $sale): int
    {
        $stmt = $this->db->prepare(
            <<<SQL
                INSERT INTO sales (customer, email, zip_code, address, address_number, description) 
                VALUES (?, ?, ?, ?, ?, ?)
            SQL
        );

        $stmt->execute([
            $sale->getCustomer(),
            $sale->getEmail(),
            $sale->getZipCode(),
            $sale->getAddress(),
            $sale->getAddressNumber(),
            $sale->getDescription()
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @throws JsonException
     */
    public function show(int $id): ?Sale
    {
        $columns = self::DEFAULT_COLUMNS;
        $groupBy = self::DEFAULT_GROUP_BY;

        $stmt = $this->db->prepare(
            <<<SQL
                SELECT {$columns}
                FROM sales s
                LEFT JOIN sale_items si ON s.id = si.sale_id
                LEFT JOIN products p ON si.product_id = p.id
                WHERE s.id = :id
                GROUP BY {$groupBy}
            SQL
        );

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new Sale(
            customer: $data['customer'],
            email: $data['email'],
            zipCode: $data['zip_code'],
            address: $data['address'],
            addressNumber: $data['address_number'],
            id: $data['id'],
            items: $data['items'] ? json_decode($data['items'], true, 512, JSON_THROW_ON_ERROR) : [],
            amount: new Decimal((string)$data['amount']),
            taxesAmount: new Decimal((string)$data['taxes_amount']),
            totalAmount: new Decimal((string)$data['total_amount']),
            description: $data['description'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }

    public function update(Sale $sale): bool
    {
        $id = $sale->getId();
        $customer = $sale->getCustomer();
        $email = $sale->getEmail();
        $zipCode = $sale->getZipCode();
        $address = $sale->getAddress();
        $addressNumber = $sale->getAddressNumber();
        $description = $sale->getDescription();
        $updatedAt = $sale->getUpdatedAt();

        $stmt = $this->db->prepare(
            <<<SQL
                UPDATE sales 
                SET 
                    customer = :customer, 
                    email = :email, 
                    address = :address, 
                    address_number = :address_number, 
                    zip_code = :zip_code, 
                    description = :description, 
                    updated_at = :updatedAt 
                WHERE id = :id
            SQL
        );

        $stmt->bindParam(':customer', $customer);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':zip_code', $zipCode);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':address_number', $addressNumber);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':updatedAt', $updatedAt);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function destroy(int $id): int
    {
        $stmt = $this->db->prepare('DELETE FROM Sales WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
