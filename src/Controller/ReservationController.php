<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\HolidayApi;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

use function Zenstruck\Foundry\faker;

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
    
    #[Route('/reserved', name:'app_reserved')]
    public function reserved(MailerInterface $mailerInterface, EntityManagerInterface $entityManagerInterface, Request $request, HolidayApi $holidayApi):Response
    {
        $email = $request->request->get('email');
        $customerRepository = $entityManagerInterface->getRepository(Customer::class);
        if(!$customerRepository->findOneBy(['email' => $email]))
        {
        $appointment_time = $customerRepository->findCustomerWithLatestAppointmentTime()->getAppointmentTime()->modify('+ 30 minutes');
        
        if($holidayApi->checkIfReservationTimeIsHoliday($appointment_time))
        {
            $appointment_time = $appointment_time->modify('+1 day');
            //return $this->render('reservation/reservation.html.twig', ['holday' => true]);
        }
        
        $customer = new Customer();
        $customer->setEmail($request->request->get('email'))
        ->setReservationCode(faker()->regexify('[A-Z0-9]{10}'))
        ->setState('reserved')
        ->setAppointmentTime($appointment_time);

        $entityManagerInterface->persist($customer);
        $entityManagerInterface->flush();
        $reservation = true;

        $email = (new Email())
        ->from('mail@mailer.com')
        ->to($request->request->get('email'))
        ->subject('Registration confirmation')
        ->text("Your reservation code {$customer->getReservationCode()}.");
        //dump($email);
        $mailerInterface->send($email);

        }
        else{
            $customer = $customerRepository->findOneBy(['email' => $email]);
            $reservation=false;
        }

        
        //Calculation
        //$customer = $customerRepository->findOneBy(['email' => ]);
        
        return $this->render('reservation/reserved.html.twig', ['customer' => $customer, 'reservation' => $reservation]);
    }

    #[Route("/reserved/cancelled",name:"app_cancel_visit")]
    public function cancel_visit(EntityManagerInterface $entityManagerInterface, Request $request):Response
    {
        $email = $request->query->get('email');
        $customer = $entityManagerInterface->getRepository(Customer::class)->findOneBy(['email'=>$email]);
        $customer->setState('cancelled');
        $entityManagerInterface->flush();
        return $this->render('reservation/cancelled.html.twig', ['customer' => $customer]);
    }
    #[Route("/reserved/download-pdf",name:"app_print_pdf")]

    public function download_pdf(Pdf $knpSnappyPdf, Request $request, EntityManagerInterface $entityManagerInterface): PdfResponse
    {
        $email = $request->query->get('email');
        $customer = $entityManagerInterface->getRepository(Customer::class)->findOneBy(['email'=>$email]);
        $html = $this->renderView('reservation/pdf.html.twig',[
            'customer'  => $customer
        ]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'reservation.pdf'
        );
    }
}
