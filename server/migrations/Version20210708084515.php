<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210708084515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Specify a limit on how many card a list can contains';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_card_list ADD "limit" SMALLINT DEFAULT 20 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE community_card_list DROP "limit"');
    }
}
