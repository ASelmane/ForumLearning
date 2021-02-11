<?php

namespace App\Controller;

use App\Entity\Dislikes;
use App\Entity\Likes;
use App\Entity\Topics;
use App\Form\TopicsType;
use App\Repository\DislikesRepository;
use App\Repository\LikesRepository;
use App\Repository\TopicsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topics")
 */
class TopicsController extends AbstractController
{
    /**
     * @Route("/", name="topics_index", methods={"GET"})
     */
    public function index(TopicsRepository $topicsRepository): Response
    {
        return $this->render('topics/index.html.twig', [
            'topicsRecent' => $topicsRepository->findBy (array (), array ('date' => 'ASC')),
        ]);
    }

    /**
     * Permet de liker ou unliker un article
     * 
     *@Route("/{id}/like", name="topic_like")
     * 
     * @param Topics $topics
     * @param LikesRepository $likesRepo
     * @param DislikesRepository $dislikesRepo
     * @return Response
     */
    public function like(Topics $topics, LikesRepository $likesRepo, DislikesRepository $dislikesRepo) : Response 
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        
        if (!$user)  return $this->json([
            'code' => 403,
            'message' => "Pas connecté"
        ], 403);

        if($topics->likeBy($user)){
            $like = $likesRepo->findOneBy([
                'topic' => $topics,
                'user' => $user
            ]);
            $entityManager->remove($like);
            $entityManager->flush();
            
            return $this->json([
            'code' => 200,
            'message' => 'like bien supprimé',
            'likes' => $likesRepo->count(['topic' => $topics]),
            'dislikes' => $dislikesRepo->count(['topic' => $topics])
            ], 200);
        }

        if ($topics->dislikeBy($user)) {
            $dislike = $dislikesRepo->findOneBy([
                'topic' => $topics,
                'user' => $user
            ]);
            $entityManager->remove($dislike);
            $entityManager->flush();
        }

        $like = new Likes();
        $like-> setTopic($topics)
             -> setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouté',
            'likes' => $likesRepo->count(['topic' => $topics]),
            'dislikes' => $dislikesRepo->count(['topic' => $topics])
            ], 200);
    }

/**
 * Permet de disliker ou undisliker un article
 *
 * @Route("/{id}/dislike", name="topic_dislike")
 * 
 * @param Topics $topics
 * @param DislikesRepository $dislikesRepo
 * @param LikesRepository $likesRepo
 * @return Response
 */
    public function dislike(Topics $topics, DislikesRepository $dislikesRepo, LikesRepository $likesRepo ) : Response 
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        
        if (!$user)  return $this->json([
            'code' => 403,
            'message' => "Pas connecté"
        ], 403);

        if($topics->dislikeBy($user)){
            $dislike = $dislikesRepo->findOneBy([
                'topic' => $topics,
                'user' => $user
            ]);
            $entityManager->remove($dislike);
            $entityManager->flush();
            
            return $this->json([
            'code' => 200,
            'message' => 'dislike bien supprimé',
            'likes' => $likesRepo->count(['topic' => $topics]),
            'dislikes' => $dislikesRepo->count(['topic' => $topics])
            ], 200);
        }
        
        if ($topics->likeBy($user)) {
            $like = $likesRepo->findOneBy([
                'topic' => $topics,
                'user' => $user
            ]);
            $entityManager->remove($like);
            $entityManager->flush();
        }
            
        $dislike = new Dislikes();     
        $dislike-> setTopic($topics)
                -> setUser($user);

        $entityManager->persist($dislike);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'dislike bien ajouté',
            'likes' => $likesRepo->count(['topic' => $topics]),
            'dislikes' => $dislikesRepo->count(['topic' => $topics])
            ], 200);
    }

    /**
     * @Route("/new", name="topics_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $topic = new Topics();
        $form = $this->createForm(TopicsType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setUsers($this->getUser());
            $topic->setDate(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topics_index');
        }

        return $this->render('topics/new.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="topics_show", methods={"GET"})
     */
    public function show(Topics $topic): Response
    {
        return $this->render('topics/show.html.twig', [
            'topic' => $topic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="topics_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Topics $topic): Response
    {
        $form = $this->createForm(TopicsType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topics_index');
        }

        return $this->render('topics/edit.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="topics_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Topics $topic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topics_index');
    }
}
