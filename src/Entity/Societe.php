<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocieteRepository::class)
 */
class Societe
{
   
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Adresse::class, mappedBy="nom", orphanRemoval=true)
     */
    private $adresses;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville_imm;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_imm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $capital;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|adresse[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
            $adress->setNom($this);
        }

        return $this;
    }

    public function removeAdress(adresse $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getNom() === $this) {
                $adress->setNom(null);
            }
        }

        return $this;
    }

    public function getNumSiren(): ?int
    {
        return $this->num_siren;
    }

    public function setNumSiren(int $num_siren): self
    {
        $this->num_siren = $num_siren;

        return $this;
    }

    public function getVilleImm(): ?string
    {
        return $this->ville_imm;
    }


    public function setVilleImm(string $ville_imm): self
    {
        $this->ville_imm = $ville_imm;

        return $this;
    }

    public function getDateImm(): ?\DateTimeInterface
    {
        return $this->date_imm;
    }

    public function setDateImm(\DateTimeInterface $date_imm): self
    {
        $this->date_imm = $date_imm;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function __toString()
    {
        return (string) $this->getNom();
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCapital(): ?int
    {
        return $this->capital;
    }

    public function setCapital(int $capital): self
    {
        $this->capital = $capital;

        return $this;
    }
}
