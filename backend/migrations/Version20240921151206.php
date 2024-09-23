<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240921151206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrier_price_rule (id INT AUTO_INCREMENT NOT NULL, carrier_id INT NOT NULL, type VARCHAR(255) NOT NULL, weight_limit INT DEFAULT NULL, fixed_price INT DEFAULT NULL, price_per_kg INT DEFAULT NULL, INDEX IDX_A269A2D821DFC797 (carrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, carrier_id INT NOT NULL, weight INT NOT NULL, price INT NOT NULL, INDEX IDX_DE68679521DFC797 (carrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrier_price_rule ADD CONSTRAINT FK_A269A2D821DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE68679521DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4739F11C5E237E06 ON carrier (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier_price_rule DROP FOREIGN KEY FK_A269A2D821DFC797');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE68679521DFC797');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE carrier_price_rule');
        $this->addSql('DROP TABLE package');
    }
}
