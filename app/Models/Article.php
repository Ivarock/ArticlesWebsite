<?php

namespace ArticlesWebsite\Models;

use DateTime;
use DateTimeZone;
use Exception;
use JsonSerializable;

class Article implements JsonSerializable
{
    private int $id;
    private string $title;
    private string $content;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int       $id,
        string    $title,
        string    $content,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    )
    {
        $timeZone = new DateTimeZone('Europe/Riga');
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt ? $createdAt->setTimezone($timeZone) : new DateTime();
        $this->updatedAt = $updatedAt ? $updatedAt->setTimezone($timeZone) : new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
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

    /**
     * @throws Exception
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
        $this->updatedAt = new DateTime('now', new DateTimeZone('Europe/Riga'));
    }

    /**
     * @throws Exception
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
        $this->updatedAt = new DateTime('now', new DateTimeZone('Europe/Riga'));
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('D jS F, Y H:i'),
            'updatedAt' => $this->updatedAt->format('D jS F, Y H:i'),
        ];
    }
}
