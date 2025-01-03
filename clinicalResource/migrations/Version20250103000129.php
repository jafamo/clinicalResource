<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250103000129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables: doctor, medical_with_doctor and medical_center';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, opening_times VARCHAR(255) DEFAULT NULL, link_web LONGTEXT DEFAULT NULL, map_web LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_with_doctor (doctor_id INT NOT NULL, medical_center_id INT NOT NULL, INDEX IDX_D64BF4D487F4FB17 (doctor_id), INDEX IDX_D64BF4D4AC41ADCD (medical_center_id), PRIMARY KEY(doctor_id, medical_center_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_center (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone_generic VARCHAR(20) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, map_link LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medical_with_doctor ADD CONSTRAINT FK_D64BF4D487F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical_with_doctor ADD CONSTRAINT FK_D64BF4D4AC41ADCD FOREIGN KEY (medical_center_id) REFERENCES medical_center (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medical_with_doctor DROP FOREIGN KEY FK_D64BF4D487F4FB17');
        $this->addSql('ALTER TABLE medical_with_doctor DROP FOREIGN KEY FK_D64BF4D4AC41ADCD');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE medical_with_doctor');
        $this->addSql('DROP TABLE medical_center');
    }
}
