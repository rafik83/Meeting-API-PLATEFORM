<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202102818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE community_step_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_step (id INT NOT NULL, community_id INT NOT NULL, nomenclature_id INT NOT NULL, position SMALLINT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, min SMALLINT NOT NULL, max SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_82E814F6FDA7B0BF ON community_step (community_id)');
        $this->addSql('CREATE INDEX IDX_82E814F690BFD4B8 ON community_step (nomenclature_id)');
        $this->addSql('CREATE UNIQUE INDEX step_community_nomenclature ON community_step (community_id, nomenclature_id)');
        $this->addSql('ALTER TABLE community_step ADD CONSTRAINT FK_82E814F6FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_step ADD CONSTRAINT FK_82E814F690BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD current_qualification_step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78D7B91300 FOREIGN KEY (current_qualification_step_id) REFERENCES community_step (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_70E4FA78D7B91300 ON member (current_qualification_step_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA78D7B91300');
        $this->addSql('DROP SEQUENCE community_step_id_seq CASCADE');
        $this->addSql('DROP TABLE community_step');
        $this->addSql('DROP INDEX IDX_70E4FA78D7B91300');
        $this->addSql('ALTER TABLE member DROP current_qualification_step_id');
    }
}
