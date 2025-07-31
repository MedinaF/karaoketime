<?php

namespace App\Controller;

use App\Entity\Song;
use App\Form\SongType;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SongController extends AbstractController
{
    #[Route('/songs', name: 'song_index')]
    public function index(SongRepository $repo): Response
    {
        // Récupère toutes les chansons, triées par date de création descendante
        $songs = $repo->findBy([], ['createdAt' => 'DESC']);

        // Affiche la liste des chansons dans la vue
        return $this->render('song/index.html.twig', [
            'songs' => $songs,
        ]);
    }

    #[Route('/songs/{id}', name: 'song_show', requirements: ['id' => '\d+'])]
    public function show(int $id, SongRepository $repo): Response
    {
        // Récupère la chanson par son id
        $song = $repo->find($id);

        // Si la chanson n'est pas trouvée, affiche une erreur 404
        if (!$song) {
            throw $this->createNotFoundException('Chanson non trouvée.');
        }

        // Affiche la page de détail de la chanson
        return $this->render('song/show.html.twig', [
            'song' => $song,
        ]);
    }

    #[Route('/songs/new', name: 'song_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        ParameterBagInterface $params
    ): Response {
        // Vérifie que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Crée une nouvelle instance de Song et le formulaire associé
        $song = new Song();
        $form = $this->createForm(SongType::class, $song);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Gère l'upload de l'image si présente
            $file = $form->get('image')->getData();
            if ($file) {
                $filename = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $params->get('images_directory'),
                    $filename
                );
                $song->setImage($filename);
            }

            // Définit l'utilisateur courant comme uploader et la date de création
            $song->setUploadedBy($this->getUser());
            $song->setCreatedAt(new \DateTime());

            // Enregistre la chanson en base de données
            $em->persist($song);
            $em->flush();

            // Ajoute un message de succès
            $this->addFlash('success', 'Chanson ajoutée avec succès !');

            // Redirige vers la liste des chansons
            return $this->redirectToRoute('song_index');
        }

        // Affiche le formulaire de création de chanson
        return $this->render('song/new.html.twig', [
            'songForm' => $form->createView(),
        ]);
    }

}