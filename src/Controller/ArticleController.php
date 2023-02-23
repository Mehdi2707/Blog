<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CommentType;
use App\Entity\Comment;
use App\Service\CommentService;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(CommentService $commentService, ?Article $article): Response
    {
        if(!$article)
            return $this->redirectToRoute('app_home');

        $comment = new Comment($article);

        $commentForm = $this->createForm(CommentType::class, $comment);
        
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $commentService->getPaginatedComments($article),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
