<?php

namespace App\Controller;

use App\Repository\ClaimRepository;
use App\Repository\CustomerRepository;
use App\Repository\SaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_EMPLOYEE')]
final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        CustomerRepository $customerRepository,
        SaleRepository $saleRepository,
        ClaimRepository $claimRepository,
    ): Response {
        $expiring = $saleRepository->findExpiringBetween(new \DateTime(), (new \DateTime())->modify('+30 days'));

        return $this->render('dashboard/index.html.twig', [
            'customerCount' => count($customerRepository->search(null)),
            'contractCount' => count($saleRepository->search(null)),
            'claimCount' => count($claimRepository->findAll()),
            'expiringContracts' => $expiring,
        ]);
    }
}
