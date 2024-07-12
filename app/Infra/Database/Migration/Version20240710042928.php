<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710042928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generated products table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('products');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string');
        $table->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'products_name_unique');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('products');
    }
}
