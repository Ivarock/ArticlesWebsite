<?php

namespace ArticlesWebsite\Controllers;

use ArticlesWebsite\Services\EditArticleService;
use ArticlesWebsite\Repositories\ArticleRepositoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ArticlesWebsite\Services\TemplateRenderer;

class EditArticleController
{
    private EditArticleService $editService;
    private ArticleRepositoryInterface $articleRepository;
    private LoggerInterface $logger;
    private TemplateRenderer $renderer;

    public function __construct(
        EditArticleService $editService,
        ArticleRepositoryInterface $articleRepository,
        LoggerInterface $logger,
        TemplateRenderer $renderer
    ) {
        $this->editService = $editService;
        $this->articleRepository = $articleRepository;
        $this->logger = $logger;
        $this->renderer = $renderer;
    }

    /**
     * @throws \Exception
     */
    public function edit(Request $request, Response $response, array $args): Response
    {
        $id = (int)$args['id'];

        if ($request->getMethod() === 'GET') {
            $article = $this->articleRepository->find($id);
            return $this->renderer->render($response, 'articles/edit.twig', ['article' => $article]);
        }

        $data = $request->getParsedBody();
        $title = $data['title'] ?? '';
        $content = $data['content'] ?? '';

        $this->editService->edit($id, $title, $content);
        $this->logger->info('Edited article', ['id' => $id]);

        return $response->withHeader('Location', '/articles')->withStatus(302);
    }
}
