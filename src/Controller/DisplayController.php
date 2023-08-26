<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    #[Route('/display', name: 'app_display')]
    public function display_visits(EntityManagerInterface $entityManagerInterface): Response
    {
        $customerRepository = $entityManagerInterface->getRepository(Customer::class);
        $current_vistors = $customerRepository->findBy(['state'=> 'current']);
        $upcoming_visitors = $customerRepository->findBy(['state' => 'reserved'], ['appointment_time' => 'DESC'], 5);
        return $this->render('display\display.html.twig', [
            'current_visitors' => $current_vistors,
            'upcoming_visitors' => $upcoming_visitors,
        ]);
    }
}
