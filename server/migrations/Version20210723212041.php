<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723212041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE community_meeting_slot DROP CONSTRAINT fk_1fee602af180e3dc');
        $this->addSql('DROP INDEX idx_1fee602af180e3dc');
        $this->addSql('ALTER TABLE community_meeting_slot DROP participant_to_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE community_meeting_slot ADD participant_to_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE community_meeting_slot ADD CONSTRAINT fk_1fee602af180e3dc FOREIGN KEY (participant_to_id) REFERENCES community_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1fee602af180e3dc ON community_meeting_slot (participant_to_id)');
    }
}
