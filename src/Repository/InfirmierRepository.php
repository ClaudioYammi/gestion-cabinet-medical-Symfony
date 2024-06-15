<?php

namespace App\Repository;

use App\Entity\Infirmier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Infirmier>
 *
 * @method Infirmier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infirmier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infirmier[]    findAll()
 * @method Infirmier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfirmierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infirmier::class);
    }

    public function searchByLetter(string $searchTerm): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Infirmier p
            WHERE LOWER(p.nom) LIKE LOWER(:searchTerm)
            OR LOWER(p.prenom) LIKE LOWER(:searchTerm)'
        )->setParameter('searchTerm', '%' . strtolower($searchTerm) . '%');

        return $query->getResult();
    }
    
//    /**
//     * @return Infirmier[] Returns an array of Infirmier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Infirmier
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
