<?php

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    public function findAllOrderedByValidationByQuestion(Question $question)
    {
        return $this->createQueryBuilder('a')
            ->join('a.question', 'q')
            ->addSelect('q')
            ->where('a.question = :myquestion')
            ->setParameter('myquestion', $question)
            ->orderBy('a.isValid', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveOrderedByValidationByQuestion(Question $question)
    {
        return $this->createQueryBuilder('a')
            ->join('a.question', 'q')
            ->addSelect('q')
            ->where('a.question = :myquestion')
            ->setParameter('myquestion', $question)
            ->andWhere('a.isActive = true')
            ->orderBy('a.isValid', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Answer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
