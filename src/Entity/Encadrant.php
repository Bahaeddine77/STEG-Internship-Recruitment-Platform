<?php

namespace App\Entity;

use App\Repository\EncadrantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EncadrantRepository::class)]
class Encadrant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEncadrant = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomEncadrant = null;

 
    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:"Please enter your email adress")]
    #[Assert\Email(message:"Please enter a valid email adress")]
    private ?string $emailEncadrant = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: 'Your value must contain exactly 8 numbers'
     )]
    private ?int $mobileEncadrant = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: 'Your value must contain exactly 8 numbers'
     )]
    private ?int $cinEncadrant = null;

    #[ORM\OneToMany(mappedBy: 'encadrant', targetEntity: Stagiaire::class)]
    private Collection $stagiaire;

    #[ORM\OneToMany(mappedBy: 'encadrant', targetEntity: Stage::class, orphanRemoval: true)]
    private Collection $stages;

    public function __construct()
    {
        $this->stagiaire = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEncadrant(): ?string
    {
        return $this->nomEncadrant;
    }

    public function setNomEncadrant(string $nomEncadrant): static
    {
        $this->nomEncadrant = $nomEncadrant;

        return $this;
    }

    public function getPrenomEncadrant(): ?string
    {
        return $this->prenomEncadrant;
    }

    public function setPrenomEncadrant(string $prenomEncadrant): static
    {
        $this->prenomEncadrant = $prenomEncadrant;

        return $this;
    }

    public function getEmailEncadrant(): ?string
    {
        return $this->emailEncadrant;
    }

    public function setEmailEncadrant(string $emailEncadrant): static
    {
        $this->emailEncadrant = $emailEncadrant;

        return $this;
    }

    public function getMobileEncadrant(): ?int
    {
        return $this->mobileEncadrant;
    }

    public function setMobileEncadrant(int $mobileEncadrant): static
    {
        $this->mobileEncadrant = $mobileEncadrant;

        return $this;
    }

    public function getCinEncadrant(): ?int
    {
        return $this->cinEncadrant;
    }

    public function setCinEncadrant(int $cinEncadrant): static
    {
        $this->cinEncadrant = $cinEncadrant;

        return $this;
    }

    /**
     * @return Collection<int, stagiaire>
     */
    public function getStagiaire(): Collection
    {
        return $this->stagiaire;
    }

    public function addStagiaire(Stagiaire $stagiaire): static
    {
        if (!$this->stagiaire->contains($stagiaire)) {
            $this->stagiaire->add($stagiaire);
            $stagiaire->setEncadrant($this);
        }

        return $this;
    }

    public function removeStagiaire(stagiaire $stagiaire): static
    {
        if ($this->stagiaire->removeElement($stagiaire)) {
            // set the owning side to null (unless already changed)
            if ($stagiaire->getEncadrant() === $this) {
                $stagiaire->setEncadrant(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->getPrenomEncadrant() . ' ' . $this->getNomEncadrant(); // Replace with the appropriate property to use as a string representation.
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): static
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setEncadrant($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEncadrant() === $this) {
                $stage->setEncadrant(null);
            }
        }

        return $this;
    }
}
