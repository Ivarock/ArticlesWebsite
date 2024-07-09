<?php

namespace ArticlesWebsite\Models;

use DateTime;

class Like
{
    private int $id;
    private int $item_id;
    private string $item_type;
    private DateTime $created_at;

    public function __construct(
        int $item_id,
        string $item_type,
        ?DateTime $created_at = null
    ) {
        $this->item_id = $item_id;
        $this->item_type = $item_type;
        $this->created_at = $created_at ?? new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getItemId(): int
    {
        return $this->item_id;
    }

    public function setItemId(int $item_id): void
    {
        $this->item_id = $item_id;
    }

    public function getItemType(): string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): void
    {
        $this->item_type = $item_type;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
