<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/serie')]
class SerieController extends AbstractController
{
    #[Route('/', name: 'app_admin_serie_index', methods: ['GET'])]
    public function index(SerieRepository $serieRepository): Response
    {
        return $this->render('admin/serie/index.html.twig', [
            'series' => $serieRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'app_admin_serie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SerieRepository $serieRepository): Response
    {
        $serie = new Serie();
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serieRepository->add($serie, true);

            return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/serie/new.html.twig', [
            'serie' => $serie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_serie_show', methods: ['GET'])]
    public function show(Serie $serie): Response
    {
        return $this->render('admin/serie/show.html.twig', [
            'serie' => $serie,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_admin_serie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Serie $serie, SerieRepository $serieRepository): Response
    {
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serieRepository->add($serie, true);

            return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/serie/edit.html.twig', [
            'serie' => $serie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_serie_delete', methods: ['POST'])]
    public function delete(Request $request, Serie $serie, SerieRepository $serieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serie->getId(), $request->request->get('_token'))) {
            $serieRepository->remove($serie, true);
        }

        return $this->redirectToRoute('app_admin_serie_index', [], Response::HTTP_SEE_OTHER);
    }
}
