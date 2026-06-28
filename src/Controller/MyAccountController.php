<?php

namespace App\Controller;

use App\Entity\Crm\User;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/my')]
#[IsGranted('ROLE_CUSTOMER')]
final class MyAccountController extends AbstractController
{
    #[Route('', name: 'app_my_account')]
    public function show(CustomerRepository $customerRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User || $user->getStateId() === null) {
            throw $this->createAccessDeniedException('No customer record linked to this account.');
        }

        $customer = $customerRepository->find($user->getStateId());
        if (!$customer) {
            throw $this->createNotFoundException('Customer record not found.');
        }

        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
            'readOnly' => true,
        ]);
    }
}
