<?php

namespace App\Factory;

use App\Entity\Post;
use App\Entity\User;
use App\Dto\PostDto;

class PostFactory
{
    public function createFromDto(PostDto $dto, User $user): Post
    {
        $post = new Post();
        $post->setExternalId($dto->id);
        $post->setTitle($dto->title);
        $post->setBody($dto->body);
        $post->setUser($user);
        return $post;
    }
}
