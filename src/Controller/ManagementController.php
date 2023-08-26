<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagementController extends AbstractController
{
    #[Route('/management', name: 'app_management')]
    public function index(): Response
    {
        return $this->render('management/management_home.html.twig', [
            'controller_name' => 'ManagementController',
        ]);
    }
}
