<?php

namespace Tests\Service;

use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Service\JsonPlaceholderClientService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class JsonPlaceholderClientServiceTest extends TestCase
{
    public function testFetchPostsReturnsPostDtoArray()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $samplePosts = [
            ['userId' => 1, 'id' => 1, 'title' => 'title1', 'body' => 'body1'],
            ['userId' => 2, 'id' => 2, 'title' => 'title2', 'body' => 'body2'],
        ];

        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://jsonplaceholder.typicode.com/posts')
            ->willReturn($response);

        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($samplePosts);

        $client = new JsonPlaceholderClientService($httpClient, 'https://jsonplaceholder.typicode.com');

        $posts = $client->fetchPosts();

        $this->assertIsArray($posts);
        $this->assertCount(2, $posts);
        $this->assertContainsOnlyInstancesOf(PostDto::class, $posts);
        $this->assertEquals(1, $posts[0]->userId);
    }

    public function testFetchUsersReturnsUserDtoArray()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $sampleUsers = [
            ['id' => 1, 'name' => 'John Doe', 'username' => 'johnd', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Roe', 'username' => 'janer', 'email' => 'jane@example.com'],
        ];

        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'https://jsonplaceholder.typicode.com/users')
            ->willReturn($response);

        $response->expects($this->once())
            ->method('toArray')
            ->willReturn($sampleUsers);

        $client = new JsonPlaceholderClientService($httpClient, 'https://jsonplaceholder.typicode.com');

        $users = $client->fetchUsers();

        $this->assertIsArray($users);
        $this->assertCount(2, $users);
        $this->assertContainsOnlyInstancesOf(UserDto::class, $users);
        $this->assertEquals('John Doe', $users[0]->name);
    }
}
