<?php

namespace App\Controller;

use App\Repository\ClaimRepository;
use App\Repository\OwnerRepository;
use App\Repository\SaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        OwnerRepository $ownerRepository,
        SaleRepository $saleRepository,
        ClaimRepository $claimRepository,
    ): Response {
        $expiring = $saleRepository->findExpiringBetween(new \DateTime(), (new \DateTime())->modify('+30 days'));

        return $this->render('dashboard/index.html.twig', [
            'clientCount' => count($ownerRepository->search(null)),
            'contractCount' => count($saleRepository->search(null)),
            'claimCount' => count($claimRepository->findAll()),
            'expiringContracts' => $expiring,
        ]);
    }
}
