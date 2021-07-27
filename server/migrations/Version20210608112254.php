<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210608112254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add community events';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE community_event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_event (id INT NOT NULL, community_id INT NOT NULL, name VARCHAR(255) NOT NULL, event_type VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, register_url VARCHAR(255) NOT NULL, find_out_more_url VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, published BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40DE70E3FDA7B0BF ON community_event (community_id)');
        $this->addSql('COMMENT ON COLUMN community_event.event_type IS \'(DC2Type:community_event_type)\'');
        $this->addSql('COMMENT ON COLUMN community_event.start_date IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN community_event.end_date IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE community_event_tag (event_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_B7BE81FE71F7E88B ON community_event_tag (event_id)');
        $this->addSql('CREATE INDEX IDX_B7BE81FEBAD26311 ON community_event_tag (tag_id)');
        $this->addSql('CREATE TABLE community_event_characterization_tag (event_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_CB4886371F7E88B ON community_event_characterization_tag (event_id)');
        $this->addSql('CREATE INDEX IDX_CB48863BAD26311 ON community_event_characterization_tag (tag_id)');
        $this->addSql('ALTER TABLE community_event ADD CONSTRAINT FK_40DE70E3FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_tag ADD CONSTRAINT FK_B7BE81FE71F7E88B FOREIGN KEY (event_id) REFERENCES community_event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_tag ADD CONSTRAINT FK_B7BE81FEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_characterization_tag ADD CONSTRAINT FK_CB4886371F7E88B FOREIGN KEY (event_id) REFERENCES community_event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_characterization_tag ADD CONSTRAINT FK_CB48863BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community ADD skill_nomenclature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE community ADD event_nomenclature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B604033A67EA72D FOREIGN KEY (skill_nomenclature_id) REFERENCES nomenclature (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B604033596CB088 FOREIGN KEY (event_nomenclature_id) REFERENCES nomenclature (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1B604033A67EA72D ON community (skill_nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_1B604033596CB088 ON community (event_nomenclature_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_event_tag DROP CONSTRAINT FK_B7BE81FE71F7E88B');
        $this->addSql('ALTER TABLE community_event_characterization_tag DROP CONSTRAINT FK_CB4886371F7E88B');
        $this->addSql('DROP SEQUENCE community_event_id_seq CASCADE');
        $this->addSql('DROP TABLE community_event');
        $this->addSql('DROP TABLE community_event_tag');
        $this->addSql('DROP TABLE community_event_characterization_tag');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B604033A67EA72D');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B604033596CB088');
        $this->addSql('DROP INDEX IDX_1B604033A67EA72D');
        $this->addSql('DROP INDEX IDX_1B604033596CB088');
        $this->addSql('ALTER TABLE community DROP skill_nomenclature_id');
        $this->addSql('ALTER TABLE community DROP event_nomenclature_id');
    }
}
