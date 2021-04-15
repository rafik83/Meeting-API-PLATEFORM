<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210317110747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP CONSTRAINT fk_70e4fa78d7b91300');
        $this->addSql('DROP SEQUENCE community_step_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE community_goal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_goal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE community_goal (id INT NOT NULL, community_id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, position INT DEFAULT NULL, min INT DEFAULT 0 NOT NULL, max INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D8D01E4FDA7B0BF ON community_goal (community_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E490BFD4B8 ON community_goal (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E4BAD26311 ON community_goal (tag_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E4727ACA70 ON community_goal (parent_id)');
        $this->addSql('CREATE TABLE member_goal (id INT NOT NULL, member_id INT NOT NULL, goal_id INT NOT NULL, tag_id INT NOT NULL, priority INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_54C7727597D3FE ON member_goal (member_id)');
        $this->addSql('CREATE INDEX IDX_54C772667D1AFE ON member_goal (goal_id)');
        $this->addSql('CREATE INDEX IDX_54C772BAD26311 ON member_goal (tag_id)');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E490BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4727ACA70 FOREIGN KEY (parent_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C7727597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C772667D1AFE FOREIGN KEY (goal_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C772BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE member_tag');
        $this->addSql('DROP TABLE community_step');
        $this->addSql('DROP INDEX idx_70e4fa78d7b91300');
        $this->addSql('ALTER TABLE member DROP current_qualification_step_id');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE community_goal DROP CONSTRAINT FK_3D8D01E4727ACA70');
        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT FK_54C772667D1AFE');
        $this->addSql('DROP SEQUENCE community_goal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_goal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE community_step_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE member_tag (member_id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT NOT NULL, priority SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(member_id, nomenclature_id, tag_id))');
        $this->addSql('CREATE INDEX idx_322d97d8bad26311 ON member_tag (tag_id)');
        $this->addSql('CREATE INDEX idx_322d97d890bfd4b8 ON member_tag (nomenclature_id)');
        $this->addSql('CREATE INDEX idx_322d97d87597d3fe ON member_tag (member_id)');
        $this->addSql('CREATE TABLE community_step (id INT NOT NULL, community_id INT NOT NULL, nomenclature_id INT NOT NULL, "position" SMALLINT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, min SMALLINT NOT NULL, max SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_82e814f690bfd4b8 ON community_step (nomenclature_id)');
        $this->addSql('CREATE UNIQUE INDEX step_community_nomenclature ON community_step (community_id, nomenclature_id)');
        $this->addSql('CREATE INDEX idx_82e814f6fda7b0bf ON community_step (community_id)');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d87597d3fe FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d890bfd4b8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d8bad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_step ADD CONSTRAINT fk_82e814f6fda7b0bf FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_step ADD CONSTRAINT fk_82e814f690bfd4b8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE community_goal');
        $this->addSql('DROP TABLE member_goal');
        $this->addSql('ALTER TABLE member ADD current_qualification_step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa78d7b91300 FOREIGN KEY (current_qualification_step_id) REFERENCES community_step (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_70e4fa78d7b91300 ON member (current_qualification_step_id)');
    }
}
