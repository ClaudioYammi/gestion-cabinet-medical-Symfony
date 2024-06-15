<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121143442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, medecin_id INTEGER NOT NULL, infirmier_id INTEGER NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, CONSTRAINT FK_D499BFF64F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D499BFF6C2BE0752 FOREIGN KEY (infirmier_id) REFERENCES infirmier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D499BFF64F31A84 ON planning (medecin_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6C2BE0752 ON planning (infirmier_id)');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, consultation_id INTEGER NOT NULL, medicament VARCHAR(255) NOT NULL, posologie VARCHAR(255) NOT NULL, CONSTRAINT FK_1FBFB8D962FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D962FF6CDF ON prescription (consultation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE prescription');
    }
}
