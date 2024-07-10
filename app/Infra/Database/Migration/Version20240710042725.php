<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710042725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generated product_type_taxes table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('product_type_taxes');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('product_type_id', 'integer');
        $table->addColumn('tax_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('product_types', ['product_type_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('taxes', ['tax_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addUniqueConstraint(['product_type_id', 'tax_id'], 'product_type_tax_unique');
    }

    public function down(Schema $schema): void
    {
       $schema->dropTable('product_type_taxes');
    }
}
