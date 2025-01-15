<?php

namespace App\Infrastructure\Http\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/api/v1/pruebas', name: 'api_pruebas_')]
class pruebasController extends AbstractController
{
    #[Route('/javier')]
    public function javier(TokenStorageInterface $tokenStorage)
    {
        $number = random_int(0, 100);
        return new JsonResponse($number);
    }
}
