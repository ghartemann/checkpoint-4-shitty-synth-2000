<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nkultra', name: 'app_nkultra_')]
class NKULTRAController extends AbstractController
{

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('nkultra/index.html.twig', [
            'controller_name' => 'NKULTRAController',
        ]);
    }
}
