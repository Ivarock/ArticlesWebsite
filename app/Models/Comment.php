<?php

namespace ArticlesWebsite\Models;

use DateTime;

class Comment
{
    private ?int $id = null;
    private int $articleId;
    private string $content;
    private string $author;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    public int $likes = 0;

    public function __construct(int $articleId, string $content, string $author, ?int $id = null)
    {
        $this->articleId = $articleId;
        $this->content = $content;
        $this->author = $author;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
