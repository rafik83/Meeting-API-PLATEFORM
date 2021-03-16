<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210310100432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Allow global nomenclature & add account profile fields';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account ADD job_position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD job_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD languages TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN account.languages IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4BEE8350F FOREIGN KEY (job_position_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7D3656A4BEE8350F ON account (job_position_id)');
        $this->addSql('ALTER TABLE nomenclature ALTER community_id DROP NOT NULL');
        $this->addSql('ALTER TABLE nomenclature RENAME COLUMN name TO reference');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE nomenclature ALTER community_id SET NOT NULL');
        $this->addSql('ALTER TABLE nomenclature RENAME COLUMN reference TO name');
        $this->addSql('ALTER TABLE account DROP CONSTRAINT FK_7D3656A4BEE8350F');
        $this->addSql('DROP INDEX IDX_7D3656A4BEE8350F');
        $this->addSql('ALTER TABLE account DROP job_position_id');
        $this->addSql('ALTER TABLE account DROP job_title');
        $this->addSql('ALTER TABLE account DROP languages');
        $this->addSql('ALTER TABLE account DROP country');
        $this->addSql('ALTER TABLE account DROP timezone');
    }
}
