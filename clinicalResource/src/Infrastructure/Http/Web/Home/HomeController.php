<?php

namespace App\Infrastructure\Http\Web\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/', name: 'app_index')]
    public function index()
    {
        return $this->redirectToRoute('app_home');
    }

}