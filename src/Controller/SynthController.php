<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/synth', name: 'app_synth_')]
class SynthController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(NoteRepository $noteRepository): Response
    {
        return $this->render('synth/index.html.twig');
    }
}
