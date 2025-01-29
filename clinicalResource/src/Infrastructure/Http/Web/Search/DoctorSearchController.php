<?php

namespace App\Infrastructure\Http\Web\Search;

use App\Application\Service\SearchDoctorsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DoctorSearchController extends AbstractController
{
    private SearchDoctorsService $searchDoctorsService;

    public function __construct(SearchDoctorsService $searchDoctorsService)
    {
        $this->searchDoctorsService = $searchDoctorsService;
    }

    #[Route('/doctors/search', name: 'app_doctor_search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        $specialty = $request->query->get('specialty');

        $doctors = $this->searchDoctorsService->execute($name, $specialty);


        return new JsonResponse($doctors);
    }

}