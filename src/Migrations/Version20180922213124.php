<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180922213124 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE brewers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FA8C7C595E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beers (id INT AUTO_INCREMENT NOT NULL, brewer INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price_per_litre INT NOT NULL, country VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_B331E6388C2B4A4B (brewer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beers ADD CONSTRAINT FK_B331E6388C2B4A4B FOREIGN KEY (brewer) REFERENCES brewers (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beers DROP FOREIGN KEY FK_B331E6388C2B4A4B');
        $this->addSql('DROP TABLE brewers');
        $this->addSql('DROP TABLE beers');
    }
}
