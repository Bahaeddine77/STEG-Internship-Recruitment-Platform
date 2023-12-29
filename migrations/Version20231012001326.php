<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012001326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de l\'entité stage et encadrant et la relation avec stagiaire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE encadrant (id INT AUTO_INCREMENT NOT NULL, nom_encadrant VARCHAR(255) NOT NULL, prenom_encadrant VARCHAR(255) NOT NULL, email_encadrant VARCHAR(255) NOT NULL, mobile_encadrant INT NOT NULL, cin_encadrant INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, encadrant_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, type_stage VARCHAR(255) NOT NULL, duree INT NOT NULL, INDEX IDX_C27C9369FEF1BA4 (encadrant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES encadrant (id)');
        $this->addSql('ALTER TABLE stagiaire ADD encadrant_id INT NOT NULL, ADD stage_id INT NOT NULL');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES encadrant (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F7312298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('CREATE INDEX IDX_4F62F731FEF1BA4 ON stagiaire (encadrant_id)');
        $this->addSql('CREATE INDEX IDX_4F62F7312298D193 ON stagiaire (stage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731FEF1BA4');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F7312298D193');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369FEF1BA4');
        $this->addSql('DROP TABLE encadrant');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP INDEX IDX_4F62F731FEF1BA4 ON stagiaire');
        $this->addSql('DROP INDEX IDX_4F62F7312298D193 ON stagiaire');
        $this->addSql('ALTER TABLE stagiaire DROP encadrant_id, DROP stage_id');
    }
}
