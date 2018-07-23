<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonRepository")
 */
class Pokemon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type2;

    /**
     * @ORM\Column(type="integer")
     */
    private $pv;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     */
    private $defense;

    /**
     * @ORM\Column(type="integer")
     */
    private $speed;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="pokemons")
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $numPokedex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageType1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageType2;

    public function __toString(): string
    {
        return (string)$this->getId();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getNumPokedex(): ?int
    {
        return $this->numPokedex;
    }

    public function setNumPokedex(int $numPokedex): self
    {
        $this->numPokedex = $numPokedex;

        return $this;
    }

    public function getImageType1(): ?string
    {
        return $this->imageType1;
    }

    public function setImageType1(string $imageType1): self
    {
        $this->imageType1 = $imageType1;

        return $this;
    }

    public function getImageType2(): ?string
    {
        return $this->imageType2;
    }

    public function setImageType2(?string $imageType2): self
    {
        $this->imageType2 = $imageType2;

        return $this;
    }
}
