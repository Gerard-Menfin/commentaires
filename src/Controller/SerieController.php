<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Serie;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SerieController extends AbstractController
{
    #[Route('/serie', name: 'app_serie')]
    public function index(): Response
    {
        return $this->render('serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }

    #[Route('/commenter-la-serie-{id}', name: 'app_serie_comment')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function comment(Serie $serie, Request $request, CommentaireRepository $cr): Response
    {
        $commentaire = new Commentaire;
        
        if( $request->isMethod("POST")){
            $commentaire->setSerie($serie);
            $commentaire->setUser( $this->getUser() );
            $commentaire->setSujet( $request->request->get("sujet") );
            $commentaire->setTexte( $request->request->get("texte") );
            $cr->add($commentaire, true);
        }
        return $this->render('serie/fiche.html.twig', [
            'serie' => $serie,
        ]);
    }
}
