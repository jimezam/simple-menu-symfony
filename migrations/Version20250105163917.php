<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105163917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE restaurant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE restaurant (id INT NOT NULL, name VARCHAR(128) NOT NULL, slogan VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(60) NOT NULL, province VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, phone VARCHAR(15) DEFAULT NULL, whatsapp VARCHAR(15) DEFAULT NULL, website VARCHAR(128) DEFAULT NULL, instagram VARCHAR(32) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, owner INT NOT NULL, active_menu INT DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE restaurant_id_seq CASCADE');
        $this->addSql('DROP TABLE restaurant');
    }
}
