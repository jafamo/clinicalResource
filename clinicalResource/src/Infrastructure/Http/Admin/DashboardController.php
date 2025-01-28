<?php

namespace App\Infrastructure\Http\Admin;

use App\Domain\Entity\Doctor;
use App\Domain\Entity\MedicalCenter;
use App\Domain\Entity\Speciality;
use App\Domain\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[AsController]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder
    ) {
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
         return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Clinic Resource');
    }

    public function configureMenuItems(): iterable
    {
        return [
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
}
