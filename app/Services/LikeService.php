<?php

namespace ArticlesWebsite\Services;

use ArticlesWebsite\Models\Like;
use ArticlesWebsite\Repositories\LikeRepository;
use Doctrine\DBAL\Exception;

class LikeService
{
    private LikeRepository $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * @throws Exception
     */
    public function likeItem(int $itemId, string $itemType): Like
    {
        $like = new Like($itemId, $itemType);
        $this->likeRepository->save($like);
        return $like;
    }
}
