<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/synth', name: 'app_synth_')]
class SynthController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(Request $request, TrackRepository $trackRepository): Response
    {
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackRepository->add($track, true);
            return $this->redirectToRoute('app_track_index');
        }

        return $this->renderForm('synth/index.html.twig', ['form' => $form]);
    }
}
