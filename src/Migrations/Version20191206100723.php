<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191206100723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE topology.topology_id_seq CASCADE');
        $this->addSql('DROP TABLE topology.topology');
        $this->addSql('DROP TABLE topology.layer');
        $this->addSql('ALTER TABLE admin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE admin ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE admin ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN admin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT admin_has_report_id_admin_fkey');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT admin_has_report_id_report_fkey');
        $this->addSql('DROP INDEX IDX_2033C69A668B4C46');
        $this->addSql('DROP INDEX IDX_2033C69AE218C269');
        $this->addSql('ALTER TABLE admin_has_report ADD id_report_id UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_has_report ADD id_admin_id UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_has_report DROP id_report');
        $this->addSql('ALTER TABLE admin_has_report DROP id_admin');
        $this->addSql('ALTER TABLE admin_has_report ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE admin_has_report ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE admin_has_report ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id_report_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id_admin_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT FK_2033C69ACBE718E7 FOREIGN KEY (id_report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT FK_2033C69A34F06E85 FOREIGN KEY (id_admin_id) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2033C69ACBE718E7 ON admin_has_report (id_report_id)');
        $this->addSql('CREATE INDEX IDX_2033C69A34F06E85 ON admin_has_report (id_admin_id)');
        $this->addSql('ALTER TABLE bin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE bin ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE bin ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE bin RENAME COLUMN coord TO coords');
        $this->addSql('COMMENT ON COLUMN bin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE consumer DROP CONSTRAINT consumer_id_closest_bin_fkey');
        $this->addSql('DROP INDEX IDX_705B37274E1F76F3');
        $this->addSql('ALTER TABLE consumer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin DROP DEFAULT');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin SET NOT NULL');
        $this->addSql('ALTER TABLE consumer ALTER device TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER navigator TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN consumer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer.id_closest_bin IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT consumer_has_bin_id_bin_fkey');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT consumer_has_bin_id_consumer_fkey');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT consumer_has_bin_id_report_fkey');
        $this->addSql('DROP INDEX IDX_EB430E023483B2B7');
        $this->addSql('DROP INDEX IDX_EB430E022080DBB2');
        $this->addSql('DROP INDEX IDX_EB430E02E218C269');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_bin_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_consumer_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_report_id UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD action VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_report');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_consumer');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_bin');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_bin_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_consumer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id_report_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E024123331 FOREIGN KEY (id_bin_id) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E022FEF709A FOREIGN KEY (id_consumer_id) REFERENCES consumer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT FK_EB430E02CBE718E7 FOREIGN KEY (id_report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EB430E024123331 ON consumer_has_bin (id_bin_id)');
        $this->addSql('CREATE INDEX IDX_EB430E022FEF709A ON consumer_has_bin (id_consumer_id)');
        $this->addSql('CREATE INDEX IDX_EB430E02CBE718E7 ON consumer_has_bin (id_report_id)');
        $this->addSql('ALTER TABLE report DROP CONSTRAINT report_id_bin_fkey');
        $this->addSql('DROP INDEX IDX_C42F77843483B2B7');
        $this->addSql('ALTER TABLE report DROP id_bin');
        $this->addSql('ALTER TABLE report ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE report ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE report ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE report ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE report ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN report.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('CREATE SEQUENCE topology.topology_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE topology.topology (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, srid INT NOT NULL, "precision" DOUBLE PRECISION NOT NULL, hasz BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX topology_name_key ON topology.topology (name)');
        $this->addSql('CREATE TABLE topology.layer (topology_id INT NOT NULL, layer_id INT NOT NULL, schema_name VARCHAR(255) NOT NULL, table_name VARCHAR(255) NOT NULL, feature_column VARCHAR(255) NOT NULL, feature_type INT NOT NULL, level INT DEFAULT 0 NOT NULL, child_id INT DEFAULT NULL, PRIMARY KEY(topology_id, layer_id))');
        $this->addSql('CREATE UNIQUE INDEX layer_schema_name_table_name_feature_column_key ON topology.layer (schema_name, table_name, feature_column)');
        $this->addSql('CREATE INDEX IDX_181D8D68ED697DD5 ON topology.layer (topology_id)');
        $this->addSql('ALTER TABLE topology.layer ADD CONSTRAINT layer_topology_id_fkey FOREIGN KEY (topology_id) REFERENCES topology (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report ADD id_bin UUID NOT NULL');
        $this->addSql('ALTER TABLE report ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE report ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE report ALTER type TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE report ALTER status TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN report.id IS NULL');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT report_id_bin_fkey FOREIGN KEY (id_bin) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C42F77843483B2B7 ON report (id_bin)');
        $this->addSql('ALTER TABLE bin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE bin ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE bin ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE bin RENAME COLUMN coords TO coord');
        $this->addSql('COMMENT ON COLUMN bin.id IS NULL');
        $this->addSql('ALTER TABLE admin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE admin ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE admin ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN admin.id IS NULL');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT FK_2033C69ACBE718E7');
        $this->addSql('ALTER TABLE admin_has_report DROP CONSTRAINT FK_2033C69A34F06E85');
        $this->addSql('DROP INDEX IDX_2033C69ACBE718E7');
        $this->addSql('DROP INDEX IDX_2033C69A34F06E85');
        $this->addSql('ALTER TABLE admin_has_report ADD id_report UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_has_report ADD id_admin UUID NOT NULL');
        $this->addSql('ALTER TABLE admin_has_report DROP id_report_id');
        $this->addSql('ALTER TABLE admin_has_report DROP id_admin_id');
        $this->addSql('ALTER TABLE admin_has_report ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE admin_has_report ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE admin_has_report ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN admin_has_report.id IS NULL');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT admin_has_report_id_admin_fkey FOREIGN KEY (id_admin) REFERENCES admin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_has_report ADD CONSTRAINT admin_has_report_id_report_fkey FOREIGN KEY (id_report) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2033C69A668B4C46 ON admin_has_report (id_admin)');
        $this->addSql('CREATE INDEX IDX_2033C69AE218C269 ON admin_has_report (id_report)');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E024123331');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E022FEF709A');
        $this->addSql('ALTER TABLE consumer_has_bin DROP CONSTRAINT FK_EB430E02CBE718E7');
        $this->addSql('DROP INDEX IDX_EB430E024123331');
        $this->addSql('DROP INDEX IDX_EB430E022FEF709A');
        $this->addSql('DROP INDEX IDX_EB430E02CBE718E7');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_report UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_consumer UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD id_bin UUID NOT NULL');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_bin_id');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_consumer_id');
        $this->addSql('ALTER TABLE consumer_has_bin DROP id_report_id');
        $this->addSql('ALTER TABLE consumer_has_bin DROP action');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE consumer_has_bin ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN consumer_has_bin.id IS NULL');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT consumer_has_bin_id_bin_fkey FOREIGN KEY (id_bin) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT consumer_has_bin_id_consumer_fkey FOREIGN KEY (id_consumer) REFERENCES consumer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consumer_has_bin ADD CONSTRAINT consumer_has_bin_id_report_fkey FOREIGN KEY (id_report) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EB430E023483B2B7 ON consumer_has_bin (id_bin)');
        $this->addSql('CREATE INDEX IDX_EB430E022080DBB2 ON consumer_has_bin (id_consumer)');
        $this->addSql('CREATE INDEX IDX_EB430E02E218C269 ON consumer_has_bin (id_report)');
        $this->addSql('ALTER TABLE consumer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id SET DEFAULT \'uuid_generate_v1()\'');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin DROP DEFAULT');
        $this->addSql('ALTER TABLE consumer ALTER id_closest_bin DROP NOT NULL');
        $this->addSql('ALTER TABLE consumer ALTER device TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE consumer ALTER navigator TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE consumer ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN consumer.id IS NULL');
        $this->addSql('COMMENT ON COLUMN consumer.id_closest_bin IS NULL');
        $this->addSql('ALTER TABLE consumer ADD CONSTRAINT consumer_id_closest_bin_fkey FOREIGN KEY (id_closest_bin) REFERENCES bin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_705B37274E1F76F3 ON consumer (id_closest_bin)');
    }
}
