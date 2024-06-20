<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620003751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD "publishing_status" VARCHAR(255) NULL');
        $this->addSql('UPDATE book SET "publishing_status" = \'https://schema.org/Publishing/Basic\' WHERE "is_promoted" = true');
        $this->addSql('UPDATE book SET "publishing_status" = \'https://schema.org/Publishing/None\' WHERE "is_promoted" = false');
        $this->addSql('ALTER TABLE book ALTER publishing_status SET NOT NULL');
        $this->addSql('ALTER TABLE book DROP is_promoted');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD is_promoted BOOLEAN NULL');
        $this->addSql('UPDATE book SET "is_promoted" = true WHERE "publishing_status" = \'https://schema.org/Publishing/Basic\'');
        $this->addSql('UPDATE book SET "is_promoted" = true WHERE "publishing_status" = \'https://schema.org/Publishing/Pro\'');
        $this->addSql('UPDATE book SET "is_promoted" = false WHERE "publishing_status" = \'https://schema.org/Publishing/None\'');
        $this->addSql('ALTER TABLE book ALTER is_promoted SET NOT NULL');
        $this->addSql('ALTER TABLE book DROP "publishing_status"');
    }
}
