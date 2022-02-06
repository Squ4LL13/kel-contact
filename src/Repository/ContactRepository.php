<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return Contact[] Returns an array of Contact objects
     */
    public function orderByName()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * 
     */
    public function findContactSearch(string $query)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('c.name', ':query'),
                        $qb->expr()->like('c.firstname', ':query'),
                        $qb->expr()->like('c.lastname', ':query'),
                        $qb->expr()->like('c.note', ':query'),
                        $qb->expr()->like('c.service', ':query'),
                        $qb->expr()->like('c.company', ':query'),
                    )
                )
            )
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('c.name', 'ASC')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }
    
    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
