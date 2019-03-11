<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findActiveOrderedByMostRecentlyAdded()
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.isActive = true')
            ->orderBy('q.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveOrderedByMostRecentlyAddedByTitle($search)
    {
        return $this->createQueryBuilder('q')
            ->join('q.answers', 'a')
            ->addSelect('a')
            ->orWhere('q.title LIKE :search')
            ->orWhere('q.body LIKE :search')
            ->orWhere('a.title LIKE :search')
            ->orWhere('a.body LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->andWhere('q.isActive = true')
            ->orderBy('q.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
