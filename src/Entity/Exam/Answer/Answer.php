<?php

namespace App\Entity\Exam\Answer;

use App\Entity\Exam\Question\Choice;
use App\Entity\Exam\Question\Question;
use App\Entity\Exam\StudentExam;
use App\Repository\Exam\Answer\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=Choice::class, mappedBy="answer")
     */
    private $choices;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity=StudentExam::class, inversedBy="answers")
     */
    private $studentExam;

    private ?Choice $choice = null;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|Choice[]
     */
    public function getChoices(): Collection
    {
        return $this->choices;
    }

    public function addChoice(Choice $choice): self
    {
        if (!$this->choices->contains($choice)) {
            $this->choices[] = $choice;
            $choice->setAnswer($this);
        }

        return $this;
    }

    public function removeChoice(Choice $choice): self
    {
        if ($this->choices->removeElement($choice)) {
            // set the owning side to null (unless already changed)
            if ($choice->getAnswer() === $this) {
                $choice->setAnswer(null);
            }
        }

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

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

    public function getStudentExam(): ?StudentExam
    {
        return $this->studentExam;
    }

    public function setStudentExam(?StudentExam $studentExam): self
    {
        $this->studentExam = $studentExam;

        return $this;
    }

    /**
     * @return \App\Entity\Exam\Question\Choice|null
     */
    public function getChoice(): ?Choice
    {
        return $this->choice;
    }

    /**
     * @param \App\Entity\Exam\Question\Choice|null $choice
     */
    public function setChoice(?Choice $choice): void
    {
        $this->choice = $choice;
    }
}
