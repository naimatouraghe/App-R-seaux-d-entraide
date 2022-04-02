<?php

namespace App\Controller;
use App\Entity\Post;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profil/posts', name: 'posts')]
    public function posts(): Response
    {

        return $this->render('profile/posts.html.twig', [
            'controller_name' => 'Post de l\'utilisateur',
        ]);
    }


    
}
