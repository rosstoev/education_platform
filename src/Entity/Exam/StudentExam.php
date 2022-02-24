<?php

namespace App\Entity\Exam;

use App\Entity\Exam\Answer\Answer;
use App\Entity\Student;
use App\Repository\Exam\StudentExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentExamRepository::class)
 */
class StudentExam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=TeacherExam::class)
     */
    private $teacherExam;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="studentExams")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="studentExam")
     */
    private $answers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $evaluation;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getTeacherExam(): ?TeacherExam
    {
        return $this->teacherExam;
    }

    public function setTeacherExam(?TeacherExam $teacherExam): self
    {
        $this->teacherExam = $teacherExam;

        return $this;
    }

    public function getAuthor(): ?Student
    {
        return $this->author;
    }

    public function setAuthor(?Student $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setStudentExam($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getStudentExam() === $this) {
                $answer->setStudentExam(null);
            }
        }

        return $this;
    }

    public function getEvaluation(): ?int
    {
        return $this->evaluation;
    }

    public function setEvaluation(?int $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }
}
