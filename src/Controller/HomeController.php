<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home_home')]
    public function home(): Response
    {
        return $this->render('reqilibre/home.html.twig');
    }


    #[Route(path: '/apropos', name: 'app_home_apropos')]
    public function apropos(): Response
    {
        return $this->render('reqilibre/apropos.html.twig');
    }


    #[Route(path: '/soins', name: 'app_home_soins')]
    public function soins(): Response
    {
        return $this->render('reqilibre/soins.html.twig');
    }


    #[Route(path: '/massages', name: 'app_home_massages')]
    public function massages(): Response
    {
        return $this->render('reqilibre/massages.html.twig');
    }


    #[Route(path: '/guidances', name: 'app_home_guidances')]
    public function guidances(): Response
    {
        return $this->render('reqilibre/guidances.html.twig');
    }



    #[Route(path: '/tarifs', name: 'app_home_tarifs')]
    public function tarifs(): Response
    {
        return $this->render('reqilibre/tarifs.html.twig');
    }
}
