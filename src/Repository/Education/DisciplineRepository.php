<?php

namespace App\Repository\Education;

use App\Entity\Education\Discipline;
use App\Entity\Education\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discipline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discipline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discipline[]    findAll()
 * @method Discipline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisciplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discipline::class);
    }

    public function findByGroup(Group $group)
    {
        $qb = $this->createQueryBuilder('discipline')
        ->leftJoin('discipline.studentGroups', 'student_group')
        ->where('student_group = :group')
        ->setParameter('group', $group)
        ->getQuery();

        return $qb->getResult();
    }
}
