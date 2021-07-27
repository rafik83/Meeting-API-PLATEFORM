<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210616095659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make community event picture nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_event ALTER picture DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_event ALTER picture SET NOT NULL');
    }
}
