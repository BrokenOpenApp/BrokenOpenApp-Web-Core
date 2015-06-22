<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class Version20150525155312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

		$this->addSql('CREATE SEQUENCE crash_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE incoming_crash_acra_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE issue_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE issue_title_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
		$this->addSql('CREATE TABLE crash (id BIGINT DEFAULT NEXTVAL(\'crash_id_seq\') NOT NULL, project_id INT NOT NULL, incoming_crash_acra_id INT DEFAULT NULL, issue_id BIGINT DEFAULT NULL, reporter_ip VARCHAR(250) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, report_id TEXT DEFAULT NULL, app_version_code TEXT DEFAULT NULL, app_version_name TEXT DEFAULT NULL, package_name TEXT DEFAULT NULL, file_path TEXT DEFAULT NULL, phone_model TEXT DEFAULT NULL, android_version TEXT DEFAULT NULL, brand TEXT DEFAULT NULL, product TEXT DEFAULT NULL, total_mem_size BIGINT DEFAULT NULL, available_mem_size BIGINT DEFAULT NULL, stack_trace TEXT DEFAULT NULL, stack_trace_obscured TEXT DEFAULT NULL, user_comment TEXT DEFAULT NULL, user_app_start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, user_crash_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, dumpsys_meminfo TEXT DEFAULT NULL, dropbox TEXT DEFAULT NULL, logcat TEXT DEFAULT NULL, eventslog TEXT DEFAULT NULL, radiolog TEXT DEFAULT NULL, is_silent TEXT DEFAULT NULL, device_id TEXT DEFAULT NULL, installation_id TEXT DEFAULT NULL, user_email TEXT DEFAULT NULL, media_codec_list TEXT DEFAULT NULL, thread_details TEXT DEFAULT NULL, application_log TEXT DEFAULT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_5C84F52A166D1F9C ON crash (project_id)');
		$this->addSql('CREATE INDEX IDX_5C84F52A4D63144E ON crash (incoming_crash_acra_id)');
		$this->addSql('CREATE INDEX IDX_5C84F52A5E7AA58C ON crash (issue_id)');
		$this->addSql('CREATE TABLE crash_build (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_16E611825AF93C1D ON crash_build (crash_id)');
		$this->addSql('CREATE TABLE crash_crash_configuration (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_1D312C8B5AF93C1D ON crash_crash_configuration (crash_id)');
		$this->addSql('CREATE TABLE crash_custom_data (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_83226ACE5AF93C1D ON crash_custom_data (crash_id)');
		$this->addSql('CREATE TABLE crash_display (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_5EAB8C3A5AF93C1D ON crash_display (crash_id)');
		$this->addSql('CREATE TABLE crash_environment (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_69818F725AF93C1D ON crash_environment (crash_id)');
		$this->addSql('CREATE TABLE crash_features (crash_id BIGINT NOT NULL, key TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_36418D0D5AF93C1D ON crash_features (crash_id)');
		$this->addSql('CREATE TABLE crash_initial_configuration (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_C50E13FE5AF93C1D ON crash_initial_configuration (crash_id)');
		$this->addSql('CREATE TABLE crash_settings_global (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_B59F7A35AF93C1D ON crash_settings_global (crash_id)');
		$this->addSql('CREATE TABLE crash_settings_secure (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_D58226245AF93C1D ON crash_settings_secure (crash_id)');
		$this->addSql('CREATE TABLE crash_settings_system (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_2A116DAB5AF93C1D ON crash_settings_system (crash_id)');
		$this->addSql('CREATE TABLE crash_shared_preferences (crash_id BIGINT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, PRIMARY KEY(crash_id, key))');
		$this->addSql('CREATE INDEX IDX_3CCFA43F5AF93C1D ON crash_shared_preferences (crash_id)');
		$this->addSql('CREATE TABLE incoming_crash_acra (id INT DEFAULT NEXTVAL(\'incoming_crash_acra_id_seq\') NOT NULL, project_id INT NOT NULL, incoming_crash_key VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_C5C899DD6AEE83BE ON incoming_crash_acra (incoming_crash_key)');
		$this->addSql('CREATE INDEX IDX_C5C899DD166D1F9C ON incoming_crash_acra (project_id)');
		$this->addSql('CREATE TABLE issue (id BIGINT DEFAULT NEXTVAL(\'issue_id_seq\') NOT NULL, project_id INT NOT NULL, number BIGINT NOT NULL, fingerprint VARCHAR(32) NOT NULL, title VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_99C126CB166D1F9C ON issue (project_id)');
		$this->addSql('CREATE UNIQUE INDEX issue_fingerprint_unique ON issue (project_id, fingerprint)');
		$this->addSql('CREATE UNIQUE INDEX issue_number_unique ON issue (project_id, number)');
		$this->addSql('CREATE TABLE issue_history_title (id BIGINT DEFAULT NEXTVAL(\'issue_title_history_id_seq\') NOT NULL, issue_id BIGINT NOT NULL, user_id INT NOT NULL, title VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_2AECDC5A5E7AA58C ON issue_history_title (issue_id)');
		$this->addSql('CREATE INDEX IDX_2AECDC5AA76ED395 ON issue_history_title (user_id)');
		$this->addSql('CREATE TABLE proguard_mapping (id BIGINT NOT NULL, project_id INT NOT NULL, package_name TEXT NOT NULL, app_version_code BIGINT NOT NULL, path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE INDEX IDX_1879B771166D1F9C ON proguard_mapping (project_id)');
		$this->addSql('CREATE UNIQUE INDEX proguard_mapping_unique ON proguard_mapping (project_id, package_name, app_version_code)');
		$this->addSql('CREATE TABLE project (id INT DEFAULT NEXTVAL(\'project_id_seq\') NOT NULL, title TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE TABLE user_account (id INT DEFAULT NEXTVAL(\'user_id_seq\') NOT NULL, password VARCHAR(64) DEFAULT NULL, email VARCHAR(200) NOT NULL, is_super_admin BOOLEAN NOT NULL, is_create_project BOOLEAN NOT NULL, is_locked BOOLEAN NOT NULL, is_all_projects_read BOOLEAN NOT NULL, is_all_projects_write BOOLEAN NOT NULL, is_all_projects_admin BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_5F2EC913E7927C74 ON user_account (email)');
		$this->addSql('CREATE TABLE user_in_project (user_id INT NOT NULL, project_id INT NOT NULL, is_owner BOOLEAN NOT NULL, is_admin BOOLEAN NOT NULL, is_write BOOLEAN NOT NULL, is_read BOOLEAN NOT NULL, is_accepted BOOLEAN NOT NULL, is_refused BOOLEAN NOT NULL, is_send_notification_on_new_issue BOOLEAN NOT NULL, PRIMARY KEY(user_id, project_id))');
		$this->addSql('CREATE INDEX IDX_72C03C82A76ED395 ON user_in_project (user_id)');
		$this->addSql('CREATE INDEX IDX_72C03C82166D1F9C ON user_in_project (project_id)');
		$this->addSql('CREATE TABLE user_reset_password (user_id INT NOT NULL, key VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, reset_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(user_id, key))');
		$this->addSql('CREATE INDEX IDX_5B15F137A76ED395 ON user_reset_password (user_id)');
		$this->addSql('CREATE TABLE user_verify_email (user_id INT NOT NULL, key VARCHAR(250) NOT NULL, email VARCHAR(200) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(user_id, key))');
		$this->addSql('CREATE INDEX IDX_222F84FCA76ED395 ON user_verify_email (user_id)');
		$this->addSql('ALTER TABLE crash ADD CONSTRAINT FK_5C84F52A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash ADD CONSTRAINT FK_5C84F52A4D63144E FOREIGN KEY (incoming_crash_acra_id) REFERENCES incoming_crash_acra (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash ADD CONSTRAINT FK_5C84F52A5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_build ADD CONSTRAINT FK_16E611825AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_crash_configuration ADD CONSTRAINT FK_1D312C8B5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_custom_data ADD CONSTRAINT FK_83226ACE5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_display ADD CONSTRAINT FK_5EAB8C3A5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_environment ADD CONSTRAINT FK_69818F725AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_features ADD CONSTRAINT FK_36418D0D5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_initial_configuration ADD CONSTRAINT FK_C50E13FE5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_settings_global ADD CONSTRAINT FK_B59F7A35AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_settings_secure ADD CONSTRAINT FK_D58226245AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_settings_system ADD CONSTRAINT FK_2A116DAB5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE crash_shared_preferences ADD CONSTRAINT FK_3CCFA43F5AF93C1D FOREIGN KEY (crash_id) REFERENCES crash (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE incoming_crash_acra ADD CONSTRAINT FK_C5C899DD166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_99C126CB166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE issue_history_title ADD CONSTRAINT FK_2AECDC5A5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE issue_history_title ADD CONSTRAINT FK_2AECDC5AA76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE proguard_mapping ADD CONSTRAINT FK_1879B771166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE user_in_project ADD CONSTRAINT FK_72C03C82A76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE user_in_project ADD CONSTRAINT FK_72C03C82166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE user_reset_password ADD CONSTRAINT FK_5B15F137A76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
		$this->addSql('ALTER TABLE user_verify_email ADD CONSTRAINT FK_222F84FCA76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

	}

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

		$this->abortIf(true, "Why would you go down this migration?");

    }
}
