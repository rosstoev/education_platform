<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Education\Group;
use App\Entity\Exam\StudentExam;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student extends User
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courseNumber;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, mappedBy="students")
     */
    private $myGroups;

    /**
     * @ORM\OneToMany(targetEntity=StudentExam::class, mappedBy="author")
     */
    private $studentExams;

    public function __construct()
    {
        parent::__construct();
        $this->myGroups = new ArrayCollection();
        $this->studentExams = new ArrayCollection();
    }


    public function getCourseNumber(): ?string
    {
        return $this->courseNumber;
    }

    public function setCourseNumber(string $courseNumber): self
    {
        $this->courseNumber = $courseNumber;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getMyGroups(): Collection
    {
        return $this->myGroups;
    }

    public function addMyGroup(Group $myGroup): self
    {
        if (!$this->myGroups->contains($myGroup)) {
            $this->myGroups[] = $myGroup;
            $myGroup->addStudent($this);
        }

        return $this;
    }

    public function removeMyGroup(Group $myGroup): self
    {
        if ($this->myGroups->removeElement($myGroup)) {
            $myGroup->removeStudent($this);
        }

        return $this;
    }

    /**
     * @return Collection|StudentExam[]
     */
    public function getStudentExams(): Collection
    {
        return $this->studentExams;
    }

    public function addStudentExam(StudentExam $studentExam): self
    {
        if (!$this->studentExams->contains($studentExam)) {
            $this->studentExams[] = $studentExam;
            $studentExam->setAuthor($this);
        }

        return $this;
    }

    public function removeStudentExam(StudentExam $studentExam): self
    {
        if ($this->studentExams->removeElement($studentExam)) {
            // set the owning side to null (unless already changed)
            if ($studentExam->getAuthor() === $this) {
                $studentExam->setAuthor(null);
            }
        }

        return $this;
    }
}
