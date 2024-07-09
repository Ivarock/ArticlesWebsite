<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use ArticlesWebsite\Repositories\CommentRepository;
use ArticlesWebsite\Repositories\LikeRepository;
use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;

class ShowArticleController
{
    private ArticleRepositoryInterface $articleRepository;
    private CommentRepository $commentRepository;
    private LikeRepository $likeRepository;
    private TemplateRenderer $renderer;

    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        CommentRepository $commentRepository,
        LikeRepository $likeRepository,
        TemplateRenderer $renderer
    ) {
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
        $this->likeRepository = $likeRepository;
        $this->renderer = $renderer;
    }

    /**
     * @throws Exception
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $article = $this->articleRepository->find($id);
        $comments = $this->commentRepository->findByArticleId($id);
        $articleLikes = $this->likeRepository->findByItemIdAndType($id, 'article');

        foreach ($comments as $comment) {
            $comment->likes = $this->likeRepository->findByItemIdAndType($comment->getId(), 'comment');
        }

        return $this->renderer->render($response, 'articles/show.twig', [
            'article' => $article,
            'comments' => $comments,
            'articleLikes' => $articleLikes
        ]);
    }
}
