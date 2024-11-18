<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118090244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon (id INT NOT NULL, name VARCHAR(255) NOT NULL, base_experience INT NOT NULL, height INT NOT NULL, is_default BOOLEAN NOT NULL, "order" INT NOT NULL, weight INT NOT NULL, abilities JSON NOT NULL, forms JSON NOT NULL, game_indices JSON NOT NULL, held_items JSON NOT NULL, location_area_encounters VARCHAR(255) NOT NULL, moves JSON NOT NULL, past_types JSON NOT NULL, stats JSON NOT NULL, types JSON NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX pokemon_name_idx ON pokemon (name)');
        $this->addSql('COMMENT ON COLUMN pokemon.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE pokemon');
    }
}
