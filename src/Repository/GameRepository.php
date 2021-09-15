<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class GameRepository extends ServiceEntityRepository {
    
    public function __construct(ManagerRegistry $registry)
    {
        //indique que le repository est associé à l'entité Game
        parent:: __construct($registry, Game:: class);
    }
}