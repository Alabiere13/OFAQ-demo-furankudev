<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\VoteForAnswer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method VoteForAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoteForAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoteForAnswer[]    findAll()
 * @method VoteForAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteForAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VoteForAnswer::class);
    }

    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.user = :user')
            ->setParameter('user', $user)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return VoteForAnswer[] Returns an array of VoteForAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoteForAnswer
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
