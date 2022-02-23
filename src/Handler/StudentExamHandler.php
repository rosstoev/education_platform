<?php
declare(strict_types=1);

namespace App\Handler;


use App\Entity\Exam\StudentExam;
use App\Entity\Exam\TeacherExam;
use Doctrine\ORM\EntityManagerInterface;

class StudentExamHandler
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|\App\Entity\Student $students
     * @param \App\Entity\Exam\TeacherExam $teacherExam
     */
    public function create($students, TeacherExam $teacherExam)
    {
        foreach ($students as $student) {
            $studentExam = new StudentExam();
            $studentExam->setAuthor($student);
            $studentExam->setTeacherExam($teacherExam);
            $this->em->persist($studentExam);
        }

    }
}