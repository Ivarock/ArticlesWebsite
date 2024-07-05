<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\DeleteArticleService;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteArticleController
{
    private DeleteArticleService $deleteService;
    private LoggerInterface $logger;

    public function __construct(DeleteArticleService $deleteService, LoggerInterface $logger)
    {
        $this->deleteService = $deleteService;
        $this->logger = $logger;
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];
        $this->deleteService->delete($id);
        $this->logger->info('Deleted article', ['id' => $id]);

        return $response->withHeader('Location', '/articles')->withStatus(302);
    }
}
