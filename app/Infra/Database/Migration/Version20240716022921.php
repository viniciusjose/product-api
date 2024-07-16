<?php

declare(strict_types=1);

namespace App\Infra\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716022921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new columns on sales table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('sales');
        $table->addColumn('customer', 'string');
        $table->addColumn('email', 'string');
        $table->addColumn('zip_code', 'string', ['length' => 8]);
        $table->addColumn('address', 'string');
        $table->addColumn('address_number', 'integer');
        $table->addColumn('description', 'string', ['notnull' => false]);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('sales');
        $table->dropColumn('customer');
        $table->dropColumn('zip_code');
        $table->dropColumn('address');
        $table->dropColumn('address_number');
        $table->dropColumn('description');
    }
}
