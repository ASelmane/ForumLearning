<?php

namespace App\Controller;

use App\Repository\TopicsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            if ($topic->EditLimit()) {
                $editLimit[$id]  = 1 ;
            } else {
                $editLimit[$id]  = 0 ;
            }

            $description[$id]= $topic->description();
        }

        return $this->render('main/index.html.twig', [
            'topicsRecent' => $topics, "editLimit"=>$editLimit, 'current_menu'=> 'dashboard', "description"=>$description
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function handleSearch(Request $request, TopicsRepository $topicRepository)
    {
        $topics =[];
        $description= [];
        $editLimit =[];
        $search= $request->request->get('search');
        if($search)
        {
            $topics = $topicRepository->searchTopics($search);
        
            foreach ($topics as $topic) {
                $id = $topic->getId();
                if ($topic->EditLimit()) {
                    $editLimit[$id]  = 1 ;
                } else {
                    $editLimit[$id]  = 0 ;
                }

                $description[$id] = $topic->description();
            }
            
        }
        return $this->render('main/searchResult.html.twig', [
            'topics' => $topics, "editLimit"=>$editLimit, "description"=>$description
        ]);
    }
}
