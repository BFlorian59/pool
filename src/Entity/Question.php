<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $champ_question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChampQuestion(): ?string
    {
        return $this->champ_question;
    }

    public function setChampQuestion(string $champ_question): self
    {
        $this->champ_question = $champ_question;

        return $this;
    }
}
