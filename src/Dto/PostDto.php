<?php

namespace App\Dto;

class PostDto
{
    public int $id;
    public int $userId;
    public string $title;
    public string $body;

    public function __construct(int $id, int $userId, string $title, string $body)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['userId'],
            $data['title'],
            $data['body']
        );
    }
}
