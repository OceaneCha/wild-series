<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Program;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Actor $actor, ActorRepository $actorRepository, ProgramRepository $repository): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actorRepository->save($actor, true);

            $this->addFlash('success', 'The actor has been edited!');

            return $this->redirectToRoute('actor_show', ['id' => $actor->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }
}
