<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomStagiaire = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomStagiaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(length: 255)]
    private ?string $piece_identite = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: 'Your value must contain exactly 8 numbers'
     )]
    private ?string $num_piece_identite = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $gouvernorat = null;

    #[ORM\Column]
    #[Assert\Regex(
            pattern: '/^\d{8}$/',
            message: 'Your value must contain exactly 8 numbers'
         )]
 
    private ?int $mobile = null;

    #[ORM\Column(length: 255)]
    private ?string $diplome = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 255)]
    private ?string $institut = null;

    #[ORM\Column]
    private ?int $indemnite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\ManyToOne(inversedBy: 'stagiaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Encadrant $encadrant = null;

    #[ORM\ManyToOne(inversedBy: 'stagiaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: Abscence::class)]
    private Collection $abscences;

    public function __construct()
    {
        $this->abscences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStagiaire(): ?string
    {
        return $this->nomStagiaire;
    }

    public function setNomStagiaire(string $nomStagiaire): static
    {
        $this->nomStagiaire = $nomStagiaire;

        return $this;
    }

    public function getPrenomStagiaire(): ?string
    {
        return $this->prenomStagiaire;
    }

    public function setPrenomStagiaire(string $prenomStagiaire): static
    {
        $this->prenomStagiaire = $prenomStagiaire;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getPieceIdentite(): ?string
    {
        return $this->piece_identite;
    }

    public function setPieceIdentite(string $piece_identite): static
    {
        $this->piece_identite = $piece_identite;

        return $this;
    }

    public function getNumPieceIdentite(): ?string
    {
        return $this->num_piece_identite;
    }

    public function setNumPieceIdentite(string $num_piece_identite): static
    {
        $this->num_piece_identite = $num_piece_identite;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getGouvernorat(): ?string
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(string $gouvernorat): static
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    public function getMobile(): ?int
    {
        return $this->mobile;
    }

    public function setMobile(int $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getInstitut(): ?string
    {
        return $this->institut;
    }

    public function setInstitut(string $institut): static
    {
        $this->institut = $institut;

        return $this;
    }

    public function getIndemnite(): ?int
    {
        return $this->indemnite;
    }

    public function setIndemnite(int $indemnite): static
    {
        $this->indemnite = $indemnite;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getEncadrant(): ?Encadrant
    {
        return $this->encadrant;
    }

    public function setEncadrant(?Encadrant $encadrant): static
    {
        $this->encadrant = $encadrant;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * @return Collection<int, Abscence>
     */
    public function getAbscences(): Collection
    {
        return $this->abscences;
    }

    public function addAbscence(Abscence $abscence): static
    {
        if (!$this->abscences->contains($abscence)) {
            $this->abscences->add($abscence);
            $abscence->setStagiaire($this);
        }

        return $this;
    }

    public function removeAbscence(Abscence $abscence): static
    {
        if ($this->abscences->removeElement($abscence)) {
            // set the owning side to null (unless already changed)
            if ($abscence->getStagiaire() === $this) {
                $abscence->setStagiaire(null);
            }
        }

        return $this;
    }
}
