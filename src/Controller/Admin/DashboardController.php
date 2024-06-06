<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
<<<<<<< HEAD
        return parent::index();
        // $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        // In line below, replace [EntityHere] by the entity you want to see on the site when clicking on
        // "back to the website" from Admin Dashboard

        // $url = $routeBuilder->setController(User::class)->generateUrl();

        // return $this->redirect($url);
=======
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        // In line below, replace [EntityHere] by the entity you want to see on the site when clicking on
        // "back to the website" from Admin Dashboard

        // $url = $routeBuilder->setController([EntityHere]::class)->generateUrl();

        return $this->redirect($url);
>>>>>>> 9500b51 (preconfiguring admin dashboard)
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Kata Pictures App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-picture', 'Picutres');

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
