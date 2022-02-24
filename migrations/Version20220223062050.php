<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223062050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam_test ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exam_test ADD CONSTRAINT FK_559BF8BFF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_559BF8BFF675F31B ON exam_test (author_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE exam_test DROP FOREIGN KEY FK_559BF8BFF675F31B');
        $this->addSql('DROP INDEX IDX_559BF8BFF675F31B ON exam_test');
        $this->addSql('ALTER TABLE exam_test DROP author_id');
    }
}
