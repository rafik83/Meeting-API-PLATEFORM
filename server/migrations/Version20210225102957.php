<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210225102957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add avatar on account';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account ADD avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account DROP avatar');
    }
}
