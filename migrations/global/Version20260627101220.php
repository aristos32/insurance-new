<?php

declare(strict_types=1);

namespace DoctrineMigrations\Global;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260627101220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE systemuser (username VARCHAR(40) NOT NULL, password VARCHAR(60) NOT NULL, role VARCHAR(20) NOT NULL, status VARCHAR(20) NOT NULL, productType VARCHAR(20) DEFAULT NULL, subProductType VARCHAR(20) DEFAULT NULL, clientName VARCHAR(40) DEFAULT NULL, consecutiveFailLoginAttempts INT DEFAULT NULL, PRIMARY KEY (username)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE systemuser');
    }
}
