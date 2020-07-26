<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726120135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE datos_facturacion (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefono INT NOT NULL, provincia VARCHAR(255) NOT NULL, localidad VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, codigo_postal INT NOT NULL, INDEX IDX_F03143BDDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lineas_pedidos (id INT AUTO_INCREMENT NOT NULL, pedido_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, unidades INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9F6250F94854653A (pedido_id), INDEX IDX_9F6250F97645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, coste DOUBLE PRECISION NOT NULL, estado VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C4EC16CEDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE datos_facturacion ADD CONSTRAINT FK_F03143BDDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lineas_pedidos ADD CONSTRAINT FK_9F6250F94854653A FOREIGN KEY (pedido_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lineas_pedidos ADD CONSTRAINT FK_9F6250F97645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE datos_facturacion');
        $this->addSql('DROP TABLE lineas_pedidos');
        $this->addSql('DROP TABLE pedido');
    }
}
