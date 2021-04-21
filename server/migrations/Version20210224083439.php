<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210224083439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add data structure for I18n communities';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE nomenclature_tag_translation (locale VARCHAR(255) NOT NULL, nomenclature_tag_id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(nomenclature_tag_id, locale))');
        $this->addSql('CREATE INDEX IDX_7E483F3EA809481B ON nomenclature_tag_translation (nomenclature_tag_id)');
        $this->addSql('CREATE TABLE tag_translation (locale VARCHAR(255) NOT NULL, tag_id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(tag_id, locale))');
        $this->addSql('CREATE INDEX IDX_A8A03F8FBAD26311 ON tag_translation (tag_id)');
        $this->addSql('ALTER TABLE nomenclature_tag_translation ADD CONSTRAINT FK_7E483F3EA809481B FOREIGN KEY (nomenclature_tag_id) REFERENCES nomenclature_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_translation ADD CONSTRAINT FK_A8A03F8FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community ADD languages TEXT NOT NULL');
        $this->addSql('ALTER TABLE community ADD default_language VARCHAR(3) NOT NULL');
        $this->addSql('COMMENT ON COLUMN community.languages IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT FK_AD775B7A727ACA70');
        $this->addSql('ALTER TABLE nomenclature_tag ADD external_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT FK_AD775B7A727ACA70 FOREIGN KEY (parent_id) REFERENCES nomenclature_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag ADD external_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tag DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7839F75D7B0 ON tag (external_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE nomenclature_tag_translation');
        $this->addSql('DROP TABLE tag_translation');
        $this->addSql('ALTER TABLE community DROP languages');
        $this->addSql('ALTER TABLE community DROP default_language');
        $this->addSql('DROP INDEX UNIQ_389B7839F75D7B0');
        $this->addSql('ALTER TABLE tag ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tag DROP external_id');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT fk_ad775b7a727aca70');
        $this->addSql('ALTER TABLE nomenclature_tag DROP external_id');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT fk_ad775b7a727aca70 FOREIGN KEY (parent_id) REFERENCES nomenclature_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
