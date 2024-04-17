<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417215449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generate user and domain event';
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $sql = <<<SQL
create table users
(
    id              bigserial primary key,
    email           varchar(255) not null,
    first_name      varchar(255),
    second_name     varchar(255),
    password_digest varchar(255) not null,
    created_at      timestamp default current_timestamp,
    updated_at      timestamp default current_timestamp,
    constraint users_email_unique
        unique (email),
    constraint users_password_digest_unique
        unique (password_digest)
);

create index users_email_index
    on users (email);

create index users_first_name_second_name_index
    on users (first_name, second_name);

CREATE TABLE domain_events (
                               id UUID NOT NULL,
                               aggregate_id UUID NOT NULL,
                               name VARCHAR(255) NOT NULL,
                               body JSONB NOT NULL,
                               occurred_on TIMESTAMP NOT NULL,
                               PRIMARY KEY (id)
);

SQL;

        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $sql = <<<SQL
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS domain_events;
SQL;

        $this->addSql($sql);
    }
}
