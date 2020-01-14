<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200109094247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE admin (id UUID NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, role VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN admin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE admin_has_report (id UUID NOT NULL, id_report_id UUID NOT NULL, id_admin_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2033C69ACBE718E7 ON admin_has_report (id_report_id)');
        $this->addSql('CREATE INDEX IDX_2033C69A34F06E85 ON admin_has_report (id_admin_id)');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id_report_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id_admin_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE bin (id UUID NOT NULL, name VARCHAR(255) NOT NULL, coords geography(POINT, 4326) NOT NULL, city VARCHAR(255) NOT NULL, city_code INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN bin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE consumer (id UUID NOT NULL, coords geography(POINT, 4326) DEFAULT NULL, ip_address VARCHAR(255) NOT NULL, id_closest_bin UUID NOT NULL, device VARCHAR(255) NOT NULL, navigator VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN consumer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer.id_closest_bin IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE consumer_has_bin (id UUID NOT NULL, id_bin_id UUID NOT NULL, id_consumer_id UUID NOT NULL, id_report_id UUID NOT NULL, action VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EB430E024123331 ON consumer_has_bin (id_bin_id)');
        $this->addSql('CREATE INDEX IDX_EB430E022FEF709A ON consumer_has_bin (id_consumer_id)');
        $this->addSql('CREATE INDEX IDX_EB430E02CBE718E7 ON consumer_has_bin (id_report_id)');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_bin_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_consumer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_report_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE report (id UUID NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, time_resolved TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN report.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT FK_2033C69ACBE718E7 FOREIGN KEY (id_report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT FK_2033C69A34F06E85 FOREIGN KEY (id_admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E024123331 FOREIGN KEY (id_bin_id) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E022FEF709A FOREIGN KEY (id_consumer_id) REFERENCES consumer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E02CBE718E7 FOREIGN KEY (id_report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT FK_2033C69A34F06E85');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E024123331');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E022FEF709A');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT FK_2033C69ACBE718E7');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E02CBE718E7');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE admin_has_report');
        $this->addSql('DROP TABLE bin');
        $this->addSql('DROP TABLE consumer');
        $this->addSql('DROP TABLE consumer_has_bin');
        $this->addSql('DROP TABLE report');
    }
}
