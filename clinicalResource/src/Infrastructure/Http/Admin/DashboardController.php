<?php

namespace App\Infrastructure\Http\Admin;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use App\Domain\Entity\User;
use App\Domain\Repository\DoctorRepositoryInterface;
use App\Domain\Repository\MedicalCenterRepositoryInterface;
use App\Domain\Repository\SpecialityRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

#[AsController]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private DoctorRepositoryInterface $doctorRepository,
        private MedicalCenterRepositoryInterface $medicalCenterRepository,
        private SpecialityRepositoryInterface $specialistRepository,
        private UserRepositoryInterface $userRepository

    )
    {
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function index(): Response
    {
//        return parent::index();
//        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
//
//        $chart->setData([
//            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
//            'datasets' => [
//                [
//                    'label' => 'My First dataset',
//                    'backgroundColor' => 'rgb(255, 99, 132)',
//                    'borderColor' => 'rgb(255, 99, 132)',
//                    'data' => [0, 10, 5, 2, 20, 30, 45],
//                ],
//            ],
//        ]);
//
//        $chart->setOptions([
//            'scales' => [
//                'y' => [
//                    'suggestedMin' => 0,
//                    'suggestedMax' => 100,
//                ],
//            ],
//        ]);
//
//
//        return $this->render('admin/my-dashboard.html.twig', [
//            'chart' => $chart,
//        ]);


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //


        return $this->render('admin/my-dashboard.html.twig', [
            'chart' => $this->datasets()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Clinic Resource');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToUrl('Web', 'fa fa-globe', $this->generateUrl('app_home')),
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToLogout('Logout', 'fa fa-xmark'),

            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),

            MenuItem::section('Doctors'),
            MenuItem::linkToCrud('Doctors', 'fa fa-user-doctor', Doctor::class),

            MenuItem::section('Medical Center'),
            MenuItem::linkToCrud('Medical Center', 'fa fa-hospital', MedicalCenter::class),

            MenuItem::section('Specialities'),
            MenuItem::linkToCrud('Specialities', 'fa fa-heart', Speciality::class),


        ];
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();

        $assets->addAssetMapperEntry('app');

        return $assets;
    }

    private function createChartStatisticsDefault()
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/my-dashboard.html.twig', [
            'chart' => $chart,
        ]);
    }

    private function datasets()
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_DOUGHNUT);

        $doctors = $this->doctorRepository->totalItems();
        $medicalCenter = $this->medicalCenterRepository->totalItems();
        $specialist = $this->specialistRepository->totalItems();
        $users = $this->userRepository->totalItems();

        $data = [$doctors, $medicalCenter, $specialist, $users];
        $labels = ['Doctors', 'Medical Centers', 'Specialists', 'Users'];
        $backgroundColors = ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(163,221,203,0.2)'];

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Statistics',
                    'data' => $data, // Valores finales
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(163,221,203,1)'],
                    'borderWidth' => 1,
                    'barThickness' => 50, // Ajusta el grosor de las barras
                    'barPercentage' => 0.8, // Reduce el espacio entre barras (valor menor = más juntas)
                ],
            ],
        ]);

        $chart->setOptions([
                'responsive' => true,
                'animation' => [
                    'duration' => 8000, // Duración de la animación en ms
                    'easing' => 'easeOutBounce',
                    'from' => 0, // Comienza desde 0
                ],
//                'scales' => [
//                    'x' => ['display' => true, 'ticks' => ['stepSize' => 50]],
//                    'y' => ['display' => false], // Ocultar eje Y
//                ],
                'plugins' => [
                    'legend' => ['display' => true], // Opcional: Oculta la leyenda
                    'tooltip' => ['enabled' => true],

                ],
                'layout' => [
                    'padding' => 10, // Añade un poco de espacio alrededor del gráfico
                ],
                'width' => 200, // Ancho personalizado del gráfico
                'height' => 100, // Altura personalizada del gráfico
            ]
        );


        return $chart;

    }
}
