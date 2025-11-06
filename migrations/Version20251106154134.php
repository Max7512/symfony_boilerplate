<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106154134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ORDER_REFERENCE ON `order` (reference)');
        $this->addSql('ALTER TABLE order_item MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON order_item');
        $this->addSql('ALTER TABLE order_item DROP id');
        $this->addSql('ALTER TABLE order_item ADD PRIMARY KEY (vinyle_id, order__id)');
        $this->addSql('ALTER TABLE panier_item MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON panier_item');
        $this->addSql('ALTER TABLE panier_item DROP id');
        $this->addSql('ALTER TABLE panier_item ADD PRIMARY KEY (vinyle_id, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_ORDER_REFERENCE ON `order`');
        $this->addSql('ALTER TABLE panier_item ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE order_item ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
