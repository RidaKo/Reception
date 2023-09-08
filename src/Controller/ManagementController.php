<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\SpecialistType;
use App\Repository\CustomerRepository;
use App\Repository\SpecialistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Doctrine\Collections\CollectionAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ManagementController extends AbstractController
{
    #[Route('/management', name: 'app_management')]
    #[IsGranted('ROLE_SPECIALIST')]
    public function management(Request $request, CustomerRepository $customerRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $error = null;
        $specialist = $this->getUser();
        $customers = $specialist->getCustomers();
        $command = $request->query->get('command');
        $customer = $customerRepository->findOneBy(['id'=> $request->query->get('id')]);

        if($command !=null && $customer != null)
        {
            if($command == 'current')
            {
                foreach ($customers as $person)
                {
                    if($person->getState() == 'current')
                    {
                        
                        $error = 'There is another person currentlly visiting';
                    }
                }
            }
            
            if($error == null)
            {
                $customer->setState($command);
                $entityManagerInterface->flush();
            }
        }
        
        $adapter = new CollectionAdapter($customers);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(3);
        $pagerfanta->setCurrentPage($request->query->get('page', 1));


        return $this->render('management/home.html.twig', [ 'pager' => $pagerfanta, 'error' => $error
        ]);
    }

    #[Route('/management/registration', name: 'app_management_registration')]
    public function managementRegistration(Request $request, SpecialistRepository $specialistRepository, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        
        $form = $this->createForm(SpecialistType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $specialist_from_form = $form->getData();
            if($specialistRepository->findIfSpecialistIsAuthorized($specialist_from_form->getSecretKey()))
            {
                $specialist = $specialistRepository->findOneBy(['secretKey'=>$specialist_from_form->getSecretKey()]);
                $specialist->setEmail($specialist_from_form->getEmail());
                $hashed_password = $userPasswordHasherInterface->hashPassword($specialist, $specialist_from_form->getPassword());
                $specialist->setPassword($hashed_password);
                
                $entityManagerInterface->persist($specialist);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('app_registration_successful');
            }
            else
            {
            return $this->render('management/registration.html.twig', [
                'form' => $form->createView(),
                'auth_string' => 'Problems with authorization.'
            ]);

            }   
        }
        return $this->render('management/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/management/registration_success', name: 'app_registration_successful')]
    public function registrationSuccessful():Response
    {
        return $this->render('management/registration_success.html.twig', [
        ]);
    }


}
