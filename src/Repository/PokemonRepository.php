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
            $query->where('p.type1 LIKE :val')
                ->orWhere('p.type2 LIKE :val');
        } else {
            $query->where('p.numPokedex LIKE :val');
        }
        $query->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->setParameter('val', '%' . $value . '%');
        $pag = new Paginator($query);

        return $pag;
    }

    public function findByUser(User $user, bool $have,int $firstResult, int $maxResults = 20)
    {
        $query = $this->createQueryBuilder('p')
                    ->join('p.user', 'u');
        if ($have) {
            $query->where('p.user NOT IN :user');
        } else {
            $query->where('p.user IN :user');
        }
        $query->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->setParameter('user', $user->getId());
        $pag = new Paginator($query);

        return $pag;
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
