<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212102354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow delete in cascade Specialization';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE specialist_with_doctor DROP FOREIGN KEY FK_52D32EFF3B5A08D7');
        $this->addSql('ALTER TABLE specialist_with_doctor ADD CONSTRAINT FK_52D32EFF3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialization(id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE specialist_with_doctor DROP FOREIGN KEY FK_52D32EFF3B5A08D7');
        $this->addSql('ALTER TABLE specialist_with_doctor ADD CONSTRAINT FK_52D32EFF3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialization(id)');
    }

}
