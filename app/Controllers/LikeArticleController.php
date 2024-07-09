<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\LikeService;
use ArticlesWebsite\Repositories\LikeRepository;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LikeArticleController
{
    private LikeService $likeService;
    private LikeRepository $likeRepository;
    private LoggerInterface $logger;

    public function __construct(LikeService $likeService, LikeRepository $likeRepository, LoggerInterface $logger)
    {
        $this->likeService = $likeService;
        $this->likeRepository = $likeRepository;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $articleId = (int)$args['id'];
        $this->likeService->likeItem($articleId, 'article');
        $this->logger->info('Liked an article', ['article_id' => $articleId]);

        $likes = $this->likeRepository->findByItemIdAndType($articleId, 'article');

        if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['likes' => $likes]));
            return $response;
        }

        return $response->withHeader('Location', $request->getServerParams()['HTTP_REFERER'])->withStatus(302);
    }
}
