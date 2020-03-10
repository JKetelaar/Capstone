<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200221080635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE logs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_F08FC65CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, booking_table_id INT NOT NULL, user_id INT NOT NULL, checkin_date DATETIME NOT NULL, checkout_date DATETIME DEFAULT NULL, INDEX IDX_42C84955D7CBB6D1 (booking_table_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D7CBB6D1 FOREIGN KEY (booking_table_id) REFERENCES booking_table (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE chair');
        $this->addSql('ALTER TABLE booking_table ADD map_location LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chair (id INT AUTO_INCREMENT NOT NULL, chair_table_id INT NOT NULL, INDEX IDX_A50344853B137EEB (chair_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chair ADD CONSTRAINT FK_A50344853B137EEB FOREIGN KEY (chair_table_id) REFERENCES booking_table (id)');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE booking_table DROP map_location');
    }
}
