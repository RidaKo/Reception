<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage():Response
    {
        return $this->render('reservation/homepage.html.twig');    
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(): Response
    {

        return $this->render('reservation/reservation.html.twig');
    }
    
    #[Route('/reserved/{$slug}', name:'app_reserved')]
    public function reserved(EntityManagerInterface $entityManagerInterface, Request $request):Response
    {
        $email = $request->request->get('email');
        $customerRepository = $entityManagerInterface->getRepository(Customer::class);
        if(!$customerRepository->findOneBy(['email' => $email]))
        {
        $customer = new Customer();
        $appointment_time = $customerRepository->findCustomerWithLatestAppointmentTime()->getAppointmentTime()->modify('+ 30 minutes');
        $customer->setEmail($request->request->get('email'))
        ->setReservationCode('4236')
        ->setState('reserved')
        ->setAppointmentTime($appointment_time);

        $entityManagerInterface->persist($customer);
        $entityManagerInterface->flush();
        $reservation = true;
        }
        else{
            $customer = $customerRepository->findOneBy(['email' => $email]);
            $reservation=false;
        }

        
        //Calculation
        //$customer = $customerRepository->findOneBy(['email' => ]);
        
        return $this->render('reservation/reserved.html.twig', ['customer' => $customer, 'reservation' => $reservation]);
    }
}
