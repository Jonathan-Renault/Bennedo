<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114120113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE admin ALTER token DROP NOT NULL');
        $this->addSql('ALTER TABLE admin_has_report ALTER id_report_id SET NOT NULL');
        $this->addSql('ALTER TABLE bin ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consumer ADD check_info VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consumer DROP device');
        $this->addSql('ALTER TABLE consumer DROP navigator');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT fk_eb430e024123331');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT fk_eb430e022fef709a');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT fk_eb430e02cbe718e7');
        $this->addSql('DROP INDEX idx_eb430e02cbe718e7');
        $this->addSql('DROP INDEX idx_eb430e022fef709a');
        $this->addSql('DROP INDEX idx_eb430e024123331');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_bin UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_consumer UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_report UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_bin_id');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_consumer_id');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_report_id');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_bin IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_consumer IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_report IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE report ADD id_bin UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN report.id_bin IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('ALTER TABLE report DROP id_bin');
        $this->addSql('ALTER TABLE admin_has_report ALTER id_report_id DROP NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER token SET NOT NULL');
        $this->addSql('ALTER TABLE bin DROP name');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_bin_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_consumer_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_report_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_bin');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_consumer');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_report');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_bin_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_consumer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_report_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT fk_eb430e024123331 FOREIGN KEY (id_bin_id) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT fk_eb430e022fef709a FOREIGN KEY (id_consumer_id) REFERENCES consumer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT fk_eb430e02cbe718e7 FOREIGN KEY (id_report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eb430e02cbe718e7 ON consumer_has_bin (id_report_id)');
        $this->addSql('CREATE INDEX idx_eb430e022fef709a ON consumer_has_bin (id_consumer_id)');
        $this->addSql('CREATE INDEX idx_eb430e024123331 ON consumer_has_bin (id_bin_id)');
        $this->addSql('ALTER TABLE consumer ADD navigator VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consumer RENAME COLUMN check_info TO device');
    }
}
