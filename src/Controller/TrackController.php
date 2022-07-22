<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\TrackRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER')]
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

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Track           $track,
        TrackRepository $trackRepository,
        Request         $request,
    ): Response
    {
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trackRepository->add($track, true);

            return $this->redirectToRoute('app_track_show', ['id' => $track->getId()]);
        }

        return $this->renderForm('track/edit.html.twig', ['track' => $track, 'form' => $form,]);
    }

    /**
     * @throws Exception
     */
    #[IsGranted('ROLE_ADMIN, ROLE_SYNTHER')]
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
