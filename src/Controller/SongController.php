<?php

namespace App\Controller;

use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/songs', name: 'song_index')]
    public function index(SongRepository $repo): Response
    {
        // 1) Récupère toutes les chansons, triées par date de création descendante
        $songs = $repo->findBy([], ['createdAt' => 'DESC']);

        // 2) Rends la vue et transmets les chansons
        return $this->render('song/index.html.twig', [
            'songs' => $songs,
        ]);
    }

    #[Route('/songs/{id}', name: 'song_show', requirements: ['id' => '\d+'])]
    public function show(int $id, SongRepository $repo): Response
    {
        // 1) Récupère la chanson par son id
        $song = $repo->find($id);

        // 2) Si non trouvée, lance une 404
        if (!$song) {
            throw $this->createNotFoundException('Chanson non trouvée.');
        }

        // 3) Rend la vue de détail
        return $this->render('song/show.html.twig', [
            'song' => $song,
        ]);
    }
}


