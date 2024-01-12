<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112002056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', location_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, date DATE NOT NULL, time_begin TIME DEFAULT NULL, time_end TIME DEFAULT NULL, is_draft TINYINT(1) NOT NULL, INDEX IDX_3BAE0AA764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_feature (event_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', feature_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_9A80DCC97B04360 (event_entity_id), INDEX IDX_9A80DCC9373ABDCF (feature_entity_id), PRIMARY KEY(event_entity_id, feature_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_property (event_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_CD1EF50E7B04360 (event_entity_id), INDEX IDX_CD1EF50EF0CA7FE0 (property_entity_id), PRIMARY KEY(event_entity_id, property_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_target_group (event_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', target_group_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_3C78D53A7B04360 (event_entity_id), INDEX IDX_3C78D53A398C3DF (target_group_entity_id), PRIMARY KEY(event_entity_id, target_group_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_template (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', location_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, event_name VARCHAR(255) NOT NULL, time_begin TIME DEFAULT NULL, time_end TIME DEFAULT NULL, INDEX IDX_D18CF65364D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_template_feature (event_template_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', feature_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6A7FED977256C37F (event_template_entity_id), INDEX IDX_6A7FED97373ABDCF (feature_entity_id), PRIMARY KEY(event_template_entity_id, feature_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_template_property (event_template_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_413D76CC7256C37F (event_template_entity_id), INDEX IDX_413D76CCF0CA7FE0 (property_entity_id), PRIMARY KEY(event_template_entity_id, property_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_template_target_group (event_template_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', target_group_entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_59E8EE047256C37F (event_template_entity_id), INDEX IDX_59E8EE04398C3DF (target_group_entity_id), PRIMARY KEY(event_template_entity_id, target_group_entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(50) NOT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE target_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event_feature ADD CONSTRAINT FK_9A80DCC97B04360 FOREIGN KEY (event_entity_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_feature ADD CONSTRAINT FK_9A80DCC9373ABDCF FOREIGN KEY (feature_entity_id) REFERENCES feature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_property ADD CONSTRAINT FK_CD1EF50E7B04360 FOREIGN KEY (event_entity_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_property ADD CONSTRAINT FK_CD1EF50EF0CA7FE0 FOREIGN KEY (property_entity_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_target_group ADD CONSTRAINT FK_3C78D53A7B04360 FOREIGN KEY (event_entity_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_target_group ADD CONSTRAINT FK_3C78D53A398C3DF FOREIGN KEY (target_group_entity_id) REFERENCES target_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template ADD CONSTRAINT FK_D18CF65364D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE event_template_feature ADD CONSTRAINT FK_6A7FED977256C37F FOREIGN KEY (event_template_entity_id) REFERENCES event_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template_feature ADD CONSTRAINT FK_6A7FED97373ABDCF FOREIGN KEY (feature_entity_id) REFERENCES feature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template_property ADD CONSTRAINT FK_413D76CC7256C37F FOREIGN KEY (event_template_entity_id) REFERENCES event_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template_property ADD CONSTRAINT FK_413D76CCF0CA7FE0 FOREIGN KEY (property_entity_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template_target_group ADD CONSTRAINT FK_59E8EE047256C37F FOREIGN KEY (event_template_entity_id) REFERENCES event_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_template_target_group ADD CONSTRAINT FK_59E8EE04398C3DF FOREIGN KEY (target_group_entity_id) REFERENCES target_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE event_feature DROP FOREIGN KEY FK_9A80DCC97B04360');
        $this->addSql('ALTER TABLE event_feature DROP FOREIGN KEY FK_9A80DCC9373ABDCF');
        $this->addSql('ALTER TABLE event_property DROP FOREIGN KEY FK_CD1EF50E7B04360');
        $this->addSql('ALTER TABLE event_property DROP FOREIGN KEY FK_CD1EF50EF0CA7FE0');
        $this->addSql('ALTER TABLE event_target_group DROP FOREIGN KEY FK_3C78D53A7B04360');
        $this->addSql('ALTER TABLE event_target_group DROP FOREIGN KEY FK_3C78D53A398C3DF');
        $this->addSql('ALTER TABLE event_template DROP FOREIGN KEY FK_D18CF65364D218E');
        $this->addSql('ALTER TABLE event_template_feature DROP FOREIGN KEY FK_6A7FED977256C37F');
        $this->addSql('ALTER TABLE event_template_feature DROP FOREIGN KEY FK_6A7FED97373ABDCF');
        $this->addSql('ALTER TABLE event_template_property DROP FOREIGN KEY FK_413D76CC7256C37F');
        $this->addSql('ALTER TABLE event_template_property DROP FOREIGN KEY FK_413D76CCF0CA7FE0');
        $this->addSql('ALTER TABLE event_template_target_group DROP FOREIGN KEY FK_59E8EE047256C37F');
        $this->addSql('ALTER TABLE event_template_target_group DROP FOREIGN KEY FK_59E8EE04398C3DF');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_feature');
        $this->addSql('DROP TABLE event_property');
        $this->addSql('DROP TABLE event_target_group');
        $this->addSql('DROP TABLE event_template');
        $this->addSql('DROP TABLE event_template_feature');
        $this->addSql('DROP TABLE event_template_property');
        $this->addSql('DROP TABLE event_template_target_group');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE target_group');
    }
}
