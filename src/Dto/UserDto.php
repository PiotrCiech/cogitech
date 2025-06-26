<?php

namespace App\Dto;

class UserDto
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;

    public function __construct(int $id, string $name, string $username, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['username'],
            $data['email']
        );
    }
}