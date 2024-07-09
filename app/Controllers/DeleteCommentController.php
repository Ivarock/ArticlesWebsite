<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\CommentService;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteCommentController
{
    private CommentService $commentService;
    private LoggerInterface $logger;

    public function __construct(CommentService $commentService, LoggerInterface $logger)
    {
        $this->commentService = $commentService;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $commentId = (int)$args['comment_id'];
        $this->commentService->deleteComment($commentId);
        $this->logger->info('Deleted a comment', ['comment_id' => $commentId]);

        return $response->withHeader('Location', "/articles/{$args['id']}")->withStatus(302);
    }
}
