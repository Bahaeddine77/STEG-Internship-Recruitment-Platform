<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013005220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de l\'entité abscence et la relation avec stagiaire' ;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abscence (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT DEFAULT NULL, date_d DATE NOT NULL, date_f DATE NOT NULL, justification LONGTEXT NOT NULL, INDEX IDX_BD71CDABBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abscence ADD CONSTRAINT FK_BD71CDABBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abscence DROP FOREIGN KEY FK_BD71CDABBA93DD6');
        $this->addSql('DROP TABLE abscence');
    }
}
