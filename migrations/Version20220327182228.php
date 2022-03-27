<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327182228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, id_student_id INT NOT NULL, id_subject_id INT NOT NULL, grade INT DEFAULT NULL, INDEX IDX_595AAE346E1ECFCD (id_student_id), INDEX IDX_595AAE34A7B45C50 (id_subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, date_of_arrival VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, date_of_release VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, id_promotion_id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, age INT NOT NULL, date_of_arrival VARCHAR(255) DEFAULT NULL, INDEX IDX_B723AF33305C84E6 (id_promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, id_support_worker_id INT NOT NULL, id_promotion_id INT NOT NULL, name VARCHAR(255) NOT NULL, date_of_start DATE NOT NULL, date_of_end DATE NOT NULL, INDEX IDX_FBCE3E7A2CC54997 (id_support_worker_id), INDEX IDX_FBCE3E7A305C84E6 (id_promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_worker (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, date_of_arrival VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE346E1ECFCD FOREIGN KEY (id_student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34A7B45C50 FOREIGN KEY (id_subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33305C84E6 FOREIGN KEY (id_promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A2CC54997 FOREIGN KEY (id_support_worker_id) REFERENCES support_worker (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A305C84E6 FOREIGN KEY (id_promotion_id) REFERENCES promotion (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33305C84E6');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A305C84E6');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE346E1ECFCD');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34A7B45C50');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A2CC54997');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE support_worker');
        $this->addSql('DROP TABLE `user`');
    }
}
