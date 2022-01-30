<?php

namespace App\Entity;

use App\Entity\Education\Discipline;
use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Discipline::class, mappedBy="teacher")
     */
    private $disciplines;

    public function __construct()
    {
        parent::__construct();
        $this->disciplines = new ArrayCollection();
    }

    /**
     * @return Collection|Discipline[]
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): self
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines[] = $discipline;
            $discipline->setTeacher($this);
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): self
    {
        if ($this->disciplines->removeElement($discipline)) {
            // set the owning side to null (unless already changed)
            if ($discipline->getTeacher() === $this) {
                $discipline->setTeacher(null);
            }
        }

        return $this;
    }
}
