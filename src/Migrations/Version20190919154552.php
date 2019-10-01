<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919154552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amenity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_amenity (room_id INT NOT NULL, amenity_id INT NOT NULL, INDEX IDX_4742C58354177093 (room_id), INDEX IDX_4742C5839F9F1305 (amenity_id), PRIMARY KEY(room_id, amenity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room_amenity ADD CONSTRAINT FK_4742C58354177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_amenity ADD CONSTRAINT FK_4742C5839F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking CHANGE room_id room_id INT DEFAULT NULL, CHANGE table_booking_id table_booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE area_id area_id INT DEFAULT NULL, CHANGE room_id room_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_amenity DROP FOREIGN KEY FK_4742C5839F9F1305');
        $this->addSql('DROP TABLE amenity');
        $this->addSql('DROP TABLE room_amenity');
        $this->addSql('ALTER TABLE booking CHANGE room_id room_id INT DEFAULT NULL, CHANGE table_booking_id table_booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE area_id area_id INT DEFAULT NULL, CHANGE room_id room_id INT DEFAULT NULL');
    }
}
