<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415125728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE question');
        $this->addSql('ALTER TABLE questions CHANGE user_id_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D59D86650F ON questions (user_id_id)');
        $this->addSql('ALTER TABLE reponses CHANGE question_id_id question_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC64FAF8F53 FOREIGN KEY (question_id_id) REFERENCES questions (id)');
        $this->addSql('CREATE INDEX IDX_1E512EC64FAF8F53 ON reponses (question_id_id)');
        $this->addSql('ALTER TABLE resultats CHANGE reponse_id_id reponse_id_id INT DEFAULT NULL, CHANGE user_id_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resultats ADD CONSTRAINT FK_55ED970290ADE534 FOREIGN KEY (reponse_id_id) REFERENCES reponses (id)');
        $this->addSql('ALTER TABLE resultats ADD CONSTRAINT FK_55ED97029D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_55ED970290ADE534 ON resultats (reponse_id_id)');
        $this->addSql('CREATE INDEX IDX_55ED97029D86650F ON resultats (user_id_id)');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, champ_question VARCHAR(125) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D59D86650F');
        $this->addSql('DROP INDEX IDX_8ADC54D59D86650F ON questions');
        $this->addSql('ALTER TABLE questions CHANGE user_id_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC64FAF8F53');
        $this->addSql('DROP INDEX IDX_1E512EC64FAF8F53 ON reponses');
        $this->addSql('ALTER TABLE reponses CHANGE question_id_id question_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE resultats DROP FOREIGN KEY FK_55ED970290ADE534');
        $this->addSql('ALTER TABLE resultats DROP FOREIGN KEY FK_55ED97029D86650F');
        $this->addSql('DROP INDEX IDX_55ED970290ADE534 ON resultats');
        $this->addSql('DROP INDEX IDX_55ED97029D86650F ON resultats');
        $this->addSql('ALTER TABLE resultats CHANGE reponse_id_id reponse_id_id INT NOT NULL, CHANGE user_id_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified INT DEFAULT NULL');
    }
}
