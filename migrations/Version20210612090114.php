<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612090114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, titre VARCHAR(150) NOT NULL, date_creation DATE NOT NULL, contenu CLOB DEFAULT NULL, date_modification DATE DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_23A0E6679F37AE5 ON article (id_user_id)');
        $this->addSql('CREATE TABLE article_categorie (article_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, PRIMARY KEY(article_id, categorie_id))');
        $this->addSql('CREATE INDEX IDX_934886107294869C ON article_categorie (article_id)');
        $this->addSql('CREATE INDEX IDX_93488610BCF5E72D ON article_categorie (categorie_id)');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, categorie VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_article_id INTEGER NOT NULL, contenu CLOB NOT NULL, date_creation DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_67F068BCD71E064B ON commentaire (id_article_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE "user"');
    }
}
