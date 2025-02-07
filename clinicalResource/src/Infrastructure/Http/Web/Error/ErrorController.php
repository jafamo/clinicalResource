<?php

namespace App\Infrastructure\Http\Web\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ErrorController extends AbstractController
{
    #[Route('/error/{code}', name: 'error_page')]
    public function showError(int $code): Response
    {
        $messages = [
            404 => 'Página no encontrada',
            403 => 'Acceso denegado',
        ];

        return $this->render('web/error/error.html.twig', [
            'code' => $code,
            'message' => $messages[$code] ?? 'Ha ocurrido un error',
        ]);
    }

}