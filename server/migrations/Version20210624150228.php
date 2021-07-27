<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210624150228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Clean migrations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx_70e4fa78fda7b0bf');
        $this->addSql('DROP INDEX idx_70e4fa789b6b5fba');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT fk_70e4fa789b6b5fba');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT fk_70e4fa78fda7b0bf');
        $this->addSql('ALTER SEQUENCE member_id_seq RENAME TO community_member_id_seq');
        $this->addSql('ALTER TABLE member RENAME TO community_member');
        $this->addSql('CREATE INDEX IDX_12E0F8B9B6B5FBA ON community_member (account_id)');
        $this->addSql('CREATE INDEX IDX_12E0F8BFDA7B0BF ON community_member (community_id)');
        $this->addSql('ALTER TABLE community_member ADD CONSTRAINT FK_12E0F8B9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_member ADD CONSTRAINT FK_12E0F8BFDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER TABLE company ALTER created_at DROP DEFAULT');

        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT FK_54C7727597D3FE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C7727597D3FE FOREIGN KEY (member_id) REFERENCES community_member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER SEQUENCE community_member_id_seq RENAME TO member_id_seq');
        $this->addSql('ALTER TABLE community_member DROP CONSTRAINT FK_12E0F8B9B6B5FBA');
        $this->addSql('ALTER TABLE community_member DROP CONSTRAINT FK_12E0F8BFDA7B0BF');
        $this->addSql('ALTER TABLE community_member RENAME TO member');

        $this->addSql('DROP INDEX IDX_12E0F8B9B6B5FBA');
        $this->addSql('DROP INDEX IDX_12E0F8BFDA7B0BF');
        $this->addSql('CREATE INDEX idx_70e4fa78fda7b0bf ON member (community_id)');
        $this->addSql('CREATE INDEX idx_70e4fa789b6b5fba ON member (account_id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa789b6b5fba FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa78fda7b0bf FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('ALTER TABLE company ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');

        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT fk_54c7727597d3fe');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT fk_54c7727597d3fe FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
