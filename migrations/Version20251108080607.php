<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251108080607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_genre (genre_source INT NOT NULL, genre_target INT NOT NULL, INDEX IDX_3E562C3DB4394F53 (genre_source), INDEX IDX_3E562C3DADDC1FDC (genre_target), PRIMARY KEY(genre_source, genre_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vinyle_genre (vinyle_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_EE75A3FA948AFF8F (vinyle_id), INDEX IDX_EE75A3FA4296D31F (genre_id), PRIMARY KEY(vinyle_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genre_genre ADD CONSTRAINT FK_3E562C3DB4394F53 FOREIGN KEY (genre_source) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_genre ADD CONSTRAINT FK_3E562C3DADDC1FDC FOREIGN KEY (genre_target) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyle_genre ADD CONSTRAINT FK_EE75A3FA948AFF8F FOREIGN KEY (vinyle_id) REFERENCES vinyle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyle_genre ADD CONSTRAINT FK_EE75A3FA4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyle ADD author_id INT NOT NULL, DROP author');
        $this->addSql('ALTER TABLE vinyle ADD CONSTRAINT FK_8CD238D0F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_8CD238D0F675F31B ON vinyle (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vinyle DROP FOREIGN KEY FK_8CD238D0F675F31B');
        $this->addSql('ALTER TABLE genre_genre DROP FOREIGN KEY FK_3E562C3DB4394F53');
        $this->addSql('ALTER TABLE genre_genre DROP FOREIGN KEY FK_3E562C3DADDC1FDC');
        $this->addSql('ALTER TABLE vinyle_genre DROP FOREIGN KEY FK_EE75A3FA948AFF8F');
        $this->addSql('ALTER TABLE vinyle_genre DROP FOREIGN KEY FK_EE75A3FA4296D31F');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_genre');
        $this->addSql('DROP TABLE vinyle_genre');
        $this->addSql('DROP INDEX IDX_8CD238D0F675F31B ON vinyle');
        $this->addSql('ALTER TABLE vinyle ADD author VARCHAR(64) NOT NULL, DROP author_id');
    }
}
