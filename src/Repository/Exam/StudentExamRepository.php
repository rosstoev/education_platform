<?php

namespace App\Repository\Exam;

use App\DTO\Exam\ExamFilterDTO;
use App\Entity\Exam\StudentExam;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentExam|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentExam|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentExam[]    findAll()
 * @method StudentExam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentExam::class);
    }

    public function findByStudent(Student $student, ?ExamFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('se')
            ->leftJoin('se.teacherExam', 'teacherExam')
            ->where('se.author = :student')
            ->setParameter('student', $student);

        if (!empty($filter)) {
            if (!empty($filter->getDiscipline())) {
                $qb->andWhere('teacherExam.discipline = :discipline')
                    ->setParameter('discipline', $filter->getDiscipline());
            }

            if (!empty($filter->getFrom())) {
                $qb->andWhere('teacherExam.startedAt >= :fromDate')
                    ->setParameter('fromDate', $filter->getFrom()->format('Y-m-d'));
            }

            if (!empty($filter->getTo())) {
                $qb->andWhere('teacherExam.startedAt <= :toDate')
                    ->setParameter('toDate', $filter->getTo()->format('Y-m-d 23:59:59'));
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function findByToken(Student $student, string $token)
    {
        $qb = $this->createQueryBuilder('se')
            ->leftJoin('se.teacherExam', 'teacherExam')
            ->where('se.author = :student')
            ->andWhere('teacherExam.token = :token')
        ->setParameters(['student' => $student, 'token' => $token]);

        return $qb->getQuery()->getOneOrNullResult();

    }
}
