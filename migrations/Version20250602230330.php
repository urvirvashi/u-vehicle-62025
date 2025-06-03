<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602230330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE maker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(125) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, maker_id INT DEFAULT NULL, name VARCHAR(125) NOT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_1B80E48668DA5EC3 (maker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vehicle_technical_detail (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, top_speed DOUBLE PRECISION DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, engine_type VARCHAR(255) DEFAULT NULL, fuel_type VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_6CFF15D545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48668DA5EC3 FOREIGN KEY (maker_id) REFERENCES maker (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle_technical_detail ADD CONSTRAINT FK_6CFF15D545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48668DA5EC3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicle_technical_detail DROP FOREIGN KEY FK_6CFF15D545317D1
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE maker
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vehicle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vehicle_technical_detail
        SQL);
    }
}
