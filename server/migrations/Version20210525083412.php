<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210525083412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add CardList model';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE community_card_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_card_list (id INT NOT NULL, community_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, card_types TEXT DEFAULT NULL, sorting VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, published BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D030914FDA7B0BF ON community_card_list (community_id)');
        $this->addSql('COMMENT ON COLUMN community_card_list.card_types IS \'(DC2Type:card_list_card_types)\'');
        $this->addSql('COMMENT ON COLUMN community_card_list.sorting IS \'(DC2Type:card_list_sorting)\'');
        $this->addSql('ALTER TABLE community_card_list ADD CONSTRAINT FK_D030914FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE community_card_list_id_seq CASCADE');
        $this->addSql('DROP TABLE community_card_list');
    }
}
