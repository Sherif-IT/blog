<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606174452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_categorie (article_id INTEGER NOT NULL, categorie_id INTEGER NOT NULL, PRIMARY KEY(article_id, categorie_id))');
        $this->addSql('CREATE INDEX IDX_934886107294869C ON article_categorie (article_id)');
        $this->addSql('CREATE INDEX IDX_93488610BCF5E72D ON article_categorie (categorie_id)');
        $this->addSql('CREATE TABLE categorie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, categorie VARCHAR(150) NOT NULL)');
        $this->addSql('DROP INDEX IDX_23A0E6679F37AE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, id_user_id, titre, date_creation, contenu, date_modification FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, titre VARCHAR(150) NOT NULL COLLATE BINARY, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, contenu CLOB DEFAULT NULL, CONSTRAINT FK_23A0E6679F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, id_user_id, titre, date_creation, contenu, date_modification) SELECT id, id_user_id, titre, date_creation, contenu, date_modification FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6679F37AE5 ON article (id_user_id)');
        $this->addSql('DROP INDEX IDX_67F068BCD71E064B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, id_article_id, contenu, date_creation FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_article_id INTEGER NOT NULL, contenu CLOB NOT NULL COLLATE BINARY, date_creation DATETIME NOT NULL, CONSTRAINT FK_67F068BCD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentaire (id, id_article_id, contenu, date_creation) SELECT id, id_article_id, contenu, date_creation FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BCD71E064B ON commentaire (id_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP INDEX IDX_23A0E6679F37AE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, id_user_id, titre, date_creation, contenu, date_modification FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, titre VARCHAR(150) NOT NULL, date_creation DATE NOT NULL, date_modification DATE DEFAULT NULL, contenu CLOB NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO article (id, id_user_id, titre, date_creation, contenu, date_modification) SELECT id, id_user_id, titre, date_creation, contenu, date_modification FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6679F37AE5 ON article (id_user_id)');
        $this->addSql('DROP INDEX IDX_67F068BCD71E064B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, id_article_id, contenu, date_creation FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_article_id INTEGER NOT NULL, contenu CLOB NOT NULL, date_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO commentaire (id, id_article_id, contenu, date_creation) SELECT id, id_article_id, contenu, date_creation FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BCD71E064B ON commentaire (id_article_id)');
    }
}
