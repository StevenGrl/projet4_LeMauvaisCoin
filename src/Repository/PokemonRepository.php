<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    /**
     * @return Pokemon[] Returns an array of Pokemon objects
     */

    public function findByLike(string $searchedBy, string $value)
    {
        $query = $this->createQueryBuilder('p');
        if ($searchedBy === 'name') {
            $query->where('p.name LIKE :val');
        } elseif ($searchedBy === 'type') {
            $query->where('p.type1 LIKE :val')
                ->orWhere('p.type2 LIKE :val');
        } else {
            $query->where('p.numPokedex LIKE :val');
        }
        $query->setParameter('val', '%' . $value . '%');

        return $query->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
