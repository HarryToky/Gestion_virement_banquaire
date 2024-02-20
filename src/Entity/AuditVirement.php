<?php

namespace App\Entity;

use App\Repository\AuditVirementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditVirementRepository::class)]
class AuditVirement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeAction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOperation = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroVirement = null;

    #[ORM\Column]
    private ?int $numeroCompte = null;

    #[ORM\Column(length: 255)]
    private ?string $nomClient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateVirement = null;

    #[ORM\Column]
    private ?float $montantAncien = null;

    #[ORM\Column]
    private ?float $montantNouveau = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAction(): ?string
    {
        return $this->typeAction;
    }

    public function setTypeAction(string $typeAction): static
    {
        $this->typeAction = $typeAction;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(\DateTimeInterface $dateOperation): static
    {
        $this->dateOperation = $dateOperation;

        return $this;
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

    public function getNumeroCompte(): ?int
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(int $numeroCompte): static
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

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

    public function getMontantAncien(): ?float
    {
        return $this->montantAncien;
    }

    public function setMontantAncien(float $montantAncien): static
    {
        $this->montantAncien = $montantAncien;

        return $this;
    }

    public function getMontantNouveau(): ?float
    {
        return $this->montantNouveau;
    }

    public function setMontantNouveau(float $montantNouveau): static
    {
        $this->montantNouveau = $montantNouveau;

        return $this;
    }

    public function getUtilisateur(): ?string
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(string $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
