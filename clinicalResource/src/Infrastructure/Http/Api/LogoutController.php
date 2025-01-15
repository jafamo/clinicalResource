<?php

namespace App\Infrastructure\Http\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class LogoutController extends AbstractController
{
    #[Route('/api/logout', name: 'api_logout', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('should not be reached');
    }
}
