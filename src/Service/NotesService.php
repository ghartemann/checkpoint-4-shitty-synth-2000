<?php

namespace App\Service;

use App\Repository\NoteRepository;

class NotesService
{
    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getNotes(): array
    {
        return $notes = $this->noteRepository->findAll();
    }
}
