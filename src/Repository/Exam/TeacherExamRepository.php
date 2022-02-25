<?php

namespace App\Repository\Exam;

use App\DTO\Exam\ExamFilterDTO;
use App\DTO\LectureFilterDTO;
use App\Entity\Exam\TeacherExam;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeacherExam|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherExam|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherExam[]    findAll()
 * @method TeacherExam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherExam::class);
    }

    public function findByTeacher(Teacher $teacher, ?ExamFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('teacher_exam')
            ->where('teacher_exam.creator = :teacher')
            ->setParameter('teacher', $teacher);
        if (!empty($filter)) {
            if (!empty($filter->getDiscipline())) {
                $qb->andWhere('teacher_exam.discipline = :discipline')
                    ->setParameter('discipline', $filter->getDiscipline());
            }

            if (!empty($filter->getFrom())) {
                $qb->andWhere('teacher_exam.startedAt >= :fromDate')
                    ->setParameter('fromDate', $filter->getFrom()->format('Y-m-d 00:00:00'));
            }

            if (!empty($filter->getTo())) {
                $qb->andWhere('teacher_exam.startedAt <= :toDate')
                    ->setParameter('toDate', $filter->getTo()->format('Y-m-d 23:59:59'));
            }
        }

        return $qb->getQuery()->getResult();
    }
}
