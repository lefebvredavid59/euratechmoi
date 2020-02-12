<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212230216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649450D2529');
        $this->addSql('DROP INDEX IDX_8D93D649450D2529 ON user');
        $this->addSql('ALTER TABLE user DROP enfant_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD enfant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649450D2529 FOREIGN KEY (enfant_id) REFERENCES enfant (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649450D2529 ON user (enfant_id)');
    }
}
