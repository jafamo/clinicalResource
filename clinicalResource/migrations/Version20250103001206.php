<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250103001206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create specialist_with_doctor table pivote';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specialist_with_doctor (doctor_id INT NOT NULL, speciality_id INT NOT NULL, INDEX IDX_52D32EFF87F4FB17 (doctor_id), INDEX IDX_52D32EFF3B5A08D7 (speciality_id), PRIMARY KEY(doctor_id, speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specialist_with_doctor ADD CONSTRAINT FK_52D32EFF87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialist_with_doctor ADD CONSTRAINT FK_52D32EFF3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES specialization (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE specialist_with_doctor DROP FOREIGN KEY FK_52D32EFF87F4FB17');
        $this->addSql('ALTER TABLE specialist_with_doctor DROP FOREIGN KEY FK_52D32EFF3B5A08D7');
        $this->addSql('DROP TABLE specialist_with_doctor');
    }
}
