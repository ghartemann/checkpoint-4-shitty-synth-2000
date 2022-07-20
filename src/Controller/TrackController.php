<?php

namespace App\Controller;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @throws Exception
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Track $track, TrackRepository $trackRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('_delete' . $track->getId(), $request->request->get('_token'))) {
                $trackRepository->remove($track, true);
            } else {
                throw new Exception(message: 'token should be string or null');
            }
        }

        return $this->redirectToRoute('app_track_index', [], Response::HTTP_SEE_OTHER);
    }
}
