<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527054848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_b98cdb9ef8a43ba0
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_b98cdb9e6bf700bd
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B98CDB9E6BF700BD ON posts (status_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B98CDB9EF8A43BA0 ON posts (post_type_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX public.IDX_B98CDB9E6BF700BD
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX public.IDX_B98CDB9EF8A43BA0
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_b98cdb9ef8a43ba0 ON public.posts (post_type_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_b98cdb9e6bf700bd ON public.posts (status_id)
        SQL);
    }
}
