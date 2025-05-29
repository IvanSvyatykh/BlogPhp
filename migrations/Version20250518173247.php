<?php


declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518173247 extends AbstractMigration
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
            INSERT INTO "user" (id,name, login, password, is_admin, is_moderator, created_at, is_banned) VALUES 
                                                                                                (1,'admin','admin','$2y$10$U4JKXCHpSo5vdSbT83ET5eDn3ZYF8JCuCKZMeYxXSEE/DMwTXtKWq',TRUE,False,CURRENT_TIMESTAMP,FALSE),
                                                                                                (2,'moderator','moderator','$2y$10$U4JKXCHpSo5vdSbT83ET5eDn3ZYF8JCuCKZMeYxXSEE/DMwTXtKWq',FALSE,TRUE,CURRENT_TIMESTAMP,FALSE),
                                                                                                (3,'moderator2','moderator2','$2y$10$U4JKXCHpSo5vdSbT83ET5eDn3ZYF8JCuCKZMeYxXSEE/DMwTXtKWq',FALSE,TRUE,CURRENT_TIMESTAMP,FALSE);
        SQL
        );
        $this->addSql(
            <<<'SQL'
             SELECT setval('user_id_seq', (SELECT MAX(id) FROM "user" ));
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
            DELETE FROM posts WHERE user_id IN (1, 2, 3);
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DELETE FROM "user" WHERE id IN (1, 2, 3);
        SQL
        );
    }
}