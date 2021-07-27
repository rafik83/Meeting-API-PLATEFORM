<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706075513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add fields on the CardList-Tag relation to handle sorting';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_card_list_tag DROP CONSTRAINT FK_CBD47A406AB49CFD');
        $this->addSql('ALTER TABLE community_card_list_tag DROP CONSTRAINT FK_CBD47A40BAD26311');
        $this->addSql('ALTER TABLE community_card_list_tag ADD position SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A406AB49CFD FOREIGN KEY (card_list_id) REFERENCES community_card_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A40BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_card_list_tag DROP CONSTRAINT fk_cbd47a406ab49cfd');
        $this->addSql('ALTER TABLE community_card_list_tag DROP CONSTRAINT fk_cbd47a40bad26311');
        $this->addSql('ALTER TABLE community_card_list_tag DROP position');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT fk_cbd47a406ab49cfd FOREIGN KEY (card_list_id) REFERENCES community_card_list (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT fk_cbd47a40bad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
