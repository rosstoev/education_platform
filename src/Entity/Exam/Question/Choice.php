<?php

namespace App\Entity\Exam\Question;

use App\Entity\Exam\Answer\Answer;
use App\Repository\Exam\Question\ChoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="question_choices")
 * @ORM\Entity(repositoryClass=ChoiceRepository::class)
 */
class Choice
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
    private $possibility;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCorrect;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="choices")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Answer::class, inversedBy="choices")
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPossibility(): ?string
    {
        return $this->possibility;
    }

    public function setPossibility(string $possibility): self
    {
        $this->possibility = $possibility;

        return $this;
    }

    public function getIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
