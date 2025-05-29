<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527064254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
            ALTER TABLE post_tags ADD CONSTRAINT FK_9245C60A4B89032C FOREIGN KEY (post_id) REFERENCES public.posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE post_tags ADD CONSTRAINT FK_9245C60ABAD26311 FOREIGN KEY (tag_id) REFERENCES public.tags (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_9245C60A4B89032C ON post_tags (post_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_9245C60ABAD26311 ON post_tags (tag_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE posts DROP ispublished
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.post_tags DROP CONSTRAINT FK_9245C60A4B89032C
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.post_tags DROP CONSTRAINT FK_9245C60ABAD26311
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP INDEX public.IDX_9245C60A4B89032C
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP INDEX public.IDX_9245C60ABAD26311
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts ADD ispublished BOOLEAN NOT NULL
        SQL
        );
    }
}
