<?php

namespace App\Entity\Exam;

use App\Entity\Education\Discipline;
use App\Entity\Teacher;
use App\Repository\Exam\TeacherExamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherExamRepository::class)
 */
class TeacherExam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Discipline::class)
     */
    private $discipline;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class)
     */
    private $test;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class)
     */
    private $creator;

    private ?int $executionTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): self
    {
        $this->discipline = $discipline;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getCreator(): ?Teacher
    {
        return $this->creator;
    }

    public function setCreator(?Teacher $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExecutionTime(): ?int
    {
        return $this->executionTime;
    }

    /**
     * @param int|null $executionTime
     */
    public function setExecutionTime(?int $executionTime): void
    {
        $this->executionTime = $executionTime;
    }

    public function createToken(): void
    {
        $bytes = openssl_random_pseudo_bytes(16);
        $token  = bin2hex($bytes);
        $this->token = $token;
    }

    public function createEndAt()
    {
        $minutes = $this->executionTime;
        $startedAt = new \DateTime($this->getStartedAt()->format('Y-m-d H:i:s'));
        $endAt = $startedAt->modify('+' . $minutes . ' minutes');
        $this->endAt = $endAt;
    }

    public function createExecutionMinutes()
    {
        $diff = $this->getStartedAt()->diff($this->getEndAt());
        $minutes = 0;
        if ($diff->i > 0){
            $minutes = $diff->i;
        }

        if ($diff->h > 0) {
            $minutes = $diff->h * 60;
        }
        $this->executionTime = $minutes;

    }
}
