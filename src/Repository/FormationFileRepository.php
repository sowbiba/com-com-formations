<?php

namespace App\Repository;

use App\Entity\FormationFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationFile[]    findAll()
 * @method FormationFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationFile::class);
    }

    // /**
    //  * @return FormationFile[] Returns an array of FormationFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormationFile
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
