<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210331113953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Rename goal to community goal';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT fk_54c772667d1afe');
        $this->addSql('DROP INDEX idx_54c772667d1afe');
        $this->addSql('ALTER TABLE member_goal RENAME COLUMN goal_id TO community_goal_id');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C77242B873AD FOREIGN KEY (community_goal_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_54C77242B873AD ON member_goal (community_goal_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT FK_54C77242B873AD');
        $this->addSql('DROP INDEX IDX_54C77242B873AD');
        $this->addSql('ALTER TABLE member_goal RENAME COLUMN community_goal_id TO goal_id');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT fk_54c772667d1afe FOREIGN KEY (goal_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_54c772667d1afe ON member_goal (goal_id)');
    }
}
