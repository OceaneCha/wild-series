<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/show/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id:' . $id . ' found.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/show/{programId}/seasons/{seasonId}', name: 'season_show', requirements: ['id' => '\d+', 'seasonId' => '\d+'], methods: ['GET'])]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $programId]);
        $season = $seasonRepository->findOneBy(['id' => $seasonId]);
        
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }
}
