<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026204224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_item (id INT AUTO_INCREMENT NOT NULL, vinyle_id INT NOT NULL, user_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_EBFD0067948AFF8F (vinyle_id), INDEX IDX_EBFD0067A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD0067948AFF8F FOREIGN KEY (vinyle_id) REFERENCES vinyle (id)');
        $this->addSql('ALTER TABLE panier_item ADD CONSTRAINT FK_EBFD0067A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD0067948AFF8F');
        $this->addSql('ALTER TABLE panier_item DROP FOREIGN KEY FK_EBFD0067A76ED395');
        $this->addSql('DROP TABLE panier_item');
    }
}
