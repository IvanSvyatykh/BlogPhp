<?php


declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518173000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            INSERT INTO post_statuses (id, status) VALUES
                               (1,'PUBLISHED'),
                               (2,'PENDING'),
                                           (3,'REJECTED');
        SQL
        );
        $this->addSql(<<<'SQL'
                    INSERT INTO post_types (id,type) VALUES
                                              (1,'Коммерческие игры'),
                                              (2,'Фанатские игры'),
                                              (3,'Другое');
        SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DELETE FROM posts WHERE status_id IN (1, 2, 3);
        SQL
        );
        $this->addSql(<<<'SQL'
            DELETE FROM post_statuses WHERE id IN (1, 2, 3);
        SQL
        );
        $this->addSql(<<<'SQL'
            DELETE FROM posts WHERE post_type_id IN (1, 2, 3);
        SQL
        );
        $this->addSql(<<<'SQL'
            DELETE FROM post_types WHERE id IN (1, 2, 3);
        SQL
        );
    }
}