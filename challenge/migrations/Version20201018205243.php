<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
final class Version20201018205243 extends AbstractMigration
{
    /**
     * @inheritDoc
     */
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function up(Schema $schema) : void
    {
        $createTableSentence = <<<SQL
CREATE TABLE IF NOT EXISTS offer (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(256) NOT NULL,
    image_url VARCHAR(256) NOT NULL,
    cash_back DECIMAL(10,2) NOT NULL
)
SQL;

        $this->addSql($createTableSentence);
    }

    /**
     * @inheritDoc
     */
    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS offer');
    }
}
