<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413094431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Make externalId not nullable';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('UPDATE nomenclature_tag SET external_id = id WHERE external_id IS NULL');
        $this->addSql('ALTER TABLE nomenclature_tag ALTER external_id SET NOT NULL');
        $this->addSql('UPDATE tag SET external_id = id WHERE external_id IS NULL');
        $this->addSql('ALTER TABLE tag ALTER external_id SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE nomenclature_tag ALTER external_id DROP NOT NULL');
        $this->addSql('ALTER TABLE tag ALTER external_id DROP NOT NULL');
    }
}
