<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/[A-Z]{2}[0-9]{3,4}[A-Z]{2}/", message="L'immatriculation est incorrect")
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice({3,5}, message="3 ou 5 portes possible")
     */
    private $nbPortes;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/(19\d{2})|(200\d)|(201[0-3])/", message="date incorrect")
     */
    private $annee;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="voitures")
     */
    private $modele;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getNbPortes(): ?int
    {
        return $this->nbPortes;
    }

    public function setNbPortes(int $nbPortes): self
    {
        $this->nbPortes = $nbPortes;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
}
