<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\TrackRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/track', name: 'app_track_')]
class TrackController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('track/index.html.twig', [
            'controller_name' => 'TrackController',
        ]);
    }

////    #[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_SYNTHER')")]
//    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
//    public function new(
//        TrackRepository $trackRepository,
//        Request         $request,
//    ): Response
//    {
//        return $this->renderForm('track/new.html.twig', [
//            'track' => $track,
//            'form' => $form,
//        ]);
//    }
}
