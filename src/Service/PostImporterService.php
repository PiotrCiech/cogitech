<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostImporterService
{
    public function __construct(
        private JsonPlaceholderClientService $jsonPlaceholderClient,
        private UserFactory $userFactory,
        private PostFactory $postFactory,
        private UserRepository $userRepository,
        private PostRepository $postRepository,
        private EntityManagerInterface $em
    ) {}

    public function import(): void
    {
        $userDtos = $this->jsonPlaceholderClient->fetchUsers();
        $postDtos = $this->jsonPlaceholderClient->fetchPosts();

        $usersMap = $this->synchronizeUsers($userDtos);
        $this->synchronizePosts($postDtos, $usersMap);

        $this->em->flush();
    }

    private function synchronizeUsers(array $userDtos): array
    {
        $usersMap = [];

        foreach ($userDtos as $userDto) {
            $user = $this->userRepository->findOneBy(['email' => $userDto->email]);

            if (!$user) {
                $user = $this->userFactory->createFromDto($userDto);
                $this->em->persist($user);
            }

            $usersMap[$userDto->id] = $user;
        }

        return $usersMap;
    }

    private function synchronizePosts(array $postDtos, array $usersMap): void
    {
        foreach ($postDtos as $postDto) {
            $user = $usersMap[$postDto->userId] ?? null;
            if (!$user) {
                continue;
            }

            $existingPost = $this->postRepository->findOneBy(['externalId' => $postDto->id]);
            if ($existingPost) {
                continue;
            }

            $post = $this->postFactory->createFromDto($postDto, $user);
            $this->em->persist($post);
        }
    }
}
