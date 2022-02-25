<?php
declare(strict_types=1);

namespace App\DTO\Exam;


use App\Entity\Exam\Answer\Answer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class EstimationDTO
{
    private ?int $estimate = null;

    /**
     * @var Collection|Answer[]
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getEstimate(): ?int
    {
        return $this->estimate;
    }

    /**
     * @param int|null $estimate
     */
    public function setEstimate(?int $estimate): void
    {
        $this->estimate = $estimate;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        $this->answers->removeElement($answer);
        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): self
    {
        $this->answers = $answers;
        return $this;
    }



}