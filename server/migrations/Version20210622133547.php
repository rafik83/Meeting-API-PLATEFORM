<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210622133547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Community Media';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE community_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_media (id INT NOT NULL, community_id INT NOT NULL, media_type VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, processed BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_115CDB48FDA7B0BF ON community_media (community_id)');
        $this->addSql('COMMENT ON COLUMN community_media.media_type IS \'(DC2Type:community_media_type)\'');
        $this->addSql('COMMENT ON COLUMN community_media.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE community_media_tag (media_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(media_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_ED2036D0EA9FDD75 ON community_media_tag (media_id)');
        $this->addSql('CREATE INDEX IDX_ED2036D0BAD26311 ON community_media_tag (tag_id)');
        $this->addSql('CREATE TABLE community_media_translation (language VARCHAR(255) NOT NULL, media_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, cta_label VARCHAR(255) DEFAULT NULL, cta_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(media_id, language))');
        $this->addSql('CREATE INDEX IDX_E8566994EA9FDD75 ON community_media_translation (media_id)');
        $this->addSql('ALTER TABLE community_media ADD CONSTRAINT FK_115CDB48FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_tag ADD CONSTRAINT FK_ED2036D0EA9FDD75 FOREIGN KEY (media_id) REFERENCES community_media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_tag ADD CONSTRAINT FK_ED2036D0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_translation ADD CONSTRAINT FK_E8566994EA9FDD75 FOREIGN KEY (media_id) REFERENCES community_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_media_tag DROP CONSTRAINT FK_ED2036D0EA9FDD75');
        $this->addSql('ALTER TABLE community_media_translation DROP CONSTRAINT FK_E8566994EA9FDD75');
        $this->addSql('DROP SEQUENCE community_media_id_seq CASCADE');
        $this->addSql('DROP TABLE community_media');
        $this->addSql('DROP TABLE community_media_tag');
        $this->addSql('DROP TABLE community_media_translation');
    }
}
