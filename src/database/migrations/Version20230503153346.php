<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20230503153346 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE appointments (id UUID NOT NULL, doctor_id UUID NOT NULL, patient_id UUID NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finish_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A41727A87F4FB17 ON appointments (doctor_id)');
        $this->addSql('CREATE INDEX IDX_6A41727A6B899279 ON appointments (patient_id)');
        $this->addSql('COMMENT ON COLUMN appointments.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN appointments.doctor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN appointments.patient_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN appointments.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A6B899279 FOREIGN KEY (patient_id) REFERENCES patients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE appointments');
    }
}
