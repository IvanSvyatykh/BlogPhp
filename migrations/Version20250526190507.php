<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526190507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_781b2f19a76ed395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE likes ADD CONSTRAINT FK_781B2F194B89032C FOREIGN KEY (post_id) REFERENCES public.posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_781B2F194B89032C ON likes (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_781B2F19A76ED395 ON likes (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE posts ALTER status_id SET NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE public.posts ALTER status_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE public.likes DROP CONSTRAINT FK_781B2F194B89032C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX public.IDX_781B2F194B89032C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX public.IDX_781B2F19A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_781b2f19a76ed395 ON public.likes (user_id)
        SQL);
    }
}

