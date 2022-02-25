<?php
declare(strict_types=1);

namespace App\Handler;


use App\DTO\Exam\EstimationDTO;
use App\Entity\Exam\Question\Question;
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

    public function temporaryEstimation(EstimationDTO $estimationDTO, int $maxPoints): int
    {
        $studentPoints = 0;
        foreach ($estimationDTO->getAnswers() as $answer) {
            if ($answer->getType() == Question::TYPE_OPEN) {
                $studentPoints+= $answer->getPoints() != null ? $answer->getPoints() : 0;
            } else {
                foreach ($answer->getChoices() as $choice) {
                    $studentPoints+= $choice->getPoints();
                }
            }
        }

        $estimate = intval(round(($studentPoints / $maxPoints) * 6));

        if ($estimate < 2) {
            $estimate = 2;
        }

        return $estimate;
    }

    public function validateForTaking(?StudentExam $studentExam): void
    {
        $now = new \DateTime();
        if (empty($studentExam)) {
            throw new \Exception('Този изпит не съществува.');
        }

        $startedDate = $studentExam->getTeacherExam()->getStartedAt()->modify('- 2 min');
        if ($now < $startedDate) {
            throw new \Exception('Изпитът не е достъпен.');
        }
    }

    public function validateForCheck(?StudentExam $studentExam): void
    {
        if (empty($studentExam)) {
            throw new \Exception('Изпитът не съществува.');
        }
        if ($studentExam->getFinishedAt() === null) {
            throw new \Exception('Изпитът не проведен.');
        }
        if ($studentExam->getEvaluation() !== null) {
            throw new \Exception('Изпитът вече е оценен.');
        }
    }
}