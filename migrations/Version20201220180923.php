<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201220180923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation_linked (
                id BIGINT(20) UNSIGNED AUTO_INCREMENT NOT NULL,
                formation_id BIGINT(20) UNSIGNED NOT NULL,
                linked_formation_id BIGINT(20) UNSIGNED NOT NULL,
                FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
                FOREIGN KEY (linked_formation_id) REFERENCES formations(id) ON DELETE CASCADE,
                UNIQUE KEY formation_linked_formation_formation(formation_id, linked_formation_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE formation_linked');
    }
}
