<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240714220938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create sales table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('sales');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('updated_at', 'datetime');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('sales');
    }
}
