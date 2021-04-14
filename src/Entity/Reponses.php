<?php

namespace App\Entity;

use App\Repository\ReponsesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponsesRepository::class)
 */
class Reponses
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_choise;

    /**
     * @ORM\ManyToOne(targetEntity=Questions::class, inversedBy="reponses")
     */
    private $question_id;

    /**
     * @ORM\OneToMany(targetEntity=Resultats::class, mappedBy="reponse_id")
     */
    private $resultats;

    public function __construct()
    {
        $this->resultats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleChoise(): ?string
    {
        return $this->libelle_choise;
    }

    public function setLibelleChoise(string $libelle_choise): self
    {
        $this->libelle_choise = $libelle_choise;

        return $this;
    }

    public function getQuestionId(): ?Questions
    {
        return $this->question_id;
    }

    public function setQuestionId(?Questions $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }

    /**
     * @return Collection|Resultats[]
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultats $resultat): self
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats[] = $resultat;
            $resultat->setReponseId($this);
        }

        return $this;
    }

    public function removeResultat(Resultats $resultat): self
    {
        if ($this->resultats->removeElement($resultat)) {
            // set the owning side to null (unless already changed)
            if ($resultat->getReponseId() === $this) {
                $resultat->setReponseId(null);
            }
        }

        return $this;
    }
}
