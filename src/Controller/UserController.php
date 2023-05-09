<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/my_profile', name: 'app_user_profile')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(['author' => $this->getUser()], ['id' => 'DESC']);

        return $this->render('user/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
