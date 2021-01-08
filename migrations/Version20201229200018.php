<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201229200018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE encarts (
                id BIGINT(20) UNSIGNED AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                image VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                image_subtitle VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                button_text VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                button_link VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                domain_id BIGINT(20) UNSIGNED NULL DEFAULT NULL,
                FOREIGN KEY (domain_id) REFERENCES domains(id) ON DELETE SET NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE encarts');
    }
}
