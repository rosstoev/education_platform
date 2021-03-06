<?php

namespace App\Repository\Education;

use App\DTO\GroupFilterDTO;
use App\Entity\Education\Group;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function findByCriteria(Teacher $teacher, ?GroupFilterDTO $filterDTO)
    {
        $qb = $this->createQueryBuilder('g')
            ->where('g.teacher = :teacher')
            ->setParameter('teacher', $teacher);

        if (!empty($filterDTO)) {
            if (!empty($filterDTO->getDiscipline())) {
                $qb->leftJoin('g.disciplines', 'discipline')
                ->andWhere('discipline = :discipline')
                ->setParameter('discipline', $filterDTO->getDiscipline());
            }

            if (!empty($filterDTO->getYear())) {
                $dateInit = new \DateTime();
                $year = date_create($dateInit->format($filterDTO->getYear() . '-m-d'));
                $qb->andWhere('g.year = :year')
                ->setParameter('year', $year);
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function findByStudent(Student $student, ?GroupFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('g')
        ->leftJoin('g.students', 'student')
        ->where('student = :student')
        ->setParameter('student', $student);

        if (!empty($filter)) {
            if (!empty($filter->getDiscipline())) {
                $qb->leftJoin('g.disciplines', 'discipline')
                    ->andWhere('discipline = :discipline')
                    ->setParameter('discipline', $filter->getDiscipline());
            }

            if (!empty($filter->getYear())) {
                $dateInit = new \DateTime();
                $year = date_create($dateInit->format($filter->getYear() . '-m-d'));
                $qb->andWhere('g.year = :year')
                    ->setParameter('year', $year);
            }
        }

        return $qb->getQuery()->getResult();
    }
}
