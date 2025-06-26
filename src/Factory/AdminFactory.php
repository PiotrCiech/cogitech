<?php

namespace App\Factory;

use App\Entity\Admin;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $email, string $plainPassword): Admin
    {
        $admin = new Admin();
        $admin->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $plainPassword);
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_ADMIN']);

        return $admin;
    }
}
