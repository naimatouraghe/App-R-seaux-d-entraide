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
    
    #[Route('/profil/posts', name: 'profil_posts')]


    #[Route('/profil/posts/ajout', name: 'profil_posts_ajout')]
    public function ajoutAnnonce(Request $request, ManagePicturesService $picturesService)
    {
        $post = new Post;

        $form = $this->createForm(EditProfileType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $post->setUsers($this->getPost());
            $post->setActive(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('profil');
        }

        return $this->render('editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
