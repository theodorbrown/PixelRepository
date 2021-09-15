<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new(): Response {

        return $this->render("game/new.html.twig");
    }
}
