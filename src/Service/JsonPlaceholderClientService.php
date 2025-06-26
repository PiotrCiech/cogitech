<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Dto\PostDto;
use App\Dto\UserDto;

class JsonPlaceholderClientService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $baseUrl
    ) {
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    /**
     * @return PostDto[]
     */
    public function fetchPosts(): array
    {
        $response = $this->httpClient->request('GET', $this->baseUrl.'/posts');
        $data = $response->toArray();

        return array_map(fn(array $item) => PostDto::fromArray($item), $data);
    }

    /**
     * @return UserDto[]
     */
    public function fetchUsers(): array
    {
        $response = $this->httpClient->request('GET', $this->baseUrl.'/users');
        $data = $response->toArray();

        return array_map(fn(array $item) => UserDto::fromArray($item), $data);
    }
}