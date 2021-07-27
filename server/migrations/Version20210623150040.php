<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210623150040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tags on card list to restrict them by member goal';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE community_card_list_tag (card_list_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(card_list_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_CBD47A406AB49CFD ON community_card_list_tag (card_list_id)');
        $this->addSql('CREATE INDEX IDX_CBD47A40BAD26311 ON community_card_list_tag (tag_id)');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A406AB49CFD FOREIGN KEY (card_list_id) REFERENCES community_card_list (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A40BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE community_card_list_tag');
    }
}
