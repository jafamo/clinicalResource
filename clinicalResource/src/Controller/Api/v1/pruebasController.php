<?php

namespace App\Controller\Api\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/api/v1/pruebas',  name: 'pruebas')]
class pruebasController extends AbstractController
{
    #[Route('/javier')]
    public function javier(TokenStorageInterface $tokenStorage)
    {
        $token = $tokenStorage->getToken();

        $user = $token->getUser();

        if ($user) {
            var_dump($user);
            die('login ok');
        }
        die('login KO');

        $number = random_int(0, 100);
        return new JsonResponse($number);
    }
}