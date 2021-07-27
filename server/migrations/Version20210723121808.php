<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723121808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_tag DROP CONSTRAINT fk_322d97d87597d3fe');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_card_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_goal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_meeting_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE community_member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE meeting_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_goal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('CREATE TABLE community_card_list (id INT NOT NULL, community_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, card_types TEXT DEFAULT NULL, sorting VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, published BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D030914FDA7B0BF ON community_card_list (community_id)');
        $this->addSql('COMMENT ON COLUMN community_card_list.card_types IS \'(DC2Type:card_list_card_types)\'');
        $this->addSql('COMMENT ON COLUMN community_card_list.sorting IS \'(DC2Type:card_list_sorting)\'');
        $this->addSql('CREATE TABLE community_card_list_tag (card_list_id INT NOT NULL, tag_id INT NOT NULL, position SMALLINT DEFAULT NULL, PRIMARY KEY(card_list_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_CBD47A406AB49CFD ON community_card_list_tag (card_list_id)');
        $this->addSql('CREATE INDEX IDX_CBD47A40BAD26311 ON community_card_list_tag (tag_id)');
        $this->addSql('CREATE TABLE community_event (id INT NOT NULL, community_id INT NOT NULL, name VARCHAR(255) NOT NULL, event_type VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, register_url VARCHAR(255) NOT NULL, find_out_more_url VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_40DE70E3FDA7B0BF ON community_event (community_id)');
        $this->addSql('COMMENT ON COLUMN community_event.event_type IS \'(DC2Type:community_event_type)\'');
        $this->addSql('COMMENT ON COLUMN community_event.start_date IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN community_event.end_date IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE community_event_tag (event_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_B7BE81FE71F7E88B ON community_event_tag (event_id)');
        $this->addSql('CREATE INDEX IDX_B7BE81FEBAD26311 ON community_event_tag (tag_id)');
        $this->addSql('CREATE TABLE community_event_characterization_tag (event_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_CB4886371F7E88B ON community_event_characterization_tag (event_id)');
        $this->addSql('CREATE INDEX IDX_CB48863BAD26311 ON community_event_characterization_tag (tag_id)');
        $this->addSql('CREATE TABLE community_goal (id INT NOT NULL, community_id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, position INT DEFAULT NULL, min INT DEFAULT 0 NOT NULL, max INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D8D01E4FDA7B0BF ON community_goal (community_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E490BFD4B8 ON community_goal (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E4BAD26311 ON community_goal (tag_id)');
        $this->addSql('CREATE INDEX IDX_3D8D01E4727ACA70 ON community_goal (parent_id)');
        $this->addSql('CREATE TABLE community_goal_matching (goal_id INT NOT NULL, from_id INT NOT NULL, to_id INT NOT NULL, priority INT DEFAULT 0 NOT NULL, PRIMARY KEY(goal_id, from_id, to_id))');
        $this->addSql('CREATE INDEX IDX_885F8D1667D1AFE ON community_goal_matching (goal_id)');
        $this->addSql('CREATE INDEX IDX_885F8D178CED90B ON community_goal_matching (from_id)');
        $this->addSql('CREATE INDEX IDX_885F8D130354A65 ON community_goal_matching (to_id)');
        $this->addSql('CREATE TABLE community_media (id INT NOT NULL, community_id INT NOT NULL, media_type VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, published BOOLEAN NOT NULL, processed BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_115CDB48FDA7B0BF ON community_media (community_id)');
        $this->addSql('COMMENT ON COLUMN community_media.media_type IS \'(DC2Type:community_media_type)\'');
        $this->addSql('COMMENT ON COLUMN community_media.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE community_media_tag (media_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(media_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_ED2036D0EA9FDD75 ON community_media_tag (media_id)');
        $this->addSql('CREATE INDEX IDX_ED2036D0BAD26311 ON community_media_tag (tag_id)');
        $this->addSql('CREATE TABLE community_media_translation (language VARCHAR(255) NOT NULL, media_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, cta_label VARCHAR(255) DEFAULT NULL, cta_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(media_id, language))');
        $this->addSql('CREATE INDEX IDX_E8566994EA9FDD75 ON community_media_translation (media_id)');
        $this->addSql('CREATE TABLE community_meeting_slot (id INT NOT NULL, participant_from_id INT DEFAULT NULL, participant_to_id INT DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1FEE602AE2C31603 ON community_meeting_slot (participant_from_id)');
        $this->addSql('CREATE INDEX IDX_1FEE602AF180E3DC ON community_meeting_slot (participant_to_id)');
        $this->addSql('CREATE TABLE community_member (id INT NOT NULL, account_id INT NOT NULL, community_id INT NOT NULL, joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_12E0F8B9B6B5FBA ON community_member (account_id)');
        $this->addSql('CREATE INDEX IDX_12E0F8BFDA7B0BF ON community_member (community_id)');
        $this->addSql('COMMENT ON COLUMN community_member.joined_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE meeting_slot (id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN meeting_slot.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN meeting_slot.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE member_goal (id INT NOT NULL, member_id INT NOT NULL, community_goal_id INT NOT NULL, tag_id INT NOT NULL, priority INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_54C7727597D3FE ON member_goal (member_id)');
        $this->addSql('CREATE INDEX IDX_54C77242B873AD ON member_goal (community_goal_id)');
        $this->addSql('CREATE INDEX IDX_54C772BAD26311 ON member_goal (tag_id)');
        $this->addSql('CREATE TABLE nomenclature_tag_translation (locale VARCHAR(255) NOT NULL, nomenclature_tag_id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(nomenclature_tag_id, locale))');
        $this->addSql('CREATE INDEX IDX_7E483F3EA809481B ON nomenclature_tag_translation (nomenclature_tag_id)');
        $this->addSql('CREATE TABLE tag_translation (locale VARCHAR(255) NOT NULL, tag_id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(tag_id, locale))');
        $this->addSql('CREATE INDEX IDX_A8A03F8FBAD26311 ON tag_translation (tag_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE community_card_list ADD CONSTRAINT FK_D030914FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A406AB49CFD FOREIGN KEY (card_list_id) REFERENCES community_card_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_card_list_tag ADD CONSTRAINT FK_CBD47A40BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event ADD CONSTRAINT FK_40DE70E3FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_tag ADD CONSTRAINT FK_B7BE81FE71F7E88B FOREIGN KEY (event_id) REFERENCES community_event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_tag ADD CONSTRAINT FK_B7BE81FEBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_characterization_tag ADD CONSTRAINT FK_CB4886371F7E88B FOREIGN KEY (event_id) REFERENCES community_event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_event_characterization_tag ADD CONSTRAINT FK_CB48863BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E490BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal ADD CONSTRAINT FK_3D8D01E4727ACA70 FOREIGN KEY (parent_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D1667D1AFE FOREIGN KEY (goal_id) REFERENCES community_goal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D178CED90B FOREIGN KEY (from_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_goal_matching ADD CONSTRAINT FK_885F8D130354A65 FOREIGN KEY (to_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media ADD CONSTRAINT FK_115CDB48FDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_tag ADD CONSTRAINT FK_ED2036D0EA9FDD75 FOREIGN KEY (media_id) REFERENCES community_media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_tag ADD CONSTRAINT FK_ED2036D0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_media_translation ADD CONSTRAINT FK_E8566994EA9FDD75 FOREIGN KEY (media_id) REFERENCES community_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_meeting_slot ADD CONSTRAINT FK_1FEE602AE2C31603 FOREIGN KEY (participant_from_id) REFERENCES community_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_meeting_slot ADD CONSTRAINT FK_1FEE602AF180E3DC FOREIGN KEY (participant_to_id) REFERENCES community_member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_member ADD CONSTRAINT FK_12E0F8B9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community_member ADD CONSTRAINT FK_12E0F8BFDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C7727597D3FE FOREIGN KEY (member_id) REFERENCES community_member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C77242B873AD FOREIGN KEY (community_goal_id) REFERENCES community_goal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_goal ADD CONSTRAINT FK_54C772BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nomenclature_tag_translation ADD CONSTRAINT FK_7E483F3EA809481B FOREIGN KEY (nomenclature_tag_id) REFERENCES nomenclature_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_translation ADD CONSTRAINT FK_A8A03F8FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_tag');
        $this->addSql('ALTER TABLE account ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD job_position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD accepted_terms_and_condition_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD job_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD languages TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD country VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD timezone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD hubspot_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD validated BOOLEAN NOT NULL');
        $this->addSql('COMMENT ON COLUMN account.accepted_terms_and_condition_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account.languages IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4BEE8350F FOREIGN KEY (job_position_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4E7927C74 ON account (email)');
        $this->addSql('CREATE INDEX IDX_7D3656A4979B1AD6 ON account (company_id)');
        $this->addSql('CREATE INDEX IDX_7D3656A4BEE8350F ON account (job_position_id)');
        $this->addSql('ALTER TABLE community ADD skill_nomenclature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE community ADD event_nomenclature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE community ADD languages TEXT NOT NULL');
        $this->addSql('ALTER TABLE community ADD default_language VARCHAR(3) NOT NULL');
        $this->addSql('COMMENT ON COLUMN community.languages IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B604033A67EA72D FOREIGN KEY (skill_nomenclature_id) REFERENCES nomenclature (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE community ADD CONSTRAINT FK_1B604033596CB088 FOREIGN KEY (event_nomenclature_id) REFERENCES nomenclature (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1B604033A67EA72D ON community (skill_nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_1B604033596CB088 ON community (event_nomenclature_id)');
        $this->addSql('ALTER TABLE company ADD country_code VARCHAR(2) NOT NULL');
        $this->addSql('ALTER TABLE company ADD domain VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE company ADD activity VARCHAR(300) NOT NULL');
        $this->addSql('ALTER TABLE company ADD logo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD hubspot_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE company RENAME COLUMN description TO website');
        $this->addSql('COMMENT ON COLUMN company.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FA7A91E0B ON company (domain)');
        $this->addSql('ALTER TABLE nomenclature ALTER community_id DROP NOT NULL');
        $this->addSql('ALTER TABLE nomenclature RENAME COLUMN name TO reference');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT FK_AD775B7A727ACA70');
        $this->addSql('ALTER TABLE nomenclature_tag ADD external_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT FK_AD775B7A727ACA70 FOREIGN KEY (parent_id) REFERENCES nomenclature_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag RENAME COLUMN name TO external_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7839F75D7B0 ON tag (external_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE community_card_list_tag DROP CONSTRAINT FK_CBD47A406AB49CFD');
        $this->addSql('ALTER TABLE community_event_tag DROP CONSTRAINT FK_B7BE81FE71F7E88B');
        $this->addSql('ALTER TABLE community_event_characterization_tag DROP CONSTRAINT FK_CB4886371F7E88B');
        $this->addSql('ALTER TABLE community_goal DROP CONSTRAINT FK_3D8D01E4727ACA70');
        $this->addSql('ALTER TABLE community_goal_matching DROP CONSTRAINT FK_885F8D1667D1AFE');
        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT FK_54C77242B873AD');
        $this->addSql('ALTER TABLE community_media_tag DROP CONSTRAINT FK_ED2036D0EA9FDD75');
        $this->addSql('ALTER TABLE community_media_translation DROP CONSTRAINT FK_E8566994EA9FDD75');
//        $this->addSql('ALTER TABLE community_meeting_slot DROP CONSTRAINT FK_1FEE602AE2C31603');
//        $this->addSql('ALTER TABLE community_meeting_slot DROP CONSTRAINT FK_1FEE602AF180E3DC');
        $this->addSql('ALTER TABLE member_goal DROP CONSTRAINT FK_54C7727597D3FE');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_card_list_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_goal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_meeting_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE community_member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE meeting_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_goal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, account_id INT NOT NULL, community_id INT NOT NULL, joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_70e4fa78fda7b0bf ON member (community_id)');
        $this->addSql('CREATE INDEX idx_70e4fa789b6b5fba ON member (account_id)');
        $this->addSql('COMMENT ON COLUMN member.joined_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE member_tag (member_id INT NOT NULL, nomenclature_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(member_id, nomenclature_id, tag_id))');
        $this->addSql('CREATE INDEX idx_322d97d8bad26311 ON member_tag (tag_id)');
        $this->addSql('CREATE INDEX idx_322d97d890bfd4b8 ON member_tag (nomenclature_id)');
        $this->addSql('CREATE INDEX idx_322d97d87597d3fe ON member_tag (member_id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa789b6b5fba FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa78fda7b0bf FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d87597d3fe FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d890bfd4b8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member_tag ADD CONSTRAINT fk_322d97d8bad26311 FOREIGN KEY (tag_id) REFERENCES tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE community_card_list');
        $this->addSql('DROP TABLE community_card_list_tag');
        $this->addSql('DROP TABLE community_event');
        $this->addSql('DROP TABLE community_event_tag');
        $this->addSql('DROP TABLE community_event_characterization_tag');
        $this->addSql('DROP TABLE community_goal');
        $this->addSql('DROP TABLE community_goal_matching');
        $this->addSql('DROP TABLE community_media');
        $this->addSql('DROP TABLE community_media_tag');
        $this->addSql('DROP TABLE community_media_translation');
        $this->addSql('DROP TABLE community_meeting_slot');
        $this->addSql('DROP TABLE community_member');
        $this->addSql('DROP TABLE meeting_slot');
        $this->addSql('DROP TABLE member_goal');
        $this->addSql('DROP TABLE nomenclature_tag_translation');
        $this->addSql('DROP TABLE tag_translation');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_4FBF094FA7A91E0B');
        $this->addSql('ALTER TABLE company ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE company DROP country_code');
        $this->addSql('ALTER TABLE company DROP website');
        $this->addSql('ALTER TABLE company DROP domain');
        $this->addSql('ALTER TABLE company DROP activity');
        $this->addSql('ALTER TABLE company DROP logo');
        $this->addSql('ALTER TABLE company DROP hubspot_id');
        $this->addSql('ALTER TABLE company DROP created_at');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B604033A67EA72D');
        $this->addSql('ALTER TABLE community DROP CONSTRAINT FK_1B604033596CB088');
        $this->addSql('DROP INDEX IDX_1B604033A67EA72D');
        $this->addSql('DROP INDEX IDX_1B604033596CB088');
        $this->addSql('ALTER TABLE community DROP skill_nomenclature_id');
        $this->addSql('ALTER TABLE community DROP event_nomenclature_id');
        $this->addSql('ALTER TABLE community DROP languages');
        $this->addSql('ALTER TABLE community DROP default_language');
        $this->addSql('ALTER TABLE nomenclature ALTER community_id SET NOT NULL');
        $this->addSql('ALTER TABLE nomenclature RENAME COLUMN reference TO name');
        $this->addSql('DROP INDEX UNIQ_389B7839F75D7B0');
        $this->addSql('ALTER TABLE tag RENAME COLUMN external_id TO name');
        $this->addSql('ALTER TABLE nomenclature_tag DROP CONSTRAINT fk_ad775b7a727aca70');
        $this->addSql('ALTER TABLE nomenclature_tag DROP external_id');
        $this->addSql('ALTER TABLE nomenclature_tag ADD CONSTRAINT fk_ad775b7a727aca70 FOREIGN KEY (parent_id) REFERENCES nomenclature_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account DROP CONSTRAINT FK_7D3656A4979B1AD6');
        $this->addSql('ALTER TABLE account DROP CONSTRAINT FK_7D3656A4BEE8350F');
        $this->addSql('DROP INDEX UNIQ_7D3656A4E7927C74');
        $this->addSql('DROP INDEX IDX_7D3656A4979B1AD6');
        $this->addSql('DROP INDEX IDX_7D3656A4BEE8350F');
        $this->addSql('ALTER TABLE account DROP company_id');
        $this->addSql('ALTER TABLE account DROP job_position_id');
        $this->addSql('ALTER TABLE account DROP accepted_terms_and_condition_at');
        $this->addSql('ALTER TABLE account DROP avatar');
        $this->addSql('ALTER TABLE account DROP job_title');
        $this->addSql('ALTER TABLE account DROP languages');
        $this->addSql('ALTER TABLE account DROP country');
        $this->addSql('ALTER TABLE account DROP timezone');
        $this->addSql('ALTER TABLE account DROP hubspot_id');
        $this->addSql('ALTER TABLE account DROP validated');
    }
}
