<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/posts')]
#[IsGranted('ROLE_USER')]
class PostController extends AbstractController
{
    #[Route('', name: 'post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/{id}', name: 'post_delete', methods: ['DELETE'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $post->getId(), $submittedToken)) {
            $em->remove($post);
            $em->flush();

            $this->addFlash('success', 'Post został usunięty.');
        }

        return $this->redirectToRoute('post_index');
    }
}
