<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($registry, Recette::class);
        $this->entityManagerInterface = $entityManagerInterface;
    }

    //function qui permet d'enregistrer une recette

    public function saveRecette($title, $soustitres, $ingredient)
    {
        $newRecette = new Recette();

        $newRecette->setTitle($title)
                   ->setSoustitres($soustitres)
                   ->setIngredient($ingredient)
        ;

        $this->entityManagerInterface->persist($newRecette);
        $this->entityManagerInterface->flush();

    }

    public function updateRecette(Recette $recette)
    {
        $this->entityManagerInterface->persist($recette);
        $this->entityManagerInterface->flush();

        return $recette;

    }

    public function removeRecette(Recette $recette)
    {
        $this->entityManagerInterface->remove($recette);
        $this->entityManagerInterface->flush();
    }


















    // /**
    //  * @return Recette[] Returns an array of Recette objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recette
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
