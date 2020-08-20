<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817160102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lineas_pedidos DROP FOREIGN KEY FK_9F6250F94854653A');
        $this->addSql('ALTER TABLE lineas_pedidos ADD CONSTRAINT FK_9F6250F94854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lineas_pedidos DROP FOREIGN KEY FK_9F6250F94854653A');
        $this->addSql('ALTER TABLE lineas_pedidos ADD CONSTRAINT FK_9F6250F94854653A FOREIGN KEY (pedido_id) REFERENCES user (id)');
    }
}
