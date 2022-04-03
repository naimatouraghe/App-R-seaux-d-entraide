<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\QuestionFormType;
use App\Entity\Comment;
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

    #[Route('/post/{id}', name: 'app_post')]
    public function comment(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, int $id): Response
    {   
        $user = $this->getUser();
        $post = $doctrine->getRepository(Post::class)->find($id);
        $comment = $post->getComments();
        // $commentForm = $this->createForm(CommentFormType::class, $addComment);
        // $commentForm->handleRequest($request);

        $request = Request::createFromGlobals();
        if($request->request->get('comment')){
            $entityManager = $doctrine->getManager();
            $addComment = new Comment();
            $addComment->setContent($request->request->get('comment'));
            $addComment->setUsers($user);
            $addComment->setPosts($post);
            $entityManager->persist($addComment);
            $entityManager->flush();
        }
        dd(app.user);
        return $this->render('Post/post.html.twig', [
            'post' => $post,
            'comment' => $comment,
            'controller_name' => 'CommentController',
        ]);
    }
}

