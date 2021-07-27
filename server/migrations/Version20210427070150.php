<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210427070150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add hubspot columns';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account ADD hubspot_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD hubspot_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE company DROP hubspot_id');
        $this->addSql('ALTER TABLE account DROP hubspot_id');
    }
}
