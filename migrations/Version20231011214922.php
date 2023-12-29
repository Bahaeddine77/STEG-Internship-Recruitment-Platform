<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011214922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de l\'entité stagiaire';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, nom_stagiaire VARCHAR(255) NOT NULL, prenom_stagiaire VARCHAR(255) NOT NULL, cv VARCHAR(255) DEFAULT NULL, piece_identite VARCHAR(255) NOT NULL, num_piece_identite VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, gouvernorat VARCHAR(255) NOT NULL, mobile INT NOT NULL, diplome VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, institut VARCHAR(255) NOT NULL, indemnite INT NOT NULL, date_naissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stagiaire');
    }
}
