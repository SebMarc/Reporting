<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllTechnicien() {
        return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :role')
        ->setParameter('role','%ROLE_TECH%')
        ->getQuery()
        ->getResult();
    }
 

    public function getClientByTechnicien($id) {
        return $this->createQueryBuilder('u')
        ->where('u.technicien LIKE :tech')
        ->setParameter('tech', $id)
        ->getQuery()
        ->getResult();
    }

    public function getAllMemberOnly() {
        return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :role')
        ->setParameter('role','%ROLE_MEMBER%')
        ->getQuery()
        ->getResult();
    }

  





    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
