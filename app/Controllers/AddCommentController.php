<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\CommentService;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddCommentController
{
    private CommentService $commentService;
    private LoggerInterface $logger;

    public function __construct(CommentService $commentService, LoggerInterface $logger)
    {
        $this->commentService = $commentService;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $data = $request->getParsedBody();
        $content = $data['content'] ?? '';
        $author = $data['author'] ?? '';

        $this->commentService->addComment($id, $content, $author);
        $this->logger->info('Added a new comment', ['article_id' => $id]);

        return $response->withHeader('Location', "/articles/$id")->withStatus(302);
    }
}
