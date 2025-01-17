<?php

namespace App\Infrastructure\Http\Web\Search;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request)
    {
        $googleMapsApiKey = $this->getParameter('google_maps_api_key');


        return $this->render('search/index.html.twig',
            [
                'google_maps_api_key' => $googleMapsApiKey

            ]);
    }
}