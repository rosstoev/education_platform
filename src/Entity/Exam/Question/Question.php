<?php

namespace App\Entity\Exam\Question;

use App\Entity\Exam\Test;
use App\Repository\Exam\Question\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    public const TYPE_OPEN = 'open';
    public const TYPE_CHOICES = 'choices';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('open', 'choices')")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Choice::class, mappedBy="question", cascade={"persist", "remove"})
     */
    private $choices;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $textLength;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exam\Test", inversedBy="questions")
     */
    private $examTest;

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

    /**
     * @return Collection|Choice[]
     */
    public function getChoices(): Collection
    {
        return $this->choices;
    }

    public function addChoice(?Choice $choice): self
    {
        if (!$this->choices->contains($choice) && !empty($choice)) {
            $this->choices[] = $choice;
            $point = $this->getPoints() ?? 0;
            $this->setPoints($point + $choice->getPoints());
            $choice->setQuestion($this);
        }

        return $this;
    }

    public function removeChoice(Choice $choice): self
    {
        if ($this->choices->removeElement($choice)) {
            if ($choice->getQuestion() === $this) {
                $choice->setQuestion(null);
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

    public function getTextLength(): ?int
    {
        return $this->textLength;
    }

    public function setTextLength(?int $textLength): self
    {
        $this->textLength = $textLength;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getExamTest(): ?Test
    {
        return $this->examTest;
    }

    public function setExamTest(?Test $examTest): self
    {
        $this->examTest = $examTest;

        return $this;
    }

    public function setChoicePoints(): void
    {
        if ($this->getType() == Question::TYPE_CHOICES) {
            $points = 0;
            foreach ($this->getChoices() as $choice) {
                $points+= $choice->getPoints();
            }
            $this->setPoints($points);
        }
    }
}
