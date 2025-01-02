<?php

namespace App\Infrastructure\Http\Web\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
class LoginController extends AbstractController
{
    #[Route(
        path: '/api/login',
        name: 'api_login',
        defaults: [
            '_api_resource_class' => TokenStorageInterface::class
        ],
        methods: ['POST'],
    )]
    public function login(TokenStorageInterface $tokenStorage): JsonResponse
    {
        $token = $tokenStorage->getToken();
        $user = $token->getUser();

        return $this->json([
            'message' => sprintf('Welcome to your new controller %s!', $user->getEmail()),
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
}
