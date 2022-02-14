<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="usuarios_usu")
 *
 * Defines the properties of the User entity to represent the application users.
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    #[
        Assert\NotBlank,
        Assert\Length(min: 2, max: 50)
    ]
    private ?string $nombre_usu = '';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos_usu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo_usu;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    #[Assert\Email]
    private ?string $email_usu = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $pass_usu = null;

    /**
     * @ORM\Column(type="integer")
     */
    private $activo_usu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaC_usu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usuC_usu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaM_usu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usuM_usu;

    /**
     * @ORM\Column(type="integer")
     */
    private $borrado_usu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaUltAcceso_usu;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pais_usu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->nombre_usu;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function setUsername(string $username): void
    {
        $this->nombre_usu = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email_usu;
    }

    public function setEmail(string $email): void
    {
        $this->email_usu = $email;
    }

    public function getPassword(): ?string
    {
        return $this->pass_usu;
    }

    public function setPassword(string $password): void
    {
        $this->pass_usu = $password;
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        // if (empty($roles)) {
        //     $roles[] = 'ROLE_USER';
        // }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // We're using bcrypt in security.yaml to encode the password, so
        // the salt value is built-in and you don't have to generate one
        // See https://en.wikipedia.org/wiki/Bcrypt

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    public function __serialize(): array
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return [$this->id, $this->nombre_usu, $this->pass_usu];
    }

    public function __unserialize(array $data): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->nombre_usu, $this->pass_usu] = $data;
    }

    public function getSurname(): ?string
    {
        return $this->apellidos_usu;
    }

    public function setSurname(string $surname): self
    {
        $this->apellidos_usu = $surname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->pais_usu;
    }

    public function setCountry(string $country): self
    {
        $this->pais_usu = $country;

        return $this;
    }

    public function getTipoUsu(): ?string
    {
        return $this->tipo_usu;
    }

    public function setTipoUsu(string $tipo_usu): self
    {
        $this->tipo_usu = $tipo_usu;

        return $this;
    }

    public function getUsuCUsu(): ?int
    {
        return $this->usuC_usu;
    }

    public function setUsuCUsu(?int $usuC_usu): self
    {
        $this->usuC_usu = $usuC_usu;

        return $this;
    }

    public function getFechaCUsu(): ?\DateTimeInterface
    {
        return $this->fechaC_usu;
    }

    public function setFechaCUsu(?\DateTimeInterface $fechaC_usu): self
    {
        $this->fechaC_usu = $fechaC_usu;

        return $this;
    }

    public function getUsuMUsu(): ?int
    {
        return $this->usuM_usu;
    }

    public function setUsuMUsu(?int $usuM_usu): self
    {
        $this->usuM_usu = $usuM_usu;

        return $this;
    }

    public function getFechaMUsu(): ?\DateTimeInterface
    {
        return $this->fechaM_usu;
    }

    public function setFechaMUsu(?\DateTimeInterface $fechaM_usu): self
    {
        $this->fechaM_usu = $fechaM_usu;

        return $this;
    }

    public function getBorradoUsu(): ?int
    {
        return $this->borrado_usu;
    }

    public function setBorradoUsu(int $borrado_usu): self
    {
        $this->borrado_usu = $borrado_usu;

        return $this;
    }

    public function getFechaUltAccesoUsu(): ?\DateTimeInterface
    {
        return $this->fechaUltAcceso_usu;
    }

    public function setFechaUltAccesoUsu(?\DateTimeInterface $fechaUltAcceso_usu): self
    {
        $this->fechaUltAcceso_usu = $fechaUltAcceso_usu;

        return $this;
    }

    public function getActivoUsu(): ?int
    {
        return $this->activo_usu;
    }

    public function setActivoUsu(int $activo_usu): self
    {
        $this->activo_usu = $activo_usu;

        return $this;
    }
}
