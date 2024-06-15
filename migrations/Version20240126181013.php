<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126181013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, infirmier_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INTEGER NOT NULL, genre VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_1ADAD7EBC2BE0752 FOREIGN KEY (infirmier_id) REFERENCES infirmier (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image) SELECT id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBC2BE0752 ON patient (infirmier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, infirmier_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INTEGER NOT NULL, genre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, CONSTRAINT FK_1ADAD7EBC2BE0752 FOREIGN KEY (infirmier_id) REFERENCES infirmier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image) SELECT id, infirmier_id, nom, prenom, date_de_naissance, adresse, telephone, genre, image FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBC2BE0752 ON patient (infirmier_id)');
    }
}
