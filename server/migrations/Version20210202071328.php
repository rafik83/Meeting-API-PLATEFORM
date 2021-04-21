<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202071328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add AcceptedTermsAndCondition date on account';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account ADD accepted_terms_and_condition_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN account.accepted_terms_and_condition_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE account DROP accepted_terms_and_condition_at');
    }
}
