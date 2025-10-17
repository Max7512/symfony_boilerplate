<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251017205300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE burgers_ingredients (burger_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_8F1C725F17CE5090 (burger_id), INDEX IDX_8F1C725F933FE08C (ingredient_id), PRIMARY KEY(burger_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE burgers_ingredients ADD CONSTRAINT FK_8F1C725F17CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burgers_ingredients ADD CONSTRAINT FK_8F1C725F933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burgers_oignons DROP FOREIGN KEY FK_90C5B41117CE5090');
        $this->addSql('ALTER TABLE burgers_oignons DROP FOREIGN KEY FK_90C5B4118F038184');
        $this->addSql('DROP TABLE burgers_oignons');
        $this->addSql('DROP TABLE oignon');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE burgers_oignons (burger_id INT NOT NULL, oignon_id INT NOT NULL, INDEX IDX_90C5B4118F038184 (oignon_id), INDEX IDX_90C5B41117CE5090 (burger_id), PRIMARY KEY(burger_id, oignon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oignon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE burgers_oignons ADD CONSTRAINT FK_90C5B41117CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burgers_oignons ADD CONSTRAINT FK_90C5B4118F038184 FOREIGN KEY (oignon_id) REFERENCES oignon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burgers_ingredients DROP FOREIGN KEY FK_8F1C725F17CE5090');
        $this->addSql('ALTER TABLE burgers_ingredients DROP FOREIGN KEY FK_8F1C725F933FE08C');
        $this->addSql('DROP TABLE burgers_ingredients');
        $this->addSql('DROP TABLE ingredient');
    }
}
