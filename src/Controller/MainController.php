<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/Dashboard", name="Dashboard")
     */
    public function index(): Response
    {
        $users= $this->getUser();
        return $this->render('main/index.html.twig', [
            'user' => $users,
        ]);
    }

}
