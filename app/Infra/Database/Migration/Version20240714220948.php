<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714220948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create sales item table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('sale_items');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('sale_id', 'integer');
        $table->addColumn('product_id', 'integer');
        $table->addColumn('quantity', 'integer');
        $table->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('taxes_amount', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('amount', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('updated_at', 'datetime');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('sales', ['sale_id'], ['id']);
        $table->addForeignKeyConstraint('products', ['product_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('sales');
    }
}
