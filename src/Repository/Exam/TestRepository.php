<?php

namespace App\Repository\Exam;

use App\DTO\TestFilterDTO;
use App\Entity\Exam\Test;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function findByTeacher(Teacher $teacher, ?TestFilterDTO $filter = null)
    {
        $qb = $this->createQueryBuilder('examTest')
        ->where('examTest.author = :teacher')
        ->setParameter('teacher', $teacher);

        if (!empty($filter)) {
            if (!empty($filter->getTitle())) {
                $qb->andWhere($qb->expr()->andX($qb->expr()->like('examTest.title', ':title')));
                $qb->setParameter('title', '%' . $filter->getTitle() . '%');
            }

            if (!empty($filter->getFrom())) {
                $qb->andWhere('examTest.createdAt >= :fromDate')
                    ->setParameter('fromDate', $filter->getFrom()->format('Y-m-d 00:00:00'));
            }

            if (!empty($filter->getTo())) {
                $qb->andWhere('examTest.createdAt <= :toDate')
                    ->setParameter('toDate', $filter->getTo()->format('Y-m-d 23:59:59'));
            }
        }

        return $qb->getQuery()->getResult();
    }
}
