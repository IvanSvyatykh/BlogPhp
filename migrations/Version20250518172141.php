<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518172141 extends AbstractMigration
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
            CREATE SEQUENCE public.comments_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.likes_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.post_statuses_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.post_tags_Id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.post_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.posts_Id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.tags_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE SEQUENCE public.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.comments (id INT NOT NULL, content VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, post_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_9D724D434B89032C ON public.comments (post_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_9D724D43A76ED395 ON public.comments (user_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.likes (id INT NOT NULL, post_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_781B2F19A76ED395 ON public.likes (user_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX unique_likes ON public.likes (user_id, post_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.post_statuses (id INT NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_C85E201C7B00651C ON public.post_statuses (status)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.post_tags (Id INT NOT NULL, post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(Id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX unique_tag_for_post ON public.post_tags (tag_id, post_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.post_types (id INT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.posts (Id INT NOT NULL, title VARCHAR(50) NOT NULL, content VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, isPublished BOOLEAN NOT NULL, user_id INT DEFAULT NULL, status_id INT DEFAULT NULL, post_type_id INT DEFAULT NULL, PRIMARY KEY(Id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B98CDB9EA76ED395 ON public.posts (user_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B98CDB9E6BF700BD ON public.posts (status_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B98CDB9EF8A43BA0 ON public.posts (post_type_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public.tags (id INT NOT NULL, tag VARCHAR(50) NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D0531F88389B783 ON public.tags (tag)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE public."user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_admin BOOLEAN NOT NULL, is_moderator BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_327C5DE7AA08CB10 ON public."user" (login)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.comments ADD CONSTRAINT FK_9D724D434B89032C FOREIGN KEY (post_id) REFERENCES public.posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.comments ADD CONSTRAINT FK_9D724D43A76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.likes ADD CONSTRAINT FK_781B2F19A76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts ADD CONSTRAINT FK_B98CDB9EA76ED395 FOREIGN KEY (user_id) REFERENCES public."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts ADD CONSTRAINT FK_B98CDB9E6BF700BD FOREIGN KEY (status_id) REFERENCES public.post_statuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts ADD CONSTRAINT FK_B98CDB9EF8A43BA0 FOREIGN KEY (post_type_id) REFERENCES public.post_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.comments_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.likes_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.post_statuses_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.post_tags_Id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.post_types_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.posts_Id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.tags_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP SEQUENCE public.user_id_seq CASCADE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.comments DROP CONSTRAINT FK_9D724D434B89032C
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.comments DROP CONSTRAINT FK_9D724D43A76ED395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.likes DROP CONSTRAINT FK_781B2F19A76ED395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts DROP CONSTRAINT FK_B98CDB9EA76ED395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts DROP CONSTRAINT FK_B98CDB9E6BF700BD
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE public.posts DROP CONSTRAINT FK_B98CDB9EF8A43BA0
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.comments
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.likes
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.post_statuses
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.post_tags
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.post_types
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.posts
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public.tags
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE public."user"
        SQL
        );
    }
}
