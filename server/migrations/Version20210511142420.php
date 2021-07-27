<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210511142420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Goal Matching';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE community_goal_matching (goal_id INT NOT NULL, from_id INT NOT NULL, to_id INT NOT NULL, priority INT DEFAULT 0 NOT NULL, PRIMARY KEY(goal_id, from_id, to_id))');
        $this->addSql('CREATE INDEX IDX_885F8D1667D1AFE ON community_goal_matching (goal_id)');
        $this->addSql('CREATE INDEX IDX_885F8D178CED90B ON community_goal_matching (from_id)');
        $this->addSql('CREATE INDEX IDX_885F8D130354A65 ON community_goal_matching (to_id)');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D1667D1AFE FOREIGN KEY (goal_id) REFERENCES community_goal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D178CED90B FOREIGN KEY (from_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D130354A65 FOREIGN KEY (to_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE community_goal_matching');
    }
}
