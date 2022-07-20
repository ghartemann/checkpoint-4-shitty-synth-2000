<?php

namespace App\Controller;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/track', name: 'app_track_')]
class TrackController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(TrackRepository $trackRepository): Response
    {
        $tracks = $trackRepository->findAll();

        return $this->render('track/index.html.twig', ['tracks' => $tracks,]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Track $track): Response
    {
        return $this->render('track/show.html.twig', ['track' => $track]);
    }
}
