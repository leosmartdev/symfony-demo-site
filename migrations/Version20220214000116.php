<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214000116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO roles (id_role, nombre_role, descripcion_role) VALUES (1,"ROLE_ADMIN","Admin"),(2,"ROLE_CONTROLLER","Partner"),(3,"ROLE_USER","User")');
        $this->addSql('INSERT INTO usuarios_usu (id,nombre_usu, apellidos_usu, tipo_usu, email_usu, pass_usu, activo_usu, borrado_usu, roles) VALUES (1,"admin","admin","","admin@demo.com","$2y$13$pl5ralJRCXGNbDiPMGInM.fOszwkuhRl4jvsAnrh9bibpwtTLMsDy",1,0,"[1]")');
        $this->addSql('INSERT INTO usu_roles (id_role, id_usu) VALUES (1,1)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
