<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723122628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting_slot ADD meeting_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meeting_slot ADD CONSTRAINT FK_40FFD8B567433D9C FOREIGN KEY (meeting_id) REFERENCES community_meeting_slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_40FFD8B567433D9C ON meeting_slot (meeting_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE meeting_slot DROP CONSTRAINT FK_40FFD8B567433D9C');
        $this->addSql('DROP INDEX IDX_40FFD8B567433D9C');
        $this->addSql('ALTER TABLE meeting_slot DROP meeting_id');
    }
}
