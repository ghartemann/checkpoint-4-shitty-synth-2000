<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TrackRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_SYNTHER')]
#[Route('/user-profile', name: 'app_user_profile_')]
class UserProfileController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('user_profile/index.html.twig');
    }

    #[Route('/my-tracks', name: 'tracks')]
    public function trackList(TrackRepository $trackRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        $tracks = $trackRepository->findBy(['creator' => $userId]);

        return $this->render('track/index.html.twig', ['tracks' => $tracks]);
    }
}
