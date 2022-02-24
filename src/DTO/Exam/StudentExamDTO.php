<?php
declare(strict_types=1);

namespace App\DTO\Exam;


use App\Entity\Student;
use Doctrine\Common\Collections\ArrayCollection;

class StudentExamDTO
{
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Student
     */
    private ArrayCollection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    /**
     * @return \App\Entity\Student|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getStudents()
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        $this->students->removeElement($student);

        return $this;
    }


}