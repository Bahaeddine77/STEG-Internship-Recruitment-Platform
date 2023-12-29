<?php

namespace App\Entity;

use App\Repository\AbscenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbscenceRepository::class)]
class Abscence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_D = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_F = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $justification = null;

    #[ORM\ManyToOne(inversedBy: 'abscences')]
    private ?stagiaire $stagiaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->date_D;
    }

    public function setDateD(\DateTimeInterface $date_D): static
    {
        $this->date_D = $date_D;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->date_F;
    }

    public function setDateF(\DateTimeInterface $date_F): static
    {
        $this->date_F = $date_F;

        return $this;
    }

    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(string $justification): static
    {
        $this->justification = $justification;

        return $this;
    }

    public function getStagiaire(): ?stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }
}
