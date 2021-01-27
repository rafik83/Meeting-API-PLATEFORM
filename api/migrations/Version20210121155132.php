<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210121155132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE nomenclature_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE nomenclature_tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, account_id INT NOT NULL, community_id INT NOT NULL, joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_70E4FA789B6B5FBA ON member (account_id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78FDA7B0BF ON member (community_id)');
        $this->addSql('COMMENT ON COLUMN member.joined_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE member_tag (member_id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(member_id, nomenclature_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_322D97D87597D3FE ON member_tag (member_id)');
        $this->addSql('CREATE INDEX IDX_322D97D890BFD4B8 ON member_tag (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_322D97D8BAD26311 ON member_tag (tag_id)');
        $this->addSql('CREATE TABLE nomenclature (id INT NOT NULL, community_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_799A3652FDA7B0BF ON nomenclature (community_id)');
        $this->addSql('CREATE TABLE nomenclature_tag (id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT NOT NULL, parent_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AD775B7A90BFD4B8 ON nomenclature_tag (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_AD775B7ABAD26311 ON nomenclature_tag (tag_id)');
        $this->addSql('CREATE INDEX IDX_AD775B7A727ACA70 ON nomenclature_tag (parent_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA789B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT FK_322D97D87597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT FK_322D97D890BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT FK_322D97D8BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nomenclature ADD CONSTRAINT FK_799A3652FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT FK_AD775B7A90BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT FK_AD775B7ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT FK_AD775B7A727ACA70 FOREIGN KEY (parent_id) REFERENCES nomenclature_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE account ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE account ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE account ADD last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_tag DROP CONSTRAINT FK_322D97D87597D3FE');
        $this->addSql('ALTER TABLE member_tag DROP CONSTRAINT FK_322D97D890BFD4B8');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT FK_AD775B7A90BFD4B8');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT FK_AD775B7A727ACA70');
        $this->addSql('ALTER TABLE member_tag DROP CONSTRAINT FK_322D97D8BAD26311');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT FK_AD775B7ABAD26311');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE nomenclature_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE nomenclature_tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_tag');
        $this->addSql('DROP TABLE nomenclature');
        $this->addSql('DROP TABLE nomenclature_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('ALTER TABLE account DROP email');
        $this->addSql('ALTER TABLE account DROP password');
        $this->addSql('ALTER TABLE account DROP first_name');
        $this->addSql('ALTER TABLE account DROP last_name');
    }
}
