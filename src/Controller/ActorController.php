<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ActorRepository $actorRepository): Response
    {
        $actors= $actorRepository->findAll();
        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Actor $actor, ProgramRepository $programRepository): Response
    {
        $allPrograms = $programRepository->findAll();
        $actorPrograms = [];
        foreach ($allPrograms as $program) {
            foreach ($program->getActors() as $programActor) {
                if ($programActor === $actor) {
                    $actorPrograms[] = $program;
                }
            }
        }
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $actorPrograms,
        ]);
    }
}
