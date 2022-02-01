<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201173410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, student_exam_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, points INT NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A25BABBEB69 (student_exam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_75BEEE3F41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_group (discipline_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_2AA7F78DA5522701 (discipline_id), INDEX IDX_2AA7F78DFE54D947 (group_id), PRIMARY KEY(discipline_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam_test (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, course INT NOT NULL, year DATE NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6DC044C541807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_student (group_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_3123FB3FFE54D947 (group_id), INDEX IDX_3123FB3FCB944F1A (student_id), PRIMARY KEY(group_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture (id INT AUTO_INCREMENT NOT NULL, discipline_id INT DEFAULT NULL, student_group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_C1677948A5522701 (discipline_id), INDEX IDX_C16779484DDF95DC (student_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, created_at DATETIME NOT NULL, text LONGTEXT NOT NULL, is_readed TINYINT(1) NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, type ENUM(\'open\', \'choices\'), text LONGTEXT DEFAULT NULL, text_length INT DEFAULT NULL, points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_choices (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, possibility VARCHAR(255) NOT NULL, is_correct TINYINT(1) NOT NULL, points INT NOT NULL, INDEX IDX_B1243241E27F6BF (question_id), INDEX IDX_B124324AA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_exam (id INT AUTO_INCREMENT NOT NULL, teacher_exam_id INT DEFAULT NULL, author_id INT DEFAULT NULL, finished_at DATETIME NOT NULL, evaluation INT DEFAULT NULL, INDEX IDX_798DD1E9A4FD3D0 (teacher_exam_id), INDEX IDX_798DD1EF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_exam (id INT AUTO_INCREMENT NOT NULL, discipline_id INT DEFAULT NULL, test_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, started_at DATETIME NOT NULL, token VARCHAR(255) NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_1907C1F7A5522701 (discipline_id), INDEX IDX_1907C1F71E5D0459 (test_id), INDEX IDX_1907C1F761220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25BABBEB69 FOREIGN KEY (student_exam_id) REFERENCES student_exam (id)');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discipline_group ADD CONSTRAINT FK_2AA7F78DA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_group ADD CONSTRAINT FK_2AA7F78DFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C541807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_student ADD CONSTRAINT FK_3123FB3FFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_student ADD CONSTRAINT FK_3123FB3FCB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779484DDF95DC FOREIGN KEY (student_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question_choices ADD CONSTRAINT FK_B1243241E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question_choices ADD CONSTRAINT FK_B124324AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE student_exam ADD CONSTRAINT FK_798DD1E9A4FD3D0 FOREIGN KEY (teacher_exam_id) REFERENCES teacher_exam (id)');
        $this->addSql('ALTER TABLE student_exam ADD CONSTRAINT FK_798DD1EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teacher_exam ADD CONSTRAINT FK_1907C1F7A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE teacher_exam ADD CONSTRAINT FK_1907C1F71E5D0459 FOREIGN KEY (test_id) REFERENCES exam_test (id)');
        $this->addSql('ALTER TABLE teacher_exam ADD CONSTRAINT FK_1907C1F761220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_choices DROP FOREIGN KEY FK_B124324AA334807');
        $this->addSql('ALTER TABLE discipline_group DROP FOREIGN KEY FK_2AA7F78DA5522701');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948A5522701');
        $this->addSql('ALTER TABLE teacher_exam DROP FOREIGN KEY FK_1907C1F7A5522701');
        $this->addSql('ALTER TABLE teacher_exam DROP FOREIGN KEY FK_1907C1F71E5D0459');
        $this->addSql('ALTER TABLE discipline_group DROP FOREIGN KEY FK_2AA7F78DFE54D947');
        $this->addSql('ALTER TABLE group_student DROP FOREIGN KEY FK_3123FB3FFE54D947');
        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C16779484DDF95DC');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE question_choices DROP FOREIGN KEY FK_B1243241E27F6BF');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25BABBEB69');
        $this->addSql('ALTER TABLE student_exam DROP FOREIGN KEY FK_798DD1E9A4FD3D0');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE discipline_group');
        $this->addSql('DROP TABLE exam_test');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_student');
        $this->addSql('DROP TABLE lecture');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_choices');
        $this->addSql('DROP TABLE student_exam');
        $this->addSql('DROP TABLE teacher_exam');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
