<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102152716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE home (
                id BIGINT(20) UNSIGNED AUTO_INCREMENT NOT NULL,
                main_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                main_subtitle VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                main_button_text VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                main_button_link VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_one_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_one_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_two_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_two_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_three_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_three_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_four_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                box_four_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_subtitle VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_one_icon VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_one_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_one_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_two_icon VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_two_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_two_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_three_icon VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_three_title VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                middle_block_box_three_content LONGTEXT CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                formations_block_subtitle VARCHAR(255) CHARACTER SET utf8mb4 NULL DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE home');
    }
}
