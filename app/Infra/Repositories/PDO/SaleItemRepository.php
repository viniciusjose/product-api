<?php

namespace App\Infra\Repositories\PDO;

use App\Domain\Contract\Repositories\Sale\ISaleRepository;
use App\Domain\Contract\Repositories\SaleItem\ISaleItemRepository;
use App\Domain\Entities\Sale;
use App\Domain\Entities\SaleItem;
use App\Domain\Exception\SaleItem\SaleItemInvalidFieldException;
use App\Domain\Queries\Sale\ListSaleQuery;
use Carbon\Carbon;
use Decimal\Decimal;
use JsonException;
use PDO;

class SaleItemRepository implements ISaleItemRepository
{
    public function __construct(
        protected PDO $db
    ) {
    }


    public function store(SaleItem $saleItem): int
    {
        $stmt = $this->db->prepare(
            <<<SQL
                INSERT INTO sale_items 
                (sale_id, product_id, quantity, price, taxes_amount, amount, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            SQL
        );

        $stmt->execute([
            $saleItem->getSaleId(),
            $saleItem->getProductId(),
            $saleItem->getQuantity(),
            $saleItem->getPrice()->toFloat(),
            $saleItem->getTaxesAmount()->toFloat(),
            $saleItem->getAmount()->toFloat(),
            $saleItem->getCreatedAt()?->toString()
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @throws SaleItemInvalidFieldException
     */
    public function findProductBySale(int $saleId, int $productId): ?SaleItem
    {
        $stmt = $this->db->prepare(
            <<<SQL
                SELECT 
                    si.id,
                    si.sale_id,
                    si.product_id,
                    si.quantity,
                    si.price,
                    si.taxes_amount,
                    si.amount,
                    si.created_at,
                    si.updated_at
                FROM sale_items si
                WHERE si.sale_id = ? AND si.product_id = ?
            SQL
        );

        $stmt->execute([$saleId, $productId]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new SaleItem(
            saleId: $data['sale_id'],
            productId: $data['product_id'],
            quantity: $data['quantity'],
            price: new Decimal((string) $data['price']),
            taxesAmount: new Decimal((string) $data['taxes_amount']),
            amount: new Decimal((string) $data['amount']),
            id: $data['id'],
            createdAt: Carbon::parse($data['created_at']),
            updatedAt: Carbon::parse($data['updated_at'])
        );
    }
}
