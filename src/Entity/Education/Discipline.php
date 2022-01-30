<?php

namespace App\Entity\Education;

use App\Entity\Teacher;
use App\Repository\Education\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 */
class Discipline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="disciplines")
     */
    private $teacher;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class)
     */
    private $studentGroups;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Lecture::class, mappedBy="discipline")
     */
    private $lectures;

    public function __construct()
    {
        $this->studentGroups = new ArrayCollection();
        $this->lectures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getStudentGroups(): Collection
    {
        return $this->studentGroups;
    }

    public function addStudentGroup(Group $studentGroup): self
    {
        if (!$this->studentGroups->contains($studentGroup)) {
            $this->studentGroups[] = $studentGroup;
        }

        return $this;
    }

    public function removeStudentGroup(Group $studentGroup): self
    {
        $this->studentGroups->removeElement($studentGroup);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Lecture[]
     */
    public function getLectures(): Collection
    {
        return $this->lectures;
    }

    public function addLecture(Lecture $lecture): self
    {
        if (!$this->lectures->contains($lecture)) {
            $this->lectures[] = $lecture;
            $lecture->setDiscipline($this);
        }

        return $this;
    }

    public function removeLecture(Lecture $lecture): self
    {
        if ($this->lectures->removeElement($lecture)) {
            // set the owning side to null (unless already changed)
            if ($lecture->getDiscipline() === $this) {
                $lecture->setDiscipline(null);
            }
        }

        return $this;
    }
}
