<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823183858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, subtotal DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_77E6BED5DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lineas_carrito (id INT AUTO_INCREMENT NOT NULL, carrito_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, precio DOUBLE PRECISION NOT NULL, unidades INT NOT NULL, INDEX IDX_8F922286DE2CF6E7 (carrito_id), INDEX IDX_8F9222867645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrito ADD CONSTRAINT FK_77E6BED5DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lineas_carrito ADD CONSTRAINT FK_8F922286DE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id)');
        $this->addSql('ALTER TABLE lineas_carrito ADD CONSTRAINT FK_8F9222867645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lineas_carrito DROP FOREIGN KEY FK_8F922286DE2CF6E7');
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP TABLE lineas_carrito');
        $this->addSql('ALTER TABLE user CHANGE session_user session_user TINYINT(1) NOT NULL COMMENT \'1=True | 0=False\'');
    }
}
