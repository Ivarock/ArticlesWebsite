<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\LikeService;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LikeCommentController
{
    private LikeService $likeService;
    private LoggerInterface $logger;

    public function __construct(LikeService $likeService, LoggerInterface $logger)
    {
        $this->likeService = $likeService;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->likeService->likeItem((int)$args['comment_id'], 'comment');
        $this->logger->info('Liked a comment', ['comment_id' => $args['comment_id']]);

        return $response->withHeader('Location', "/articles/{$args['id']}")->withStatus(302);
    }
}
