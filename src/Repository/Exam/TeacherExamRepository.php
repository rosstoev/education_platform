<?php

namespace App\Repository\Exam;

use App\Entity\Exam\TeacherExam;
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

    // /**
    //  * @return TeacherExam[] Returns an array of TeacherExam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeacherExam
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
