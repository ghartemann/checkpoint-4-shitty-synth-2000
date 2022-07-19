<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SynthController extends AbstractController
{
    #[Route('/synth', name: 'app_synth')]
    public function index(): Response
    {
        return $this->render('synth/index.html.twig', [
            'controller_name' => 'SynthController',
        ]);
    }
}
