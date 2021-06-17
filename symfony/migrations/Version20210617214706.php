<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617214706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) NOT NULL, ean13 VARCHAR(255) DEFAULT NULL, ean_virtual VARCHAR(255) DEFAULT NULL, product_eans LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', stock INT NOT NULL, stock_catalog INT DEFAULT NULL, stock_to_show INT NOT NULL, stock_available INT NOT NULL, category_name VARCHAR(255) DEFAULT NULL, brand_name VARCHAR(255) DEFAULT NULL, part_number VARCHAR(255) DEFAULT NULL, collection VARCHAR(255) DEFAULT NULL, price_catalog DOUBLE PRECISION DEFAULT NULL, price_wholesale DOUBLE PRECISION DEFAULT NULL, price_retail DOUBLE PRECISION NOT NULL, pvp DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, weight_packaging DOUBLE PRECISION DEFAULT NULL, length_packaging DOUBLE PRECISION DEFAULT NULL, width_packaging DOUBLE PRECISION DEFAULT NULL, height_packaging DOUBLE PRECISION DEFAULT NULL, weight_master DOUBLE PRECISION DEFAULT NULL, length_master DOUBLE PRECISION DEFAULT NULL, height_master DOUBLE PRECISION DEFAULT NULL, width_master DOUBLE PRECISION DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, product_images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', tax DOUBLE PRECISION DEFAULT NULL, unit_box INT DEFAULT NULL, unit_palet INT DEFAULT NULL, assortment INT NOT NULL, min_sales_unit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_audit (id INT AUTO_INCREMENT NOT NULL, entity_class VARCHAR(255) DEFAULT NULL, entity_key VARCHAR(255) DEFAULT NULL, property_name VARCHAR(255) DEFAULT NULL, old_value LONGTEXT DEFAULT NULL, new_value LONGTEXT DEFAULT NULL, ts DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE property_audit');
    }
}
