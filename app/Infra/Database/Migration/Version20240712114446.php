<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712114446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product_types table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('product_types');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('type_id', 'integer');
        $table->addColumn('product_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('types', ['type_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('products', ['product_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addUniqueConstraint(['product_id', 'type_id'], 'product_type_unique');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('product_types');
    }
}
