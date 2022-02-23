<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223065556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE question ADD exam_test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E13FB5D31 FOREIGN KEY (exam_test_id) REFERENCES exam_test (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E13FB5D31 ON question (exam_test_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E13FB5D31');
        $this->addSql('DROP INDEX IDX_B6F7494E13FB5D31 ON question');
        $this->addSql('ALTER TABLE question DROP exam_test_id');
    }
}
