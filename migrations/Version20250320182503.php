<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320182503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP INDEX user_id, ADD UNIQUE INDEX UNIQ_D8698A76A76ED395 (user_id)');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY document_ibfk_1');
        $this->addSql('DROP INDEX pinecone_id ON document');
        $this->addSql('ALTER TABLE document ADD pinecode_id INT NOT NULL, DROP pinecone_id, CHANGE content content LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8698A76E4B1925 ON document (pinecode_id)');
        $this->addSql('ALTER TABLE document_analysis DROP FOREIGN KEY document_analysis_ibfk_1');
        $this->addSql('DROP INDEX document_id ON document_analysis');
        $this->addSql('ALTER TABLE document_analysis CHANGE summary summary LONGTEXT DEFAULT NULL, CHANGE keywords keywords LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD status VARCHAR(20) NOT NULL, ADD roles JSON NOT NULL, DROP role, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498B8E8428 ON user (created_at)');
        $this->addSql('ALTER TABLE user RENAME INDEX email TO UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY user_session_ibfk_1');
        $this->addSql('DROP INDEX user_id ON user_session');
        $this->addSql('ALTER TABLE user_session CHANGE token token VARCHAR(255) NOT NULL, CHANGE expires_at expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_session RENAME INDEX token TO UNIQ_8849CBDE5F37A13B');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D6498B8E8428 ON `user`');
        $this->addSql('ALTER TABLE `user` ADD role VARCHAR(255) DEFAULT \'USER\', DROP status, DROP roles, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_8d93d649e7927c74 TO email');
        $this->addSql('ALTER TABLE user_session CHANGE token token VARCHAR(512) NOT NULL, CHANGE expires_at expires_at DATETIME NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT user_session_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX user_id ON user_session (user_id)');
        $this->addSql('ALTER TABLE user_session RENAME INDEX uniq_8849cbde5f37a13b TO token');
        $this->addSql('ALTER TABLE document_analysis CHANGE summary summary TEXT DEFAULT NULL, CHANGE keywords keywords TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE document_analysis ADD CONSTRAINT document_analysis_ibfk_1 FOREIGN KEY (document_id) REFERENCES document (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX document_id ON document_analysis (document_id)');
        $this->addSql('ALTER TABLE document DROP INDEX UNIQ_D8698A76A76ED395, ADD INDEX user_id (user_id)');
        $this->addSql('DROP INDEX UNIQ_D8698A76E4B1925 ON document');
        $this->addSql('ALTER TABLE document ADD pinecone_id VARCHAR(255) DEFAULT NULL, DROP pinecode_id, CHANGE content content TEXT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT document_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX pinecone_id ON document (pinecone_id)');
    }
}
