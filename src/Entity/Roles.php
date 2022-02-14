<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RolesRepository::class)
 */
class Roles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre_role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_role;

    public function getId(): ?int
    {
        return $this->id_role;
    }

    public function getNombreRole(): ?string
    {
        return $this->nombre_role;
    }

    public function setNombreRole(string $nombre_role): self
    {
        $this->nombre_role = $nombre_role;

        return $this;
    }

    public function getDescripcionRole(): ?string
    {
        return $this->descripcion_role;
    }

    public function setDescripcionRole(string $descripcion_role): self
    {
        $this->descripcion_role = $descripcion_role;

        return $this;
    }
}
