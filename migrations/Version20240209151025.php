<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209151025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, route_id INT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E00CEDDE34ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flight (id INT AUTO_INCREMENT NOT NULL, leg_id INT NOT NULL, provider_id INT DEFAULT NULL, price NUMERIC(19, 4) NOT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C257E60EA0D74527 (leg_id), INDEX IDX_C257E60EA53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flights_in_route (id INT AUTO_INCREMENT NOT NULL, route_id INT NOT NULL, provider_id INT NOT NULL, flight_id INT NOT NULL, order_number INT NOT NULL, INDEX IDX_2D88858B34ECB4E6 (route_id), INDEX IDX_2D88858BA53A8AA (provider_id), INDEX IDX_2D88858B91F478C5 (flight_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leg (id INT AUTO_INCREMENT NOT NULL, price_list_id INT NOT NULL, origin_id INT NOT NULL, destination_id INT NOT NULL, distance BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_75D0804F5688DED7 (price_list_id), INDEX IDX_75D0804F56A273CC (origin_id), INDEX IDX_75D0804F816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_list (id INT AUTO_INCREMENT NOT NULL, valid_until DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, price_list_id INT NOT NULL, origin_id INT NOT NULL, destination_id INT NOT NULL, distance BIGINT NOT NULL, price NUMERIC(19, 4) NOT NULL, travel_time BIGINT NOT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, INDEX IDX_2C420795688DED7 (price_list_id), INDEX IDX_2C4207956A273CC (origin_id), INDEX IDX_2C42079816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EA0D74527 FOREIGN KEY (leg_id) REFERENCES leg (id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE flights_in_route ADD CONSTRAINT FK_2D88858B34ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('ALTER TABLE flights_in_route ADD CONSTRAINT FK_2D88858BA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE flights_in_route ADD CONSTRAINT FK_2D88858B91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
        $this->addSql('ALTER TABLE leg ADD CONSTRAINT FK_75D0804F5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id)');
        $this->addSql('ALTER TABLE leg ADD CONSTRAINT FK_75D0804F56A273CC FOREIGN KEY (origin_id) REFERENCES planet (id)');
        $this->addSql('ALTER TABLE leg ADD CONSTRAINT FK_75D0804F816C6140 FOREIGN KEY (destination_id) REFERENCES planet (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420795688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C4207956A273CC FOREIGN KEY (origin_id) REFERENCES planet (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079816C6140 FOREIGN KEY (destination_id) REFERENCES planet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE34ECB4E6');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60EA0D74527');
        $this->addSql('ALTER TABLE flight DROP FOREIGN KEY FK_C257E60EA53A8AA');
        $this->addSql('ALTER TABLE flights_in_route DROP FOREIGN KEY FK_2D88858B34ECB4E6');
        $this->addSql('ALTER TABLE flights_in_route DROP FOREIGN KEY FK_2D88858BA53A8AA');
        $this->addSql('ALTER TABLE flights_in_route DROP FOREIGN KEY FK_2D88858B91F478C5');
        $this->addSql('ALTER TABLE leg DROP FOREIGN KEY FK_75D0804F5688DED7');
        $this->addSql('ALTER TABLE leg DROP FOREIGN KEY FK_75D0804F56A273CC');
        $this->addSql('ALTER TABLE leg DROP FOREIGN KEY FK_75D0804F816C6140');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420795688DED7');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C4207956A273CC');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079816C6140');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flights_in_route');
        $this->addSql('DROP TABLE leg');
        $this->addSql('DROP TABLE planet');
        $this->addSql('DROP TABLE price_list');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE route');
    }
}
