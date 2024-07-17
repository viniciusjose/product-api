<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710042507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generated taxes table.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('taxes');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('percentage', 'decimal', ['precision' => 10, 'scale' => 4]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'taxes_name_unique');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('taxes');
    }
}
