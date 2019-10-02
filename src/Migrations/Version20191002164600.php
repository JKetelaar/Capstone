<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002164600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, floor_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D7943D68854679E2 (floor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, table_booking_id INT DEFAULT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, creation_date DATETIME NOT NULL, INDEX IDX_E00CEDDE54177093 (room_id), INDEX IDX_E00CEDDE5EDE440D (table_booking_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_user (booking_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9502F4073301C60 (booking_id), INDEX IDX_9502F407A76ED395 (user_id), PRIMARY KEY(booking_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amenity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggested_time (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, booking_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_ADC9B8F1A76ED395 (user_id), INDEX IDX_ADC9B8F13301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, floor_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_729F519B854679E2 (floor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_amenity (room_id INT NOT NULL, amenity_id INT NOT NULL, INDEX IDX_4742C58354177093 (room_id), INDEX IDX_4742C5839F9F1305 (amenity_id), PRIMARY KEY(room_id, amenity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role_user (user_role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_33CC29398E0E3CA6 (user_role_id), INDEX IDX_33CC2939A76ED395 (user_id), PRIMARY KEY(user_role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_table (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, room_id INT DEFAULT NULL, INDEX IDX_675572F3BD0F409C (area_id), INDEX IDX_675572F354177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chair (id INT AUTO_INCREMENT NOT NULL, chair_table_id INT NOT NULL, INDEX IDX_A50344853B137EEB (chair_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE floor (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, floor INT NOT NULL, INDEX IDX_BE45D62E4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68854679E2 FOREIGN KEY (floor_id) REFERENCES floor (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE5EDE440D FOREIGN KEY (table_booking_id) REFERENCES booking_table (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking_user ADD CONSTRAINT FK_9502F4073301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_user ADD CONSTRAINT FK_9502F407A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggested_time ADD CONSTRAINT FK_ADC9B8F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE suggested_time ADD CONSTRAINT FK_ADC9B8F13301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B854679E2 FOREIGN KEY (floor_id) REFERENCES floor (id)');
        $this->addSql('ALTER TABLE room_amenity ADD CONSTRAINT FK_4742C58354177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_amenity ADD CONSTRAINT FK_4742C5839F9F1305 FOREIGN KEY (amenity_id) REFERENCES amenity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_user ADD CONSTRAINT FK_33CC29398E0E3CA6 FOREIGN KEY (user_role_id) REFERENCES user_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role_user ADD CONSTRAINT FK_33CC2939A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_table ADD CONSTRAINT FK_675572F3BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE booking_table ADD CONSTRAINT FK_675572F354177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE chair ADD CONSTRAINT FK_A50344853B137EEB FOREIGN KEY (chair_table_id) REFERENCES booking_table (id)');
        $this->addSql('ALTER TABLE floor ADD CONSTRAINT FK_BE45D62E4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking_table DROP FOREIGN KEY FK_675572F3BD0F409C');
        $this->addSql('ALTER TABLE booking_user DROP FOREIGN KEY FK_9502F4073301C60');
        $this->addSql('ALTER TABLE suggested_time DROP FOREIGN KEY FK_ADC9B8F13301C60');
        $this->addSql('ALTER TABLE room_amenity DROP FOREIGN KEY FK_4742C5839F9F1305');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE54177093');
        $this->addSql('ALTER TABLE room_amenity DROP FOREIGN KEY FK_4742C58354177093');
        $this->addSql('ALTER TABLE booking_table DROP FOREIGN KEY FK_675572F354177093');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking_user DROP FOREIGN KEY FK_9502F407A76ED395');
        $this->addSql('ALTER TABLE suggested_time DROP FOREIGN KEY FK_ADC9B8F1A76ED395');
        $this->addSql('ALTER TABLE user_role_user DROP FOREIGN KEY FK_33CC2939A76ED395');
        $this->addSql('ALTER TABLE user_role_user DROP FOREIGN KEY FK_33CC29398E0E3CA6');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE5EDE440D');
        $this->addSql('ALTER TABLE chair DROP FOREIGN KEY FK_A50344853B137EEB');
        $this->addSql('ALTER TABLE floor DROP FOREIGN KEY FK_BE45D62E4D2A7E12');
        $this->addSql('ALTER TABLE area DROP FOREIGN KEY FK_D7943D68854679E2');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B854679E2');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_user');
        $this->addSql('DROP TABLE amenity');
        $this->addSql('DROP TABLE suggested_time');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_amenity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE user_role_user');
        $this->addSql('DROP TABLE booking_table');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE chair');
        $this->addSql('DROP TABLE floor');
    }
}
