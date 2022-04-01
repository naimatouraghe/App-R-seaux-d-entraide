<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\QuestionFormType;
use App\Entity\Post;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    { 
        $results = $doctrine->getRepository(Post::class)->findAll([], ["created_at" => "DESC","active" => true]);
        
        $posts = new Post();
        $form = $this->createForm(QuestionFormType::class, $posts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posts -> setQuestion(
                $form->get('question')->getData()
            );
            $posts -> setContent(
                $form->get('content')->getData()
            );
            $entityManager->persist($posts);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'result' => $results,
            'questionForm' => $form->createView(),
        ]);
    }
}
