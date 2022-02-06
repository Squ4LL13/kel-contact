<?php

namespace App\Repository;

use App\Entity\LetterCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LetterCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LetterCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LetterCategory[]    findAll()
 * @method LetterCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LetterCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LetterCategory::class);
    }

    // /**
    //  * @return LetterCategory[] Returns an array of LetterCategory objects
    //  */
    
    public function findAllOrderBy()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.letter', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?LetterCategory
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
