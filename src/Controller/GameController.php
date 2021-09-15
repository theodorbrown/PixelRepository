<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Définie un préfix pour toutes les routes de ce controller
 * 
 * @Route("/game")
 */

class GameController extends AbstractController {
    /**
     * @Route ("/new")
     */
    //EntityManagerInterface est un service. Objet que Symfony nous crée
    public function new(EntityManagerInterface $entityManager, Request $request): Response {

        $entity = new Game;
        //création d'un nouveau formulaire en utilisant la classe GameType
        $form = $this->createForm(GameType ::class, $entity);

        //injection de la requête dans le formulaire pour récuperer les données POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity); //Prépare la requête
            $entityManager->flush(); //Execute la requête
        }

        return $this->render("game/new.html.twig", [
            'form' => $form->createView(), //envoie pour twig
        ]);
    }
}
