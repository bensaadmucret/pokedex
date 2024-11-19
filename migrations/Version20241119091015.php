<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119091015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon ALTER abilities DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER forms DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER game_indices DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER held_items DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER moves DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER past_types DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER stats DROP NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER types DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pokemon ALTER abilities SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER forms SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER game_indices SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER held_items SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER moves SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER past_types SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER stats SET NOT NULL');
        $this->addSql('ALTER TABLE pokemon ALTER types SET NOT NULL');
    }
}
