<?php

namespace App\Repository;

use App\Entity\Pokemon;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findByLike(string $searchedBy, string $value, $firstResult, $maxResults = 20)
    {
        $query = $this->createQueryBuilder('p');
        if ($searchedBy === 'name') {
            $query->where('p.name LIKE :val');
        } elseif ($searchedBy === 'type') {
            $query
                ->where('p.type1 LIKE :val')
                ->orWhere('p.type2 LIKE :val');
        } else {
            $query->where('p.numPokedex LIKE :val');
        }
        $query
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->setParameter('val', "%$value%");

        $pag = new Paginator($query);
        return $pag;
    }

    public function findByUser(
        User $user, bool $onlyPossessed, int $offset, string $searchedBy = null, string $value = null, int $limit = 20
    )
    {
        $query = $this
            ->createQueryBuilder('p')
            ->leftJoin('p.users', 'u');

        if ($searchedBy === 'name') {
            $query->where('p.name LIKE :val');
        } elseif ($searchedBy === 'type') {
            $query
                ->where('p.type1 LIKE :val')
                ->orWhere('p.type2 LIKE :val');
        } else {
            $query->where('p.numPokedex LIKE :val');
        }

        if ($onlyPossessed) {
            $expr = $query
                ->expr()
                ->in('u', $user->getId());
            $query->andWhere($expr);
        } else {
            foreach ($user->getPokemons() as $pokemon) {
                $expr = $query
                    ->expr()
                    ->notIn('p', $pokemon->getId());
                $query->andWhere($expr);
            }
        }

        $query
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('val', "%$value%");

        $paginator = new Paginator($query);
        return $paginator;
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
