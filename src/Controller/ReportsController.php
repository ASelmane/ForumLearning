<?php

namespace App\Controller;

use App\Entity\Reports;
use App\Repository\ReportsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reports")
 */
class ReportsController extends AbstractController
{
    /**
     * @Route("/", name="reports_index", methods={"GET"})
     */
    public function index(ReportsRepository $reportsRepository): Response
    {
        return $this->render('reports/index.html.twig', [
            'reports' => $reportsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="reports_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reports $report): Response
    {
        if(!($this->isGranted('ROLE_ADMIN'))){
            return $this->redirectToRoute('topics_index');
       }
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($report);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reports_index');
    }
}
