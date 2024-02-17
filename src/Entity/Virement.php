<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VirementRepository::class)]
class Virement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroVirement = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $numeroCompte = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateVirement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroVirement(): ?string
    {
        return $this->numeroVirement;
    }

    public function setNumeroVirement(string $numeroVirement): static
    {
        $this->numeroVirement = $numeroVirement;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): static
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateVirement(): ?\DateTimeInterface
    {
        return $this->dateVirement;
    }

    public function setDateVirement(\DateTimeInterface $dateVirement): static
    {
        $this->dateVirement = $dateVirement;

        return $this;
    }
}
