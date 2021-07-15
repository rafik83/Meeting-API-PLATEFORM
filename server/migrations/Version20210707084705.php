<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210707084705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create CardList config by type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE community_card_list_config_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_card_list_config (id INT NOT NULL, card_list_id INT DEFAULT NULL, main_goal_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2CED83E76AB49CFD ON community_card_list_config (card_list_id)');
        $this->addSql('CREATE INDEX IDX_2CED83E79236B317 ON community_card_list_config (main_goal_id)');
        $this->addSql('ALTER TABLE community_card_list_config ADD CONSTRAINT FK_2CED83E76AB49CFD FOREIGN KEY (card_list_id) REFERENCES community_card_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_config ADD CONSTRAINT FK_2CED83E79236B317 FOREIGN KEY (main_goal_id) REFERENCES tag (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE community_card_list_config_id_seq CASCADE');
        $this->addSql('DROP TABLE community_card_list_config');
    }
}
