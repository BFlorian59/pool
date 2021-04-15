<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415114142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, is_multiple TINYINT(1) NOT NULL, INDEX IDX_8ADC54D59D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, question_id_id INT DEFAULT NULL, libelle_choise VARCHAR(255) NOT NULL, INDEX IDX_1E512EC64FAF8F53 (question_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultats (id INT AUTO_INCREMENT NOT NULL, reponse_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, ip VARCHAR(255) NOT NULL, INDEX IDX_55ED970290ADE534 (reponse_id_id), INDEX IDX_55ED97029D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC64FAF8F53 FOREIGN KEY (question_id_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE resultats ADD CONSTRAINT FK_55ED970290ADE534 FOREIGN KEY (reponse_id_id) REFERENCES reponses (id)');
        $this->addSql('ALTER TABLE resultats ADD CONSTRAINT FK_55ED97029D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC64FAF8F53');
        $this->addSql('ALTER TABLE resultats DROP FOREIGN KEY FK_55ED970290ADE534');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D59D86650F');
        $this->addSql('ALTER TABLE resultats DROP FOREIGN KEY FK_55ED97029D86650F');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('DROP TABLE resultats');
        $this->addSql('DROP TABLE user');
    }
}
