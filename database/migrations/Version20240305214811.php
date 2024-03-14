<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305214811 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Generate basic tables';
    }

    /**
     * @param Schema $schema
     *
     * @return void
     * @throws Exception
     */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $user = <<<SQL
create table users
(
    id         bigint auto_increment,
    email      varchar(128) not null,
    nickname   varchar(32)  null,
    created_at datetime     not null,
    updated_at datetime     null,
    password   varchar(255) null,
    constraint user_pk
        unique (id, email),
    constraint user_pk_2
        unique (id),
    constraint user_pk_3
        unique (email)
)
    collate = utf8mb4_general_ci;
SQL;

        $this->addSql($user);

        $tags = <<<SQL
create table tags
(
    id         bigint auto_increment,
    title      varchar(128) not null,
    author_id  bigint       not null,
    created_at datetime     not null,
    constraint tags_pk_2
        unique (id),
    constraint tags_users_id_fk
        foreign key (author_id) references users (id)
);

create unique index tags_title_uindex
    on tags (title);

alter table tags
    add constraint tags_pk
        unique (title);

SQL;

        $this->addSql($tags);

        $threads = <<<SQL
create table thread
(
    id          bigint auto_increment,
    author_id   bigint   not null,
    created_at  datetime not null,
    updated_at  datetime null,
    archived_at datetime null,
    constraint thread_pk
        unique (id),
    constraint thread_users_id_fk
        foreign key (author_id) references users (id)
);
SQL;

        $this->addSql($threads);

        $dislikes = <<<SQL
create table dislikes
(
    id        bigint auto_increment,
    user_id   bigint not null,
    thread_id bigint not null,
    constraint dislikes_pk
        unique (id),
    constraint dislikes_thread_id_fk
        foreign key (thread_id) references thread (id),
    constraint dislikes_users_id_fk
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_general_ci;
SQL;

        $this->addSql($dislikes);

        $comments = <<<SQL
create table comments
(
    id            bigint   null,
    content       text     not null,
    author_id     bigint   not null,
    thread_id     bigint   not null,
    related_to_id bigint   null,
    created_at    datetime not null,
    updated_at    datetime null,
    constraint comments_pk
        unique (id),
    constraint comments_thread_id_fk
        foreign key (thread_id) references thread (id),
    constraint comments_users_id_fk
        foreign key (author_id) references users (id)
)
    collate = utf8mb4_general_ci;
SQL;

        $this->addSql($comments);
    }

    /**
     * @param Schema $schema
     *
     * @return void
     * @throws Exception
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );
    }
}
