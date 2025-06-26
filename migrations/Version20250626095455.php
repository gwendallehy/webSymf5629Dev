<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626095455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD published TINYINT(1) DEFAULT 1 NOT NULL, ADD date_creation DATETIME DEFAULT NULL, ADD date_modification DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD published TINYINT(1) DEFAULT 1 NOT NULL, ADD date_creation DATETIME DEFAULT NULL, ADD date_modification DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE portfolio ADD published TINYINT(1) DEFAULT 1 NOT NULL, ADD date_creation DATETIME DEFAULT NULL, ADD date_modification DATETIME DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD published TINYINT(1) DEFAULT 1 NOT NULL, ADD date_creation DATETIME DEFAULT NULL, ADD date_modification DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP published, DROP date_creation, DROP date_modification
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP published, DROP date_creation, DROP date_modification
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE portfolio DROP published, DROP date_creation, DROP date_modification
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP published, DROP date_creation, DROP date_modification
        SQL);
    }
}
