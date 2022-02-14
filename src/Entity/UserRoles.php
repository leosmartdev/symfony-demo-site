<?php

namespace App\Entity;

use App\Repository\UserRolesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRolesRepository::class)
 * @ORM\Table(name="usu_roles")
 */
class UserRoles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_role;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_usu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRole(): ?int
    {
        return $this->id_role;
    }

    public function setIdRole(int $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_usu;
    }

    public function setIdUser(int $id_usu): self
    {
        $this->id_usu = $id_usu;

        return $this;
    }
}
