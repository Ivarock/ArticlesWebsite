<?php

namespace ArticlesWebsite\Services;

use ArticlesWebsite\Models\Comment;
use ArticlesWebsite\Repositories\CommentRepository;
use Doctrine\DBAL\Exception;

class CommentService
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function addComment(int $articleId, string $content, string $author): void
    {
        $comment = new Comment($articleId, $content, $author);
        $this->commentRepository->save($comment);
    }

    /**
     * @throws Exception
     */
    public function deleteComment(int $commentId): void
    {
        $this->commentRepository->delete($commentId);
    }
}
