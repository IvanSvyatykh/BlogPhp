<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527052741 extends AbstractMigration
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
            DROP INDEX uniq_b98cdb9ea76ed395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_B98CDB9EA76ED395 ON posts (user_id)
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
            DROP INDEX public.IDX_B98CDB9EA76ED395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX uniq_b98cdb9ea76ed395 ON public.posts (user_id)
        SQL
        );
    }
}
