<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220161845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE audit_virement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE audit_virement (id INT NOT NULL, type_action VARCHAR(255) NOT NULL, date_operation DATE NOT NULL, numero_virement INT NOT NULL, nom_client VARCHAR(255) NOT NULL, date_virement DATE NOT NULL, montant_ancien DOUBLE PRECISION NOT NULL, montant_nouveau DOUBLE PRECISION NOT NULL, utilisateur VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE audit_virement_id_seq CASCADE');
        $this->addSql('DROP TABLE audit_virement');
    }
}
