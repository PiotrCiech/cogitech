<?php

namespace App\Factory;

use App\Entity\User;
use App\Dto\UserDto;

class UserFactory
{
    public function createFromDto(UserDto $dto): User
    {
        $user = new User();
        $user->setName($dto->name);
        $user->setUsername($dto->username);
        $user->setEmail($dto->email);

        return $user;
    }
}
