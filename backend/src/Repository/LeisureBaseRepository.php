<?php

namespace App\Repository;

use App\Entity\LeisureBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<LeisureBase>
 *
 * @method LeisureBase|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeisureBase|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeisureBase[]    findAll()
 * @method LeisureBase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeisureBaseRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, LeisureBase::class);
        $this->paginator = $paginator;
    }


   /**
    * @return LeisureBase[] Returns an array of LeisureBase objects
    */
   public function findByNameDescriptionOrActivityCategory(int $page,int $limit, ?string $name, ?string $description, ?string $category):  PaginationInterface
   {
        $builder = $this->createQueryBuilder('l')->leftJoin('l.activityCategories', 'c')->orderBy('l.name', 'ASC');

        if($name){            
            $builder->andWhere('lower(l.name) like :name')
            ->setParameter('name', '%'.strtolower($name).'%');
        }
        
        if($description){            
            $builder->andWhere('lower(l.description) like :description')
            ->setParameter('description', '%'.strtolower($description).'%');
        }

        if($category){            
            $builder->andWhere('lower(c.label) like :activityCategory')
            ->setParameter('activityCategory', '%'.strtolower($category).'%');
        }


        return $this->paginator->paginate(
            $builder,
            $page,
            $limit,
            [ ]
        );
   }

//    public function findOneBySomeField($value): ?LeisureBase
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
