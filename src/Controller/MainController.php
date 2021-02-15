<?php

namespace App\Controller;

use App\Repository\TopicsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(TopicsRepository $topicsRepository): Response
    {
        $topics = $topicsRepository->findBy(array(), array('date' => 'DESC'), 5);
        foreach ($topics as $topic) {
            $id = $topic->getId();
            if($topic->EditLimit()) $editLimit[$id]  = 1 ;
            else $editLimit[$id]  = 0 ;
        }

        return $this->render('main/index.html.twig', [
            'topicsRecent' => $topics, "editLimit"=>$editLimit
        ]);
    }

}
