<?php

namespace App\Infrastructure\Http\Web\Search;

use App\Application\Service\SearchDoctorsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class SearchController extends AbstractController
{
    private SearchDoctorsService $searchDoctorsService;

    public function __construct(SearchDoctorsService $searchDoctorsService)
    {
        $this->searchDoctorsService = $searchDoctorsService;
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request)
    {
        $googleMapsApiKey = $this->getParameter('google_maps_api_key');
        $name = $request->query->get('name');
        $specialty = $request->query->get('specialty');
        $doctors = $this->searchDoctorsService->execute($name);

        return $this->render('web/search/index.html.twig',
            [
                'google_maps_api_key' => $googleMapsApiKey,
                'doctors' => $doctors,

            ]);
    }
}