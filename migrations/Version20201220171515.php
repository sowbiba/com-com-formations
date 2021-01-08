<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201220171515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formations (
                id BIGINT(20) UNSIGNED AUTO_INCREMENT NOT NULL,
                formation_type_id BIGINT(20) UNSIGNED NOT NULL,
                title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                reference VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                level INT(11) UNSIGNED NOT NULL,
                duration VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                program LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                extras LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                pedagogic_means LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                UNIQUE INDEX UNIQ_1125743024020070 (slug),
                FOREIGN KEY (formation_type_id) REFERENCES formation_types(id) ON DELETE CASCADE,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formations');
    }
}
