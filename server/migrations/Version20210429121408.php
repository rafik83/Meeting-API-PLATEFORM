<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210429121408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add an unique company domain';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD domain VARCHAR(255)');
        $this->addSql('UPDATE company SET domain = website WHERE domain IS NULL');
        $this->addSql('ALTER table company ALTER COLUMN domain SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FA7A91E0B ON company (domain)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4FBF094FA7A91E0B');
        $this->addSql('ALTER TABLE company DROP domain');
    }
}
