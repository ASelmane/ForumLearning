<?php

namespace App\Controller;

use App\Entity\Topics;
use App\Form\TopicsType;
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
