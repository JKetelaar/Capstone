<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917164445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE suggested_time (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, booking_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_ADC9B8F1A76ED395 (user_id), INDEX IDX_ADC9B8F13301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suggested_time ADD CONSTRAINT FK_ADC9B8F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE suggested_time ADD CONSTRAINT FK_ADC9B8F13301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE booking ADD date DATETIME NOT NULL, ADD creation_date DATETIME NOT NULL, CHANGE room_id room_id INT DEFAULT NULL, CHANGE table_booking_id table_booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE area_id area_id INT DEFAULT NULL, CHANGE room_id room_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE suggested_time');
        $this->addSql('ALTER TABLE booking DROP date, DROP creation_date, CHANGE room_id room_id INT DEFAULT NULL, CHANGE table_booking_id table_booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE area_id area_id INT DEFAULT NULL, CHANGE room_id room_id INT DEFAULT NULL');
    }
}
