<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Repository\SpecialistRepository;
use App\Service\HolidayApi;
use DateTime;
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
    public function reserved(MailerInterface $mailerInterface, EntityManagerInterface $entityManagerInterface, Request $request, HolidayApi $holidayApi, SpecialistRepository $specialistRepository):Response
    {
        $email = $request->request->get('email');
        $customerRepository = $entityManagerInterface->getRepository(Customer::class);
        if(!$customerRepository->findOneBy(['email' => $email]) || in_array($customerRepository->findOneBy( ['email'=>$email])->getState(), ['finished', 'cancelled']))
        {
            if($customerRepository->findAll() == [] || $customerRepository->findBy(['state' => 'reserved']) == null )
            {
                $appointment_time = new DateTime();
                $specialist_array= $specialistRepository->findAll();
                $specialist = $specialist_array[array_rand($specialist_array)];
            }
            else
            {
                $latest_customer = $customerRepository->findCustomerWithLatestAppointmentTime();
                $appointment_time = $latest_customer->getAppointmentTime()->modify('+ 30 minutes');
                $specialist = $latest_customer->getSpecialist();
            }
            

            if($appointment_time>= new \DateTime($appointment_time->format('Y-m-d').'19:00:00') && $appointment_time>=(new \DateTime(($appointment_time->format('Y-m-d'.'06:00:00'))))->modify('+1 day'))
            {
                $appointment_time = (new \DateTime(($appointment_time->format('Y-m-d'.'06:00:00'))))->modify('+1 day');
            }


            if($holidayApi->checkIfReservationTimeIsHoliday($appointment_time))
            {
                $appointment_time = $appointment_time->modify('+1 day');
                //return $this->render('reservation/reservation.html.twig', ['holday' => true]);
            }

            $rez_code = $customerRepository->getLatestReservationNrPlusOne();
            
            
            $customer = new Customer();
            $customer->setEmail($request->request->get('email'))
            ->setReservationCode($rez_code)
            ->setState('reserved')
            ->setAppointmentTime($appointment_time)
            ->setSpecialist($specialist);

            $entityManagerInterface->persist($customer);
            $entityManagerInterface->flush();
            $reservation = true;

            $email = (new Email())
            ->from('testporator@gmail.com')
            ->to($request->request->get('email'))
            ->subject('Registration confirmation')
            ->html("<html> <h2>Reservation complete</h2> <br> Your reservation code: <b>{$customer->getReservationCode()}.</b> </html>");
            //dd($email);
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
