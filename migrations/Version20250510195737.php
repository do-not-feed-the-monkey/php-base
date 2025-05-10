<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250510195737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE event_sentiment (id UUID NOT NULL, agitation_id UUID NOT NULL, neutral_id UUID NOT NULL, positive_id UUID NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_C5E7C3164376AED1 ON event_sentiment (agitation_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_C5E7C316CC8F553C ON event_sentiment (neutral_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_C5E7C31667755CB4 ON event_sentiment (positive_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_sentiment.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_sentiment.agitation_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_sentiment.neutral_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event_sentiment.positive_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sentiment_details (id UUID NOT NULL, strength INT NOT NULL, detected_emotions JSON NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN sentiment_details.id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment ADD CONSTRAINT FK_C5E7C3164376AED1 FOREIGN KEY (agitation_id) REFERENCES sentiment_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment ADD CONSTRAINT FK_C5E7C316CC8F553C FOREIGN KEY (neutral_id) REFERENCES sentiment_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment ADD CONSTRAINT FK_C5E7C31667755CB4 FOREIGN KEY (positive_id) REFERENCES sentiment_details (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD sentiment_id UUID DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP sentiment
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN event.sentiment_id IS '(DC2Type:uuid)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74D40E392 FOREIGN KEY (sentiment_id) REFERENCES event_sentiment (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_3BAE0AA74D40E392 ON event (sentiment_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA74D40E392
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment DROP CONSTRAINT FK_C5E7C3164376AED1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment DROP CONSTRAINT FK_C5E7C316CC8F553C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_sentiment DROP CONSTRAINT FK_C5E7C31667755CB4
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_sentiment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sentiment_details
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_3BAE0AA74D40E392
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD sentiment INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP sentiment_id
        SQL);
    }
}
