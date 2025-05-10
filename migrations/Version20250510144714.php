<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510144714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id UUID NOT NULL, title TEXT NOT NULL, description TEXT NOT NULL, weight INT NOT NULL, sentiment INT NOT NULL, location_x DOUBLE PRECISION DEFAULT NULL, location_y DOUBLE PRECISION DEFAULT NULL, location_radius DOUBLE PRECISION DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event.started_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event_news (event_id UUID NOT NULL, news_id UUID NOT NULL, PRIMARY KEY(event_id, news_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_218D5FB71F7E88B ON event_news (event_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_218D5FBB5A459A0 ON event_news (news_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_news.event_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_news.news_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE news (id UUID NOT NULL, content TEXT NOT NULL, title TEXT DEFAULT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN news.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN news.published_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN news.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_news ADD CONSTRAINT FK_218D5FB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_news ADD CONSTRAINT FK_218D5FBB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_news DROP CONSTRAINT FK_218D5FB71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_news DROP CONSTRAINT FK_218D5FBB5A459A0
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_news
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE news
        SQL);
    }
}
