<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(NoteRepository $noteRepository): Response
    {
        $notes = $noteRepository->findAll();

        return $this->render('home/index.html.twig', ['notes' => $notes]);
    }
}
