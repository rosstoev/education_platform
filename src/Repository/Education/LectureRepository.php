<?php

namespace App\Repository\Education;

use App\DTO\LectureFilterDTO;
use App\Entity\Education\Lecture;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecture[]    findAll()
 * @method Lecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LectureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecture::class);
    }

    public function findByTeacher(Teacher $teacher, ?LectureFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('lecture')
            ->leftJoin('lecture.discipline', 'discipline')
            ->where('discipline.teacher = :teacher')
            ->setParameter('teacher', $teacher);

        $this->addFilterCriteria($qb, $filter);

        return $qb->getQuery()->getResult();
    }

    public function findByStudent(Student $student, ?LectureFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('lecture')
        ->leftJoin('lecture.discipline', 'discipline')
        ->leftJoin('lecture.studentGroup', 'studentGroup')
        ->leftJoin('studentGroup.students', 'student')
        ->where('student = :student')
        ->setParameter('student', $student);

        $this->addFilterCriteria($qb, $filter);

        return $qb->getQuery()->getResult();
    }

    private function addFilterCriteria(QueryBuilder $qb, ?LectureFilterDTO $filter): void
    {
        if (!empty($filter)) {
            if (!empty($filter->getDiscipline())) {
                $qb->andWhere('discipline = :discipline')
                    ->setParameter('discipline', $filter->getDiscipline());
            }

            if (!empty($filter->getFrom())) {
                $qb->andWhere('lecture.startDate >= :fromDate')
                    ->setParameter('fromDate', $filter->getFrom()->format('Y-m-d'));
            }

            if (!empty($filter->getTo())) {
                $qb->andWhere('lecture.startDate <= :toDate')
                    ->setParameter('toDate', $filter->getTo()->format('Y-m-d 23:59:59'));
            }
        }
    }
}
