<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Définie un préfix pour toutes les routes de ce controller
 * 
 * @Route("/game")
 */

class GameController extends AbstractController {

    /**
     * @Route ("/")
     */
    public function list(GameRepository $gameRepository): Response {

        //retourne tous les jeux de la base
        $entities = $gameRepository->findAll();

        return $this->render("game/list.html.twig", [
            'entities' => $entities
        ]);

    }


    /**
     * @Route ("/new")
     */
    //EntityManagerInterface est un service. Objet que Symfony nous crée
    public function new(EntityManagerInterface $entityManager, Request $request, TranslatorInterface $translator): Response {

        //Autre manière d'obtenir EntityManager
        //$entityManager = $this.getDoctrine()->getManager();

        $entity = new Game;
        //création d'un nouveau formulaire en utilisant la classe GameType
        $form = $this->createForm(GameType ::class, $entity);

        //injection de la requête dans le formulaire pour récuperer les données POST : hydrater un objet
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity); //Prépare la requête : plusieurs persists sont possible
            $entityManager->flush(); //Execute la requête

            //message de succès (pop up)
            $this->addFlash('success', $translator->trans('game.new.success', ['%game%' => $entity->getTitle()]));

            //redirection
            return $this->redirectToRoute("app_game_list");
        }

        return $this->render("game/new.html.twig", [
            'form' => $form->createView(), //envoie pour twig
        ]);
    }

    /**
     * Requirements indique la valeure attendue en paramètre
     * @Route("/{id}/edit", requirements={"id":"\d+"})
     */
    public function edit(Game $entity, Request $request, EntityManagerInterface $entityManagerInterface) : Response {

        $form = $this->createForm(GameType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->flush();//l'entité est déja enregistrée dans l'ORM pas besoin de faire un persist

            $this->addFlash('success', 'Le jeu a bien été modifié');

            return $this->redirectToRoute("app_game_list");
        }

        return $this->render("game/edit.html.twig", [
            'form' => $form->createView(),
            'entity' => $entity
        ]);
    }


    /**
     * Requirements indique la valeure attendue en paramètre
     * @Route("/{id}/delete", requirements={"id":"\d+"})
     */
    public function delete(Game $entity, Request $request, EntityManagerInterface $entityManagerInterface): Response {

        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->get('token'))) {
            $entityManagerInterface->remove($entity);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_game_list');
        }

        return $this->render("game/delete.html.twig", [
            'entity' => $entity
        ]);
    }
}
